<?php

use Illuminate\Support\Facades\Route;

// Jalur Utama: Pas buka localhost:8000 langsung ke halaman Login
Route::get('/', function () {
    return redirect('/login');
});

// Jalur Home: Setelah login, lu bakal ke sini
Route::get('/dashboard', function () {
    return view('home');
})->middleware(['auth', 'verified'])->name('dashboard');

// Jalur Jadwal: Cuma bisa dibuka kalau sudah login
Route::get('/jadwal', function () {
    return view('jadwal');
})->middleware(['auth'])->name('jadwal');

require __DIR__.'/auth.php';