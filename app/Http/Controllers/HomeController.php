<?php

namespace App\Http\Controllers;

use App\Models\Berita; // Import model Berita kita
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil 3 berita terbaru dari database
        $beritas = Berita::latest()->take(3)->get();
        
        // Kirim data ke file home.blade.php
        return view('home', compact('beritas'));
    }
}