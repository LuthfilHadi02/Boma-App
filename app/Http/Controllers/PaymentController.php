<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // =========================================================================
    // SHOW: Halaman pembayaran — tampilkan snap popup Midtrans
    // =========================================================================
    public function show($id)
    {
        // Ambil data payment beserta relasi booking dan fasilitas
        $payment = Payment::with('booking.facility')->findOrFail($id);

        // Pastikan hanya pemilik booking yang bisa akses halaman ini
        if ($payment->booking->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak.');
        }

        // Kalau sudah dibayar, langsung ke halaman sukses
        if ($payment->status === 'paid') {
            return redirect()->route('payment.success', $payment->id);
        }

        $clientKey = config('midtrans.client_key');

        return view('payment', compact('payment'));
    }

   // =========================================================================
    // CALLBACK: Webhook dari Midtrans — dipanggil otomatis setelah user bayar
    // =========================================================================
    public function callback(Request $request)
    {
        // 0. LOG UNTUK DEBUG NGROK (Biar keliatan di laravel.log pas ditest)
        \Log::info('Midtrans Webhook Masuk!', $request->all());

        $serverKey   = config('midtrans.server_key');
        $orderId     = $request->order_id;
        $statusCode  = $request->status_code;
        $grossAmount = $request->gross_amount;

        // 1. VERIFIKASI SIGNATURE — Pastikan request benar-benar dari Midtrans
        $signatureKey = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        if ($signatureKey !== $request->signature_key) {
            \Log::warning('Midtrans Webhook: Invalid Signature');
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // 2. CARI PAYMENT BERDASARKAN ORDER ID
        $payment = Payment::where('midtrans_order_id', $orderId)->first();

        if (!$payment) {
            \Log::error('Midtrans Webhook: Payment NOT FOUND untuk Order ID ' . $orderId);
            return response()->json(['message' => 'Payment not found'], 404);
        }

        // 3. UPDATE STATUS BERDASARKAN NOTIFIKASI MIDTRANS
        $transactionStatus = $request->transaction_status;
        $fraudStatus       = $request->fraud_status ?? 'accept';

        if (($transactionStatus === 'capture' && $fraudStatus === 'accept') || $transactionStatus === 'settlement') {
            
            // Cara aman langsung update ke database via Eloquent
            $payment->update(['status' => 'paid']);
            $payment->booking()->update(['status' => 'confirmed']); // Pakai tanda kurung ()

        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            
            $payment->update(['status' => 'failed']);
            $payment->booking()->update(['status' => 'cancelled']); // Pakai tanda kurung ()

        } elseif ($transactionStatus === 'pending') {
            
            $payment->update(['status' => 'pending']);
            
        }

        return response()->json(['message' => 'OK']);
    }
    // =========================================================================
    // SUCCESS: Halaman konfirmasi pembayaran berhasil
    // =========================================================================
    public function success($id)
    {
        $payment = Payment::with('booking.facility')->findOrFail($id);

        if ($payment->booking->user_id !== auth()->id()) {
            abort(403);
        }

        return view('payment-success', compact('payment'));
    }
}