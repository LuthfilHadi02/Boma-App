<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
    public function index()
    {
        $now = now();
        $lastMonth = now()->subMonth();

        // 1. Data Booking (Sesi)
        $totalBooking = Booking::count();
        $bookingsBulanIni = Booking::whereYear('created_at', $now->year)->whereMonth('created_at', $now->month)->count();
        $bookingsBulanLalu = Booking::whereYear('created_at', $lastMonth->year)->whereMonth('created_at', $lastMonth->month)->count();
        $persenBooking = ($bookingsBulanLalu > 0) ? (($bookingsBulanIni - $bookingsBulanLalu) / $bookingsBulanLalu) * 100 : 0;

        // 2. Data Pendapatan (Escrow) - Disinkronkan dengan nama totalPendapatan
        $totalPendapatan = Payment::where('status', 'paid')->sum('amount'); // Total keseluruhan
        $pendapatanBulanIni = Payment::where('status', 'paid')->whereYear('created_at', $now->year)->whereMonth('created_at', $now->month)->sum('amount');
        $pendapatanBulanLalu = Payment::where('status', 'paid')->whereYear('created_at', $lastMonth->year)->whereMonth('created_at', $lastMonth->month)->sum('amount');
        $persenPendapatan = ($pendapatanBulanLalu > 0) ? (($pendapatanBulanIni - $pendapatanBulanLalu) / $pendapatanBulanLalu) * 100 : 0;

// 3. Data Mitra (Diubah agar benar-benar menghitung Mitra yang Approved, bukan sekadar User)
        $totalMitra = \App\Models\Mitra::where('status', 'Approved')->count();
        
        $mitraBulanIni = \App\Models\Mitra::where('status', 'Approved')
            ->whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->count();
            
        $mitraBulanLalu = \App\Models\Mitra::where('status', 'Approved')
            ->whereYear('created_at', $lastMonth->year)
            ->whereMonth('created_at', $lastMonth->month)
            ->count();
            
        $persenMitra = ($mitraBulanLalu > 0) ? (($mitraBulanIni - $mitraBulanLalu) / $mitraBulanLalu) * 100 : 0;

        // Struktur data yang dikirim ke view (Sudah disinkronkan)
        $data = [
            'totalBooking'    => $totalBooking,
            'persenBooking'   => $persenBooking,
            'totalPendapatan' => $totalPendapatan,
            'persenPendapatan'=> $persenPendapatan,
            'totalMitra'      => $totalMitra,
            'persenMitra'     => $persenMitra, // Diubah biar konsisten namanya
        ];

        return view('admin.dashboard', compact(
            'totalBooking', 
            'persenBooking', 
            'totalPendapatan', 
            'persenPendapatan', 
            'totalMitra', 
            'persenMitra' // Diubah di sini juga
        ));
        // Struktur data yang dikirim ke view (Sudah disinkronkan)
        $data = [
            'totalBooking'    => $totalBooking,
            'persenBooking'   => $persenBooking,
            'totalPendapatan' => $totalPendapatan,
            'persenPendapatan'=> $persenPendapatan,
            'totalMitra'      => $totalMitra,
            'persenUser'      => $persenUser,
        ];

        return view('admin.dashboard', compact(
        'totalBooking', 
        'persenBooking', 
        'totalPendapatan', 
        'persenPendapatan', 
        'totalMitra', 
        'persenUser'
    ));
    }
}