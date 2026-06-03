<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mitra;
use App\Models\Booking; // Pastikan model Booking sudah ada nanti

class MitraDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Mengambil data profil mitra berdasarkan user_id yang sedang login
        $mitraProfile = Mitra::where('user_id', $user->id)->first();

        // Data dummy sementara untuk statistik (nanti bisa dihubungkan ke tabel bookings/venues)
        $stat = [
            'total_venues' => $mitraProfile ? 3 : 0, // Misal jumlah lapangan
            'active_bookings' => 5,                  // Misal booking aktif
            'balance' => 250000,                     // Misal saldo pendapatan mitra
        ];

        return view('mitra.dashboard', compact('user', 'mitraProfile', 'stat'));
    }
}