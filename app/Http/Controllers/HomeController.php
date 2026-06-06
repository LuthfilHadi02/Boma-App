<?php

namespace App\Http\Controllers;

use App\Models\Berita; // Import model Berita kita bray
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // 🛡️ SUNTIKAN SATPAM ROLE-SWITCH UTAMA
        // Cek dulu apakah ada user yang sedang login di browser bray
        if (auth()->check()) {
            $role = auth()->user()->role;

            // Kalau yang login rolenya Admin, langsung lempar paksa ke Dashboard Admin
            if ($role === 'admin') {
                return redirect()->route('admin.dashboard');
            } 
            // Kalau yang login rolenya Mitra, langsung lempar paksa ke Dashboard Mitra
            elseif ($role === 'mitra') {
                return redirect()->route('mitra.dashboard');
            }
            // Kalau rolenya 'student' atau user biasa, biarkan lolos ke bawah ngerender home biasa
        }

        // 📰 ALUR NORMAL BAWAAN AKMAL
        // Ambil 3 berita terbaru dari database buat dipajang di landing page
        $beritas = Berita::latest()->take(3)->get();
        
        // Kirim data ke file home.blade.php
        return view('home', compact('beritas'));
    }
}