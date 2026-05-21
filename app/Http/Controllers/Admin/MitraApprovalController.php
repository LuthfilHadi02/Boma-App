<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mitra; // Sesuaikan dengan nama model Lu (Mitra / MitraProfile)
use Illuminate\Http\Request;

class MitraApprovalController extends Controller
{
    // 1. Tampilkan halaman daftar pengajuan mitra
    public function index()
    {
        // Ambil data mitra yang statusnya masih pending untuk di-review admin 
        $mitras = Mitra::where('status', 'Pending_Verification')->latest()->get();
        
        return view('admin.mitra.index', compact('mitras'));
    }

    // 2. Proses Persetujuan (Approve) atau Penolakan (Suspend)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Approved,Suspended' // [cite: 81, 84]
        ]);

        $mitra = Mitra::findOrFail($id);
        $mitra->update([
            'status' => $request->status
        ]);

        $message = $request->status === 'Approved' 
            ? 'Akun Mitra berhasil diverifikasi dan diaktifkan!' 
            : 'Akun Mitra berhasil ditangguhkan/ditolak.';

        return redirect()->route('admin.mitra.index')->with('success', $message);
    }
}