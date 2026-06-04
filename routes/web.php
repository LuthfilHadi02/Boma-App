<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MitraApprovalController;
use App\Http\Controllers\Admin\FacilityController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Mitra\MitraDashboardController;

use App\Models\Schedule;
use App\Models\Roster;
use App\Models\Facility;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ======================================================
// LANDING PAGE
// ======================================================

Route::get('/', [HomeController::class, 'index'])->name('home');


// ======================================================
// USER DASHBOARD
// ======================================================

Route::get('/dashboard', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


// ======================================================
// JADWAL LATIHAN BOMA
// ======================================================

Route::get('/jadwal', function () {

    $schedules = Schedule::all()->keyBy(function ($item) {
        return \Carbon\Carbon::parse($item->date)->format('Y-m-d');
    });

    return view('jadwal', compact('schedules'));

})->name('jadwal.index');


// Ikut Latihan (HARUS LOGIN)
Route::post('/jadwal/ikut/{id}', function ($id) {

    $jadwal = Schedule::findOrFail($id);

    if ($jadwal->current_quota < $jadwal->max_quota) {

        $jadwal->increment('current_quota');

        return back()->with(
            'success',
            'Mantap! Lu berhasil daftar latihan.'
        );
    }

    return back()->with(
        'error',
        'Yah, telat. Kuota udah penuh pak!'
    );

})->middleware('auth')->name('jadwal.ikut');


// ======================================================
// BOOKING LAPANGAN
// ======================================================

Route::get('/booking', function () {

    $facilities = Facility::with('mitra')
        ->where('is_active', true)
        ->latest()
        ->get();

    return view('booking', compact('facilities'));

})->name('booking');


// Detail Lapangan Dinamis
Route::get('/detail-lapangan/{id}', function ($id) {

    $facility = Facility::with('mitra')->findOrFail($id);

    return view('detail-lapangan', compact('facility'));

})->name('detail-lapangan');


// ======================================================
// PROFILE USER
// ======================================================

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});


// ======================================================
// ADMIN ROUTES
// ======================================================

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');


        // ==========================================
        // MITRA APPROVAL
        // ==========================================

        Route::get('/mitra-approval', [MitraApprovalController::class, 'index'])
            ->name('mitra.index');

        Route::patch('/mitra-approval/{id}/status', [MitraApprovalController::class, 'updateStatus'])
            ->name('mitra.updateStatus');


        // ==========================================
        // FACILITY MANAGEMENT
        // ==========================================

        Route::get('/facilities', [FacilityController::class, 'index'])
            ->name('facilities.index');

        Route::post('/facilities', [FacilityController::class, 'store'])
            ->name('facilities.store');

        Route::delete('/facilities/{id}', [FacilityController::class, 'destroy'])
            ->name('facilities.destroy');


        // ==========================================
        // ROSTER MANAGEMENT
        // ==========================================

        Route::get('/roster', [App\Http\Controllers\Admin\RosterController::class, 'index'])
            ->name('roster.index');

        Route::post('/roster', [App\Http\Controllers\Admin\RosterController::class, 'store'])
            ->name('roster.store');

        Route::put('/roster/{id}', [App\Http\Controllers\Admin\RosterController::class, 'update'])
            ->name('roster.update');

        Route::delete('/roster/{id}', [App\Http\Controllers\Admin\RosterController::class, 'destroy'])
            ->name('roster.destroy');


        // ==========================================
        // SCHEDULE MANAGEMENT
        // ==========================================

        Route::get('/schedule', [App\Http\Controllers\Admin\ScheduleController::class, 'index'])
            ->name('schedule.index');

        Route::post('/schedule', [App\Http\Controllers\Admin\ScheduleController::class, 'store'])
            ->name('schedule.store');

        Route::put('/schedule/{id}', [App\Http\Controllers\Admin\ScheduleController::class, 'update'])
            ->name('schedule.update');

        Route::delete('/schedule/{id}', [App\Http\Controllers\Admin\ScheduleController::class, 'destroy'])
            ->name('schedule.destroy');


        // ==========================================
        // PAYMENT & REFUND
        // ==========================================

        Route::get('/payments', [App\Http\Controllers\Admin\PaymentManagementController::class, 'index'])
            ->name('payments.index');

        Route::post('/refunds/{id}/approve', [App\Http\Controllers\Admin\PaymentManagementController::class, 'approveRefund'])
            ->name('refunds.approve');

        Route::post('/refunds/{id}/reject', [App\Http\Controllers\Admin\PaymentManagementController::class, 'rejectRefund'])
            ->name('refunds.reject');


        // ==========================================
        // BERITA MANAGEMENT
        // ==========================================

        Route::get('/berita', [BeritaController::class, 'index'])
            ->name('berita.index');

        Route::post('/berita', [BeritaController::class, 'store'])
            ->name('berita.store');

        Route::delete('/berita/{id}', [BeritaController::class, 'destroy'])
            ->name('berita.destroy');

});


// ======================================================
// MITRA ROUTES
// ======================================================

Route::middleware(['auth', 'role:mitra'])
    ->prefix('mitra')
    ->name('mitra.')
    ->group(function () {

        Route::get('/dashboard', [MitraDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/facilities', [FacilityController::class, 'index'])
            ->name('facilities.index');

        Route::get('/facilities/create', [FacilityController::class, 'create'])
            ->name('facilities.create');

        Route::post('/facilities', [FacilityController::class, 'store'])
            ->name('facilities.store');

});


// ======================================================
// DIVISI BOMA
// ======================================================

Route::get('/divisi/basket', function (Request $request) {

    $gender = $request->query('gender', 'putra');

    $rosters = Roster::where('team_category', 'Basket')
        ->where('gender', $gender)
        ->get();

    return view('basket', compact('rosters', 'gender'));

})->name('divisi.basket');


Route::get('/divisi/futsal', function (Request $request) {

    $gender = $request->query('gender', 'putra');

    $rosters = Roster::where('team_category', 'Futsal')
        ->where('gender', $gender)
        ->get();

    return view('futsal', compact('rosters', 'gender'));

})->name('divisi.futsal');


Route::get('/divisi/bulutangkis', function (Request $request) {

    $gender = $request->query('gender', 'putra');

    $rosters = Roster::where('team_category', 'Bulutangkis')
        ->where('gender', $gender)
        ->get();

    return view('bulutangkis', compact('rosters', 'gender'));

})->name('divisi.bulutangkis');


// ======================================================
// AUTH
// ======================================================

require __DIR__.'/auth.php';