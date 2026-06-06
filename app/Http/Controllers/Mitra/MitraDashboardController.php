<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mitra;
use App\Models\Facility;
use App\Models\Booking;
use App\Models\Payment;

class MitraDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Mengambil data profil mitra berdasarkan user_id yang sedang login
        $mitraProfile = Mitra::where('user_id', $user->id)->first();

        // Amankan sistem bray, kalau akun user ini belum ke-link ke profil mitra biar gak crash property of null
        $mitraId = $mitraProfile ? $mitraProfile->id : 0;

        // 📊 SELESAI SUCI: Hitung statistik asli dari database real-time!
        $stat = [
            // 1. Hitung total lapangan asli milik mitra ini
            'total_venues' => $mitraProfile 
                ? Facility::where('mitra_id', $mitraId)->count() 
                : 0,

            // 2. Hitung jumlah bookingan aktif (pending/confirmed) khusus di lapangan milik mitra ini
            'active_bookings' => $mitraProfile 
                ? Booking::whereIn('status', ['pending', 'confirmed'])
                    ->whereHas('facility', function($query) use ($mitraId) {
                        $query->where('mitra_id', $mitraId);
                    })->count()
                : 0,

            // 3. Hitung total saldo pendapatan asli dari pembayaran Midtrans yang udah sukses ('settlement')
            'balance' => $mitraProfile 
                ? Payment::where('status', 'paid')
                    ->whereHas('booking.facility', function($query) use ($mitraId) {
                        $query->where('mitra_id', $mitraId);
                    })->sum('amount')
                : 0,
        ];

        // Kembalikan data utuh tanpa merusak compact asli bawaan project lu
        return view('mitra.dashboard', compact('user', 'mitraProfile', 'stat'));
    }
}