<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mitra; 
use App\Mail\KemitraanDisetujui; // 🟢 Robot Mailable pengirim kertas surat
use Illuminate\Support\Facades\Mail; // 🟢 Panggil Facade Mail Laravel
use Illuminate\Http\Request;

class MitraApprovalController extends Controller
{
    // 1. Tampilkan halaman daftar pengajuan mitra
    public function index()
    {
        // Ambil data mitra beserta akun user-nya yang statusnya masih Pending_Verification
        $mitras = Mitra::with('user')->where('status', 'Pending_Verification')->latest()->get();
        
        return view('admin.mitra.index', compact('mitras'));
    }

    // 2. Proses Persetujuan (Approve) atau Penolakan (Suspend)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Approved,Suspended'
        ]);

        // Tarik data mitra beserta akun user-nya dari database
        $mitra = Mitra::with('user')->findOrFail($id);
        
        // Update status sesuai inputan tombol admin (Approved / Suspended)
        $mitra->update([
            'status' => $request->status
        ]);

        // 🚀 SUNTIKAN SAKTI: Jika Admin ngeklik APPROVE, picu robot buat kirim email otomatis!
        if ($request->status === 'Approved') {
            try {
                Mail::to($mitra->user->email)->send(new KemitraanDisetujui($mitra));
            } catch (\Exception $e) {
                // Kalau di lokal komputer lu belum konek internet, biar gak crash, dicatat aja di log
                \Log::error('Gagal kirim email otomatis ke mitra: ' . $e->getMessage());
            }
        }

        $message = $request->status === 'Approved' 
            ? 'Akun Mitra berhasil diverifikasi dan diaktifkan! Email notifikasi juga berhasil meluncur bray.' 
            : 'Akun Mitra berhasil ditangguhkan/ditolak.';

        return redirect()->back()->with('success', $message);
    }
}