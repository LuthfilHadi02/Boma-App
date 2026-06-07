<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UserScheduleController extends Controller
{
    // 📅 1. TAMPILKAN KALENDER JADWAL LATIHAN (MAHASISWA)
    public function index()
    {
        // Ambil semua jadwal, lalu kelompokkan berdasarkan tanggalnya bray (groupBy)
        $schedules = Schedule::all()->groupBy('date');
        
        return view('jadwal', compact('schedules'));
    }

    // 🚀 2. PROSES GABUNG/IKUT LATIHAN (AUTOMATIC CHECKIN)
    public function ikutLatihan($id)
    {
        $jadwal = Schedule::findOrFail($id);
        $userId = auth()->id();

        // Satpam 1: Cek duplikasi di tabel pivot (Biar gak bisa spam klik!)
        $sudahIkut = $jadwal->users()->where('user_id', $userId)->exists();
        if ($sudahIkut) {
            return back()->with('error', 'Waduh pak, lu kan udah terdaftar di jadwal latihan ini!');
        }

        // Satpam 2: Cek sisa kuota latihan
        if ($jadwal->current_quota >= $jadwal->max_quota) {
            return back()->with('error', 'Yah, telat. Kuota latihan untuk hari ini udah penuh pak!');
        }

        // Eksekusi aman: Catat ke pivot table DAN tambahkan angka kuota (+1)
        $jadwal->users()->attach($userId);
        $jadwal->increment('current_quota');

        return back()->with('success', 'Mantap! Lu berhasil terdaftar resmi ikut latihan divisi BOMA.');
    }

    // 🏋️‍♂️ 3. TAMPILKAN RIWAYAT AGENDA LATIHAN SAYA
    public function history()
    {
        $user = auth()->user();
        
        // Ambil data jadwal latihan yang diikuti user ini, diurutkan dari yang terbaru
        $mySchedules = $user->schedules()->orderBy('date', 'desc')->get();
        
        return view('latihan-history', compact('mySchedules'));
    }

    // ❌ 4. PROSES BATAL IKUT LATIHAN (AUTOMATIC CANCEL)
    public function batalIkutLatihan($id)
    {
        $jadwal = Schedule::findOrFail($id);
        $userId = auth()->id();

        // Cek dulu, emang beneran si user udah daftar di jadwal ini?
        $terdaftar = $jadwal->users()->where('user_id', $userId)->exists();
        
        if (!$terdaftar) {
            return back()->with('error', 'Lu emang gak terdaftar di latihan ini bray!');
        }

        // Eksekusi pelepasan: Hapus dari pivot table DAN kurangi kuota (-1)
        $jadwal->users()->detach($userId);
        
        // Pake kondisi biar current_quota gak minus di bawah angka 0 pak bray
        if ($jadwal->current_quota > 0) {
            $jadwal->decrement('current_quota');
        }

        return back()->with('success', 'Gasss! Lu resmi membatalkan diri dari jadwal latihan ini.');
    }
}