<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // =========================================================================
    // SHOW: Tampilkan halaman detail lapangan + form booking
    // =========================================================================
    public function show($id)
    {
        // Tarik data lapangan berdasarkan ID, sekalian angkut data relasi Mitranya
        $facility = Facility::with('mitra')->findOrFail($id);
        
        // Lempar variabel $facility ke dalam file blade detail-lapangan
        return view('detail-lapangan', compact('facility'));
    }

    // =========================================================================
    // STORE: Proses simpan transaksi booking mahasiswa ke database
    // =========================================================================
    public function store(Request $request)
    {
        // 1. VALIDASI INPUT FORM BOOKING
        $request->validate([
            'facility_id'  => 'required|exists:facilities,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'start_time'   => 'required|string',
            'jumlah_sesi'  => 'required|integer|min:1|max:8',
        ]);

        // 2. AMBIL DATA LAPANGAN UNTUK HITUNG TOTAL HARGA
        $facility = Facility::findOrFail($request->facility_id);

        // 3. HITUNG TOTAL HARGA (harga per jam × jumlah sesi)
        $totalPrice = $facility->price_per_hour * $request->jumlah_sesi;

        // 4. SIMPAN DATA BOOKING KE DATABASE
        $booking = Booking::create([
            'user_id'      => auth()->id(),
            'facility_id'  => $facility->id,
            'booking_date' => $request->booking_date,
            'start_time'   => $request->start_time,
            'jumlah_sesi'  => $request->jumlah_sesi,
            'total_price'  => $totalPrice,
            'status'       => 'pending', // Menunggu pembayaran
        ]);

        // 5. OTOMATIS BUAT RECORD PAYMENT (Status awal: pending)
        Payment::create([
            'booking_id' => $booking->id,
            'amount'     => $totalPrice,
            'status'     => 'pending',
        ]);

        // 6. REDIRECT KE HALAMAN SUKSES DENGAN PESAN
        return redirect()->route('booking.detail', $facility->id)
            ->with('success', 'Yeay! Booking lapangan berhasil dicatat. Silakan lakukan pembayaran untuk mengkonfirmasi sesi kamu.');
    }
}