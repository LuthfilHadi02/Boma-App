<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Refund;
use Illuminate\Http\Request;

class PaymentManagementController extends Controller
{
    // Cukup satu fungsi index untuk menampilkan semua data di satu halaman
    public function index()
    {
        $payments = Payment::with('booking.user')->latest()->get();
        $refunds = Refund::with('payment.booking.user')->latest()->get();

        // Kita kirim kedua data ke satu file view yang sama
        return view('admin.payments.index', compact('payments', 'refunds'));
    }

    // Aksi Admin Setujui Refund
    public function approveRefund($id)
    {
        $refund = Refund::findOrFail($id);
        $refund->status = 'approved';
        $refund->save();

        $payment = $refund->payment;
        $payment->status = 'refunded'; 
        $payment->save();

        return back()->with('success', 'Refund berhasil disetujui!');
    }

    // Aksi Admin Tolak Refund
    public function rejectRefund(Request $request, $id)
    {
        $request->validate(['admin_note' => 'required|string']);

        $refund = Refund::findOrFail($id);
        $refund->status = 'rejected';
        $refund->admin_note = $request->admin_note;
        $refund->save();

        return back()->with('success', 'Pengajuan refund berhasil ditolak.');
    }
}