<?php

use App\Http\Controllers\ProfileController;
use App\Models\Schedule; // WAJIB ADA INI BIAR GAK ERROR!
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MitraApprovalController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Jalur Utama & Auth
Route::get('/', function () {
    return redirect('/login');
});

// User Biasa Dashboard
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

// 3. Jalur Fasilitas & Booking
Route::get('/booking', function () {
    return view('booking');
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

// 5. Jalur Khusus Admin BOMA - DIBERESIN BIAR GAK MENTAL
Route::middleware(['auth', 'can:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Pindahkan dashboard ke sini, url otomatis jadi boma-app.test/admin/dashboard
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Route untuk halaman persetujuan mitra (Grup yang sudah ada tinggal gabung)
    Route::get('/mitra-approval', [MitraApprovalController::class, 'index'])->name('mitra.index');
    Route::patch('/mitra-approval/{id}/status', [MitraApprovalController::class, 'updateStatus'])->name('mitra.updateStatus');
});

// Pastikan sudah ada group auth dan admin di sistem lu
Route::middleware(['auth', 'can:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Route untuk halaman persetujuan mitra
    Route::get('/mitra-approval', [MitraApprovalController::class, 'index'])->name('mitra.index');
    Route::patch('/mitra-approval/{id}/status', [MitraApprovalController::class, 'updateStatus'])->name('mitra.updateStatus');

});

require __DIR__.'/auth.php';