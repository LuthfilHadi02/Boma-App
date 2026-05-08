<?php

use App\Http\Controllers\ProfileController; // Pastikan ini ada di paling atas!
use Illuminate\Support\Facades\Route;

// Jalur Utama
Route::get('/', function () {
    return redirect('/login');
});

// Jalur Home
Route::get('/dashboard', function () {
    return view('home');
})->middleware(['auth', 'verified'])->name('dashboard');

// --- Jalur Profile (Gunakan yang ini saja) ---
Route::middleware('auth')->group(function () {
    // Nampilin halaman & form edit
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    
    // Proses simpan perubahan
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Proses hapus akun (kalau mau dipake nanti)
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Jalur Jadwal
Route::get('/jadwal', function () {
    return view('jadwal');
})->middleware(['auth'])->name('jadwal');

Route::get('/booking', function () {
    return view('booking');
})->name('booking');

// Route untuk halaman Detail Lapangan
Route::get('/detail-lapangan', function () {
    return view('detail-lapangan'); // Pastikan nama file lu detail-lapangan.blade.php
})->name('detail-lapangan');

require __DIR__.'/auth.php';