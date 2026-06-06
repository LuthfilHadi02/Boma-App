<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Mitra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // 🟢 Panggil DB Facade buat Transaction
use Illuminate\Support\Facades\Storage; // 🟢 Panggil Storage buat ngehapus file sampah kalau gagal

class MitraRegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.mitra-register');
    }

    public function store(Request $request)
    {
        // 1. Validasi Inputan
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'brand_name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'bank_name' => 'required|string|max:100',
            'bank_account_number' => 'required|string|max:50',
            'bank_account_name' => 'required|string|max:255',
            'identity_document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // 2. Upload Dokumen Awal
        $documentPath = null;
        if ($request->hasFile('identity_document')) {
            $documentPath = $request->file('identity_document')->store('identity_documents', 'public');
        }

        // 3. MULAI SISTEM PENGUNCIAN DB TRANSACTION 🔒
        DB::beginTransaction();

        try {
            // Langkah A: Buat User
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'mitra',
            ]);

            // Langkah B: Buat data Mitra (Status PENDING Kapital)
            Mitra::create([
                'user_id' => $user->id,
                'brand_name' => $request->brand_name,
                'address' => $request->address,
                'bank_name' => $request->bank_name,
                'bank_account_number' => $request->bank_account_number,
                'bank_account_name' => $request->bank_account_name,
                'identity_document' => $documentPath,
            ]);

            // Kalau Langkah A dan B sukses total tanpa eror, sahkan datanya!
            DB::commit();

            // Otomatis Login
            Auth::login($user);

            return redirect()->route('mitra.dashboard')->with('info', 'Registrasi berhasil! Akun lu berstatus PENDING. Silakan tunggu Admin BOMA memeriksa berkas KYC lu ya, pak.');

        } catch (\Exception $e) {
            // ❌ JIKA ADA YANG EROR DI TENGAH JALAN, BATALKAN SEMUANYA!
            DB::rollBack();

            // 🗑️ Hapus juga file KTP yang telanjur ke-upload di folder storage biar gak menuh-menuhin hosting
            if ($documentPath && Storage::disk('public')->exists($documentPath)) {
                Storage::disk('public')->delete($documentPath);
            }

            // Balikin user ke halaman form dengan pesan eror aslinya biar ketahuan rusaknya di mana
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Waduh gagal bray! Sistem otomatis ngelakuin rollback data. Eror: ' . $e->getMessage()]);
        }
    }
}