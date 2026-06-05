<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;           // ✅ DARI AKMAL
use App\Models\Schedule;
use App\Models\Roster;
use App\Models\Facility;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MitraApprovalController;
use App\Http\Controllers\Admin\FacilityController;
use App\Http\Controllers\Admin\BeritaController;   // ✅ DARI AKMAL
use App\Http\Controllers\Mitra\MitraDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes - BOMA APP INTEGRATED VERSION
|--------------------------------------------------------------------------
*/

// =========================================================================
// 1. HALAMAN PUBLIK
// =========================================================================

// ✅ PAKAI HOMECONTROLLER (AKMAL) — lebih clean, home jadi controller bukan closure
Route::get('/', [HomeController::class, 'index'])->name('home');

// Jadwal publik
Route::get('/jadwal', function () {
    $schedules = Schedule::all()->keyBy(function ($item) {
        return \Carbon\Carbon::parse($item->date)->format('Y-m-d');
    });
    return view('jadwal', compact('schedules'));
})->name('jadwal.index');

// Katalog booking lapangan (publik)
Route::get('/booking', function () {
    $facilities = Facility::with('mitra')->where('is_active', true)->latest()->get();
    return view('booking', compact('facilities'));
})->name('booking');

// ✅ HALAMAN DIVISI — PAKAI VERSI DINAMIS (AKMAL), load roster dari DB
Route::get('/divisi/basket', function (Request $request) {
    $gender = $request->query('gender', 'putra');
    $rosters = Roster::where('team_category', 'Basket')->where('gender', $gender)->get();
    return view('basket', compact('rosters', 'gender'));
})->name('divisi.basket');

Route::get('/divisi/futsal', function (Request $request) {
    $gender = $request->query('gender', 'putra');
    $rosters = Roster::where('team_category', 'Futsal')->where('gender', $gender)->get();
    return view('futsal', compact('rosters', 'gender'));
})->name('divisi.futsal');

Route::get('/divisi/bulutangkis', function (Request $request) {
    $gender = $request->query('gender', 'putra');
    $rosters = Roster::where('team_category', 'Bulutangkis')->where('gender', $gender)->get();
    return view('bulutangkis', compact('rosters', 'gender'));
})->name('divisi.bulutangkis');

// Register Mitra (guest boleh akses)
Route::get('/mitra/register', [App\Http\Controllers\Auth\MitraRegisterController::class, 'showRegisterForm'])->name('mitra.register');
Route::post('/mitra/register', [App\Http\Controllers\Auth\MitraRegisterController::class, 'store'])->name('mitra.register.store');


// =========================================================================
// 2. AREA WAJIB LOGIN (AUTH + VERIFIED)
// =========================================================================
Route::middleware(['auth', 'verified'])->group(function () {

    // User biasa redirect ke home
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    // Ikut latihan (wajib login)
    Route::post('/jadwal/ikut/{id}', function ($id) {
        $jadwal = Schedule::findOrFail($id);
        if ($jadwal->current_quota < $jadwal->max_quota) {
            $jadwal->increment('current_quota');
            return back()->with('success', 'Mantap! Lu berhasil daftar latihan.');
        }
        return back()->with('error', 'Yah, telat. Kuota udah penuh pak!');
    })->name('jadwal.ikut');

    // ✅ DETAIL LAPANGAN — PAKAI VERSI DENIS (pakai BookingController, ada booking.store)
    Route::get('/detail-lapangan/{id}', [App\Http\Controllers\BookingController::class, 'show'])->name('booking.detail');
    Route::post('/detail-lapangan/store', [App\Http\Controllers\BookingController::class, 'store'])->name('booking.store');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // -------------------------------------------------------------------------
    // ADMIN ROUTES
    // -------------------------------------------------------------------------
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Mitra approval
        Route::get('/mitra-approval', [MitraApprovalController::class, 'index'])->name('mitra.index');
        Route::patch('/mitra-approval/{id}/status', [MitraApprovalController::class, 'updateStatus'])->name('mitra.updateStatus');

        // Fasilitas lapangan
        Route::get('/facilities', [FacilityController::class, 'index'])->name('facilities.index');
        Route::post('/facilities', [FacilityController::class, 'store'])->name('facilities.store');
        Route::delete('/facilities/{id}', [FacilityController::class, 'destroy'])->name('facilities.destroy');

        // Roster
        Route::get('/roster', [App\Http\Controllers\Admin\RosterController::class, 'index'])->name('roster.index');
        Route::post('/roster', [App\Http\Controllers\Admin\RosterController::class, 'store'])->name('roster.store');
        Route::put('/roster/{id}', [App\Http\Controllers\Admin\RosterController::class, 'update'])->name('roster.update');
        Route::delete('/roster/{id}', [App\Http\Controllers\Admin\RosterController::class, 'destroy'])->name('roster.destroy');

        // Jadwal
        Route::get('/schedule', [App\Http\Controllers\Admin\ScheduleController::class, 'index'])->name('schedule.index');
        Route::post('/schedule', [App\Http\Controllers\Admin\ScheduleController::class, 'store'])->name('schedule.store');
        Route::put('/schedule/{id}', [App\Http\Controllers\Admin\ScheduleController::class, 'update'])->name('schedule.update');
        Route::delete('/schedule/{id}', [App\Http\Controllers\Admin\ScheduleController::class, 'destroy'])->name('schedule.destroy');

        // Payment & Refund
        Route::get('/payments', [App\Http\Controllers\Admin\PaymentManagementController::class, 'index'])->name('payments.index');
        Route::post('/refunds/{id}/approve', [App\Http\Controllers\Admin\PaymentManagementController::class, 'approveRefund'])->name('refunds.approve');
        Route::post('/refunds/{id}/reject', [App\Http\Controllers\Admin\PaymentManagementController::class, 'rejectRefund'])->name('refunds.reject');

        // ✅ BERITA — DARI AKMAL (tidak ada di Denis, harus ditambahkan)
        Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
        Route::post('/berita', [BeritaController::class, 'store'])->name('berita.store');
        Route::delete('/berita/{id}', [BeritaController::class, 'destroy'])->name('berita.destroy');
    });


    // -------------------------------------------------------------------------
    // MITRA ROUTES
    // -------------------------------------------------------------------------
    Route::middleware(['role:mitra'])->prefix('mitra')->name('mitra.')->group(function () {

        Route::get('/dashboard', [MitraDashboardController::class, 'index'])->name('dashboard');

        Route::get('/facilities', [FacilityController::class, 'index'])->name('facilities.index');
        Route::get('/facilities/create', [FacilityController::class, 'create'])->name('facilities.create');
        Route::post('/facilities', [FacilityController::class, 'store'])->name('facilities.store');
    });

});

require __DIR__.'/auth.php';