<?php

use App\Http\Controllers\ProfileController;
use App\Models\Schedule; // WAJIB ADA INI BIAR GAK ERROR!
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MitraApprovalController;
use App\Http\Controllers\Admin\FacilityController;
use App\Http\Controllers\Mitra\MitraDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Jalur Utama & Auth
Route::get('/', function () {
    return redirect('/login');
});

// User Biasa Dashboard (Student)
Route::get('/dashboard', function () {
    return view('home');
})->middleware(['auth', 'verified'])->name('dashboard');

// 2. Jalur Jadwal BOMA (FULL DATABASE)
Route::get('/jadwal', function () {
    // Kita ambil data dan kunci format tanggalnya (Y-m-d) biar pas sama JavaScript
    $schedules = Schedule::all()->keyBy(function ($item) {
        return \Carbon\Carbon::parse($item->date)->format('Y-m-d');
    }); 
    
    return view('jadwal', compact('schedules'));
})->name('jadwal.index');

// Proses Tombol "Ikut Latihan"
Route::post('/jadwal/ikut/{id}', function ($id) {
    $jadwal = Schedule::findOrFail($id);
    
    if ($jadwal->current_quota < $jadwal->max_quota) {
        $jadwal->increment('current_quota');
        return back()->with('success', 'Mantap! Lu berhasil daftar latihan.');
    }
    
    return back()->with('error', 'Yah, telat. Kuota udah penuh pak!');
})->name('jadwal.ikut');

// 3. Jalur Fasilitas & Booking Commercial (Sudah Di-integrate dengan Data Mitra!)
Route::get('/booking', function () {
    // 1. Tarik semua data lapangan aktif yang diinput oleh mitra dari database
    $facilities = \App\Models\Facility::with('mitra')->where('is_active', true)->latest()->get();
    
    // 2. Lempar variabel $facilities ke file view booking milik user
    return view('booking', compact('facilities'));
})->name('booking');

Route::get('/detail-lapangan', function () {
    return view('detail-lapangan'); 
})->name('detail-lapangan');

// 4. Jalur Profile (Dikelompokkan biar rapi)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 5. Jalur Khusus Admin BOMA (Sudah Bersih & Disatukan)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Persetujuan Mitra
    Route::get('/mitra-approval', [MitraApprovalController::class, 'index'])->name('mitra.index');
    Route::patch('/mitra-approval/{id}/status', [MitraApprovalController::class, 'updateStatus'])->name('mitra.updateStatus');

    // Kelola Fasilitas Lapangan (Sisi Admin)
    Route::get('/facilities', [FacilityController::class, 'index'])->name('facilities.index');
    Route::post('/facilities', [FacilityController::class, 'store'])->name('facilities.store');
    Route::delete('/facilities/{id}', [FacilityController::class, 'destroy'])->name('facilities.destroy');

    // Roster Management
    Route::get('/roster', [App\Http\Controllers\Admin\RosterController::class, 'index'])->name('roster.index');
    Route::post('/roster', [App\Http\Controllers\Admin\RosterController::class, 'store'])->name('roster.store');
    Route::put('/roster/{id}', [App\Http\Controllers\Admin\RosterController::class, 'update'])->name('roster.update');
    Route::delete('/roster/{id}', [App\Http\Controllers\Admin\RosterController::class, 'destroy'])->name('roster.destroy');

    // ROUTE KELOLA JADWAL LATIHAN BOMA (MURNI CRUD - PUNYA MURSYID) 🚀
    Route::get('/schedule', [App\Http\Controllers\Admin\ScheduleController::class, 'index'])->name('schedule.index');
    Route::post('/schedule', [App\Http\Controllers\Admin\ScheduleController::class, 'store'])->name('schedule.store');
    Route::put('/schedule/{id}', [App\Http\Controllers\Admin\ScheduleController::class, 'update'])->name('schedule.update');
    Route::delete('/schedule/{id}', [App\Http\Controllers\Admin\ScheduleController::class, 'destroy'])->name('schedule.destroy');

    // Route Payment & Refund Baru 🚀
    Route::get('/payments', [App\Http\Controllers\Admin\PaymentManagementController::class, 'index'])->name('payments.index');
    Route::post('/refunds/{id}/approve', [App\Http\Controllers\Admin\PaymentManagementController::class, 'approveRefund'])->name('refunds.approve');
    Route::post('/refunds/{id}/reject', [App\Http\Controllers\Admin\PaymentManagementController::class, 'rejectRefund'])->name('refunds.reject');
});

// 6. Jalur Khusus Mitra Lapangan (Role: mitra)
Route::middleware(['auth', 'role:mitra'])->prefix('mitra')->name('mitra.')->group(function () {
    // Halaman utama Dashboard Mitra
    Route::get('/dashboard', [MitraDashboardController::class, 'index'])->name('dashboard');
    
    // Kelola Lapangan Sisi Mitra (Nembak ke FacilityController)
    Route::get('/facilities', [FacilityController::class, 'index'])->name('facilities.index');
    Route::get('/facilities/create', [FacilityController::class, 'create'])->name('facilities.create');
    Route::post('/facilities', [FacilityController::class, 'store'])->name('facilities.store');
});

// 7. Divisi Cabang Olahraga BOMA
Route::get('/divisi/basket', function () {
    return view('basket'); 
});

Route::get('/divisi/futsal', function () {
    return view('futsal'); 
});

Route::get('/divisi/bulutangkis', function () {
    return view('bulutangkis'); 
});

require __DIR__.'/auth.php';