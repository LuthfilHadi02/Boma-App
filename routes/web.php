<?php

use App\Http\Controllers\ProfileController;
use App\Models\Schedule; // WAJIB ADA INI BIAR GAK ERROR!
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MitraApprovalController;
use App\Http\Controllers\Admin\FacilityController;

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

// 5. Jalur Khusus Admin BOMA
    Route::middleware(['auth', 'can:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Admin
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    // Pastikan ada baris ini di routes/web.php lu, bro!
    Route::put('/admin/roster/{id}', [App\Http\Controllers\Admin\RosterController::class, 'update'])->name('admin.roster.update');


    // Persetujuan Mitra
    Route::get('/mitra-approval', [App\Http\Controllers\Admin\MitraApprovalController::class, 'index'])->name('mitra.index');
    Route::patch('/mitra-approval/{id}/status', [App\Http\Controllers\Admin\MitraApprovalController::class, 'updateStatus'])->name('mitra.updateStatus');

    // Kelola Fasilitas Lapangan (RUTE BARU KITA)
    Route::get('/facilities', [App\Http\Controllers\Admin\FacilityController::class, 'index'])->name('facilities.index');
    Route::post('/facilities', [App\Http\Controllers\Admin\FacilityController::class, 'store'])->name('facilities.store');

    // UBAH BARIS INI (Tambahkan App\Http\Controllers\Admin\ di depan FacilityController):
    Route::delete('/facilities/{id}', [App\Http\Controllers\Admin\FacilityController::class, 'destroy'])->name('facilities.destroy');

    // Roster Management
// Roster Management (Udah rapi & gak double prefix)
    Route::get('/roster', [App\Http\Controllers\Admin\RosterController::class, 'index'])->name('roster.index');
    Route::post('/roster', [App\Http\Controllers\Admin\RosterController::class, 'store'])->name('roster.store');
    Route::put('/roster/{id}', [App\Http\Controllers\Admin\RosterController::class, 'update'])->name('roster.update');
    Route::delete('/roster/{id}', [App\Http\Controllers\Admin\RosterController::class, 'destroy'])->name('roster.destroy');

    // Route Payment & Refund Baru 🚀
// Route Utama untuk nampilin Tab Transaksi & Refund
    Route::get('/payments', [App\Http\Controllers\Admin\PaymentManagementController::class, 'index'])->name('payments.index');
    
    // Aksi POST untuk eksekusi Refund dari dalam tab
    Route::post('/refunds/{id}/approve', [App\Http\Controllers\Admin\PaymentManagementController::class, 'approveRefund'])->name('refunds.approve');
    Route::post('/refunds/{id}/reject', [App\Http\Controllers\Admin\PaymentManagementController::class, 'rejectRefund'])->name('refunds.reject');
});

require __DIR__.'/auth.php';

// '/divisi/basket' = URL cantiknya (yang diketik di browser)
Route::get('/divisi/basket', function () {
    
    // 'basket' = Nama file aslinya di folder views (basket.blade.php)
    return view('basket'); 
});

Route::get('/divisi/futsal', function () {
    return view('futsal'); 
});

Route::get('/divisi/bulutangkis', function () {
    return view('bulutangkis'); 
});