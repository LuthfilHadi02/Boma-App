<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Mitra; // Pastikan ini di-import
use Illuminate\Http\Request;

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

        // 3. Data Mitra (Approved)
        $totalMitra = Mitra::where('status', 'Approved')->count();
        $mitraBulanIni = Mitra::where('status', 'Approved')->whereYear('created_at', $now->year)->whereMonth('created_at', $now->month)->count();
        $mitraBulanLalu = Mitra::where('status', 'Approved')->whereYear('created_at', $lastMonth->year)->whereMonth('created_at', $lastMonth->month)->count();
        $persenMitra = ($mitraBulanLalu > 0) ? (($mitraBulanIni - $mitraBulanLalu) / $mitraBulanLalu) * 100 : 0;

        // 4. LOGIKA NOTIFIKASI (INI YANG KAMU TAMBAHKAN)
        // Sesuaikan 'Pending_Verification' dengan ENUM di database kamu
        $pendingMitras = Mitra::where('status', 'Pending_Verification')->count(); 
        $pendingRefunds = Payment::where('status', 'refund_requested')->count();

        // Tambahkan di dalam method index()
        // Contoh data untuk Grafik Pendapatan 6 bulan terakhir
        $labels = [];
        $dataPendapatan = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $labels[] = $month->format('M'); // Contoh: Jan, Feb, Mar...
            
            $pendapatan = Payment::where('status', 'paid')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('amount');
                
            $dataPendapatan[] = $pendapatan;
        }


// 5. Kirim SEMUA data ke view (Satu return saja)
        return view('admin.dashboard', compact(
            'totalBooking', 'persenBooking', 
            'totalPendapatan', 'persenPendapatan', 
            'totalMitra', 'persenMitra',
            'pendingMitras', 'pendingRefunds', // <--- Tambahkan koma di sini
            'labels', 'dataPendapatan'
        ));
    }
}