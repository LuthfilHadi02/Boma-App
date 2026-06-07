<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    // 1. TAMPILKAN HALAMAN UTAMA KELOLA JADWAL
    public function index()
    {
        // Ambil semua jadwal latihan, urutkan dari yang paling baru
        $schedules = Schedule::latest()->get();
        return view('admin.schedule.index', compact('schedules'));
    }

    // 2. PROSES SIMPAN JADWAL BARU
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'max_quota' => 'required|integer|min:1',
        ]);

        Schedule::create([
            'title' => $request->title,
            'date' => $request->date,
            'time' => $request->time,
            'location' => $request->location,
            'max_quota' => $request->max_quota,
            'current_quota' => 0,
        ]);

        return redirect()->route('admin.schedule.index')->with('success', 'Jadwal latihan baru berhasil diterbitkan!');
    }

    // 3. PROSES HAPUS JADWAL
    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('admin.schedule.index')->with('success', 'Jadwal latihan berhasil dihapus dari sistem.');
    }


// 3. PROSES UPDATE / EDIT JADWAL LATIHAN (TAMBAHAN REVISI) 🚀
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'max_quota' => 'required|integer|min:1',
        ]);

        $schedule = Schedule::findOrFail($id);
        
        $schedule->update([
            'title' => $request->title,
            'date' => $request->date,
            'time' => $request->time,
            'location' => $request->location,
            'max_quota' => $request->max_quota,
        ]);

        return redirect()->route('admin.schedule.index')->with('success', 'Jadwal latihan berhasil diperbarui!');
    }


    public function participants($id)
    {
        // Mengambil data jadwal beserta user yang berelasi
        $schedule = \App\Models\Schedule::with('users')->findOrFail($id);
        
        // Kirim ke view
        return view('admin.schedule.participants', compact('schedule'));
    }
}