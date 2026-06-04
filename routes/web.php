<?php

use App\Http\Controllers\ProfileController;
use App\Models\Schedule;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MitraApprovalController;
use App\Http\Controllers\Admin\FacilityController;
use App\Http\Controllers\Mitra\MitraDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes - BOMA APP INTEGRATED VERSION (VIBE CODING BY AI)
|--------------------------------------------------------------------------
*/

// =========================================================================
// 1. GERBANG UTAMA & HALAMAN PUBLIK (TERBUKA UNTUK GUEST / TANPA LOGIN) 🌐
// =========================================================================

Route::get('/', function () {
    return view('home'); // Otomatis lari ke halaman Home utama BOMA saat pertama dibuka
})->name('home');

// Jalur Informasi Divisi Cabang Olahraga BOMA (Bisa dibaca Publik)
Route::get('/divisi/basket', function () {
    return view('basket'); 
});

Route::get('/divisi/futsal', function () {
    return view('futsal'); 
});

Route::get('/divisi/bulutangkis', function () {
    return view('bulutangkis'); 
});

// --- AKSI PUBLIK: JADWAL LATIHAN (Bisa dilihat siapa saja) ---
Route::get('/jadwal', function () {
    $schedules = Schedule::all()->keyBy(function ($item) {
        return \Carbon\Carbon::parse($item->date)->format('Y-m-d');
    }); 
    return view('jadwal', compact('schedules'));
})->name('jadwal.index');

// --- AKSI PUBLIK: KATALOG BOOKING LAPANGAN (Bisa dilihat siapa saja) ---
Route::get('/booking', function () {
    // Tarik semua data lapangan aktif kiriman dari database Mitra
    $facilities = \App\Models\Facility::with('mitra')->where('is_active', true)->latest()->get();
    return view('booking', compact('facilities'));
})->name('booking');

// 🟢 ROUTE REGISTRASI KHUSUS MITRA GOR (BEBAS DIAKSES GUEST DI LUAR AUTH)
Route::get('/mitra/register', [App\Http\Controllers\Auth\MitraRegisterController::class, 'showRegisterForm'])->name('mitra.register');
Route::post('/mitra/register', [App\Http\Controllers\Auth\MitraRegisterController::class, 'store'])->name('mitra.register.store');


// =========================================================================
// 2. AREA AKURAT YANG WAJIB LOGIN DULU (MIDDLEWARE AUTH SECURITY) 🔒
// =========================================================================
Route::middleware(['auth', 'verified'])->group(function () {
    
    // User Biasa Dashboard Redirect (Bawaan Breeze)
    Route::get('/dashboard', function () {
        return view('home');
    })->name('dashboard');

    // ---------------------------------------------------------------------
    // A. PROTEKSI JADWAL: IKUT LATIHAN BOMA (WAJIB LOGIN)
    // ---------------------------------------------------------------------
    Route::post('/jadwal/ikut/{id}', function ($id) {
        $jadwal = Schedule::findOrFail($id);
        
        if ($jadwal->current_quota < $jadwal->max_quota) {
            $jadwal->increment('current_quota');
            return back()->with('success', 'Mantap! Lu berhasil daftar latihan.');
        }
        
        return back()->with('error', 'Yah, telat. Kuota udah penuh pak!');
    })->name('jadwal.ikut');

    // ---------------------------------------------------------------------
    // B. PROTEKSI BOOKING: DETAIL LAPANGAN DINAMIS (WAJIB LOGIN)
    // ---------------------------------------------------------------------
    Route::get('/detail-lapangan/{id}', [App\Http\Controllers\BookingController::class, 'show'])->name('booking.detail');
    
    // 🟢 AKSI MENYIMPAN TRANSAKSI BOOKING MAHASISWA KE DATABASE (ANTI-HARDCODE)
    Route::post('/detail-lapangan/store', [App\Http\Controllers\BookingController::class, 'store'])->name('booking.store');

    // ---------------------------------------------------------------------
    // C. MANAGEMENT PROFILE PENGGUNA
    // ---------------------------------------------------------------------
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ---------------------------------------------------------------------
    // D. JALUR KHUSUS ADMIN BOMA (ROLE: ADMIN ONLY) 👑
    // ---------------------------------------------------------------------
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        
        // Dashboard Admin
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Persetujuan Berkas KYC Mitra Baru
        Route::get('/mitra-approval', [MitraApprovalController::class, 'index'])->name('mitra.index');
        Route::patch('/mitra-approval/{id}/status', [MitraApprovalController::class, 'updateStatus'])->name('mitra.updateStatus');

        // Kelola Fasilitas Lapangan Sisi Admin
        Route::get('/facilities', [FacilityController::class, 'index'])->name('facilities.index');
        Route::post('/facilities', [FacilityController::class, 'store'])->name('facilities.store');
        Route::delete('/facilities/{id}', [FacilityController::class, 'destroy'])->name('facilities.destroy');

        // Roster Management Atlet
        Route::get('/roster', [App\Http\Controllers\Admin\RosterController::class, 'index'])->name('roster.index');
        Route::post('/roster', [App\Http\Controllers\Admin\RosterController::class, 'store'])->name('roster.store');
        Route::put('/roster/{id}', [App\Http\Controllers\Admin\RosterController::class, 'update'])->name('roster.update');
        Route::delete('/roster/{id}', [App\Http\Controllers\Admin\RosterController::class, 'destroy'])->name('roster.destroy');

        // Kelola Finansial Transaksi & Refund Admin
        Route::get('/payments', [App\Http\Controllers\Admin\PaymentManagementController::class, 'index'])->name('payments.index');
        Route::post('/refunds/{id}/approve', [App\Http\Controllers\Admin\PaymentManagementController::class, 'approveRefund'])->name('refunds.approve');
        Route::post('/refunds/{id}/reject', [App\Http\Controllers\Admin\PaymentManagementController::class, 'rejectRefund'])->name('refunds.reject');

        // JALUR FULL CRUD JADWAL LATIHAN BOMA (KARYA MURSYID DANISWARA) 🚀
        Route::get('/schedule', [App\Http\Controllers\Admin\ScheduleController::class, 'index'])->name('schedule.index');
        Route::post('/schedule', [App\Http\Controllers\Admin\ScheduleController::class, 'store'])->name('schedule.store');
        Route::put('/schedule/{id}', [App\Http\Controllers\Admin\ScheduleController::class, 'update'])->name('schedule.update');
        Route::delete('/schedule/{id}', [App\Http\Controllers\Admin\ScheduleController::class, 'destroy'])->name('schedule.destroy');
    });

    // ---------------------------------------------------------------------
    // E. JALUR KHUSUS MITRA LAPANGAN (ROLE: MITRA ONLY) 🏢
    // ---------------------------------------------------------------------
    Route::middleware(['role:mitra'])->prefix('mitra')->name('mitra.')->group(function () {
        
        // Halaman Utama Dashboard Mitra
        Route::get('/dashboard', [MitraDashboardController::class, 'index'])->name('dashboard');
        
        // Kelola Lapangan Mandiri Sisi Mitra
        Route::get('/facilities', [FacilityController::class, 'index'])->name('facilities.index');
        Route::get('/facilities/create', [FacilityController::class, 'create'])->name('facilities.create');
        Route::post('/facilities', [FacilityController::class, 'store'])->name('facilities.store');
    });

});

// Load Sistem Autentikasi Bawaan Laravel Breeze
require __DIR__.'/auth.php';