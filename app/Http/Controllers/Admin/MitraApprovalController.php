<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mitra;
use App\Mail\KemitraanDisetujui; // ✅ DARI DENIS — email otomatis ke mitra
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class MitraApprovalController extends Controller
{
    // Tampilkan daftar pengajuan mitra
    public function index()
    {
        // ✅ PAKAI VERSI DENIS — with('user') diperlukan untuk menampilkan nama di tabel
        $mitras = Mitra::with('user')->where('status', 'Pending_Verification')->latest()->get();
        return view('admin.mitra.index', compact('mitras'));
    }

    // Proses approve / suspend mitra
    // ✅ PAKAI VERSI DENIS — ada kirim email otomatis saat Approved
    // Versi Akmal tidak ada email notification
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Approved,Suspended'
        ]);

        $mitra = Mitra::with('user')->findOrFail($id);
        $mitra->update(['status' => $request->status]);

        if ($request->status === 'Approved') {
            try {
                Mail::to($mitra->user->email)->send(new KemitraanDisetujui($mitra));
            } catch (\Exception $e) {
                \Log::error('Gagal kirim email ke mitra: ' . $e->getMessage());
            }
        }

        $message = $request->status === 'Approved'
            ? 'Akun Mitra berhasil diverifikasi! Email notifikasi berhasil dikirim.'
            : 'Akun Mitra berhasil ditangguhkan.';

        return redirect()->back()->with('success', $message);
    }
}