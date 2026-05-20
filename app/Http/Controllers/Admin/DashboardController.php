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

        // 3. Data User (Diubah menjadi totalMitra agar sesuai dengan blade)
        $totalMitra = User::whereNotNull('email_verified_at')->count();
        $userBulanIni = User::whereYear('created_at', $now->year)->whereMonth('created_at', $now->month)->whereNotNull('email_verified_at')->count();
        $userBulanLalu = User::whereYear('created_at', $lastMonth->year)->whereMonth('created_at', $lastMonth->month)->whereNotNull('email_verified_at')->count();
        $persenUser = ($userBulanLalu > 0) ? (($userBulanIni - $userBulanLalu) / $userBulanLalu) * 100 : 0;

        // Struktur data yang dikirim ke view (Sudah disinkronkan)
        $data = [
            'totalBooking'    => $totalBooking,
            'persenBooking'   => $persenBooking,
            'totalPendapatan' => $totalPendapatan,
            'persenPendapatan'=> $persenPendapatan,
            'totalMitra'      => $totalMitra,
            'persenUser'      => $persenUser,
        ];

        return view('admin.dashboard', $data);
    }
}