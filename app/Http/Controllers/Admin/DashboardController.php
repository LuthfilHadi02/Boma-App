<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Mitra; // Pastikan model Mitra ini di-import ya bray
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

        // 2. Data Pendapatan (Escrow)
        $totalPendapatan = Payment::where('status', 'paid')->sum('amount'); 
        $pendapatanBulanIni = Payment::where('status', 'paid')->whereYear('created_at', $now->year)->whereMonth('created_at', $now->month)->sum('amount');
        $pendapatanBulanLalu = Payment::where('status', 'paid')->whereYear('created_at', $lastMonth->year)->whereMonth('created_at', $lastMonth->month)->sum('amount');
        $persenPendapatan = ($pendapatanBulanLalu > 0) ? (($pendapatanBulanIni - $pendapatanBulanLalu) / $pendapatanBulanLalu) * 100 : 0;

        // 3. Data Mitra Approved
        $totalMitra = Mitra::where('status', 'Approved')->count();
        $mitraBulanIni = Mitra::where('status', 'Approved')->whereYear('created_at', $now->year)->whereMonth('created_at', $now->month)->count();
        $mitraBulanLalu = Mitra::where('status', 'Approved')->whereYear('created_at', $lastMonth->year)->whereMonth('created_at', $lastMonth->month)->count();
        $persenMitra = ($mitraBulanLalu > 0) ? (($mitraBulanIni - $mitraBulanLalu) / $mitraBulanLalu) * 100 : 0;

        // 4. Data User Mahasiswa
        $totalUsers = User::where('role', 'user')->count();
        $usersBulanIni = User::where('role', 'user')->whereYear('created_at', $now->year)->whereMonth('created_at', $now->month)->count();
        $usersBulanLalu = User::where('role', 'user')->whereYear('created_at', $lastMonth->year)->whereMonth('created_at', $lastMonth->month)->count();
        $persenUser = ($usersBulanLalu > 0) ? (($usersBulanIni - $usersBulanLalu) / $usersBulanLalu) * 100 : 0;

        // SUNTIKAN FIX UTAMA: Hitung jumlah request pendaftaran mitra baru yang statusnya masih 'Pending_Verification' bray
        // Berdasarkan file .sql lu, enum statusnya adalah: 'Pending_Verification', 'Approved', 'Suspended'
        $pendingMitraRequests = Mitra::where('status', 'Pending_Verification')->count();

        // Lempar semua variabel ke view, termasuk si $pendingMitraRequests!
        return view('admin.dashboard', compact(
            'totalBooking', 
            'persenBooking', 
            'totalPendapatan', 
            'persenPendapatan', 
            'totalMitra', 
            'persenMitra',
            'totalUsers',
            'persenUser',
            'pendingMitraRequests' // <-- Kita ikut sertakan di sini bray biar gak amnesia lagi Laravelnya
        ));
    }
}