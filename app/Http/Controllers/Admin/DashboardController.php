<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Mitra;

class DashboardController extends Controller
{
    public function index()
    {
        $now = now();
        $lastMonth = now()->subMonth();

        // 1. Data Booking
        $totalBooking = Booking::count();
        $bookingsBulanIni = Booking::whereYear('created_at', $now->year)->whereMonth('created_at', $now->month)->count();
        $bookingsBulanLalu = Booking::whereYear('created_at', $lastMonth->year)->whereMonth('created_at', $lastMonth->month)->count();
        $persenBooking = ($bookingsBulanLalu > 0) ? (($bookingsBulanIni - $bookingsBulanLalu) / $bookingsBulanLalu) * 100 : 0;

        // 2. Data Pendapatan
        $totalPendapatan = Payment::where('status', 'paid')->sum('amount');
        $pendapatanBulanIni = Payment::where('status', 'paid')->whereYear('created_at', $now->year)->whereMonth('created_at', $now->month)->sum('amount');
        $pendapatanBulanLalu = Payment::where('status', 'paid')->whereYear('created_at', $lastMonth->year)->whereMonth('created_at', $lastMonth->month)->sum('amount');
        $persenPendapatan = ($pendapatanBulanLalu > 0) ? (($pendapatanBulanIni - $pendapatanBulanLalu) / $pendapatanBulanLalu) * 100 : 0;

        // 3. Data Mitra
        $totalMitra = Mitra::where('status', 'Approved')->count();
        $mitraBulanIni = Mitra::where('status', 'Approved')->whereYear('created_at', $now->year)->whereMonth('created_at', $now->month)->count();
        $mitraBulanLalu = Mitra::where('status', 'Approved')->whereYear('created_at', $lastMonth->year)->whereMonth('created_at', $lastMonth->month)->count();
        $persenMitra = ($mitraBulanLalu > 0) ? (($mitraBulanIni - $mitraBulanLalu) / $mitraBulanLalu) * 100 : 0;

        // 4. Notifikasi
        $pendingMitras = Mitra::where('status', 'Pending_Verification')->count(); 
        $pendingRefunds = Payment::where('status', 'refund_requested')->count();

        // Mengirim data ke view
        return view('admin.dashboard', compact(
            'totalBooking', 
            'persenBooking', 
            'totalPendapatan', 
            'persenPendapatan', 
            'totalMitra', 
            'persenMitra',
            'pendingMitras', 
            'pendingRefunds'
        ));
    }
}