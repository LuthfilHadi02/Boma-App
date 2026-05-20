<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Set sementara ke 0 dulu biar tidak error Column Not Found
        $pendingMembers = 0;
        $pendingWithdrawals = 0;
        $pendingKycMitra = 0;
        $recentTransactions = collect([]); // Membuat collection kosong sementara

        /* // Komentari atau hapus dulu query ini sampai tabel pendukungnya siap
        $pendingMembers = DB::table('users')
            ->where('role', 'student')
            ->where('status', 'Pending_Verification')
            ->count();
        */

        // Kirim semua data aman ke view
        return view('admin.dashboard', compact(
            'pendingMembers', 
            'pendingWithdrawals', 
            'pendingKycMitra', 
            'recentTransactions'
        ));
    }
}