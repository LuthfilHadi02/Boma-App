<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\Mitra;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    // 1. TAMPILKAN DAFTAR LAPANGAN (Dinamis: Admin vs Mitra)
    public function index()
    {
        $user = auth()->user();

        // JIKA YANG LOGIN ADALAH MITRA (Fitur Lu)
        if ($user->role === 'mitra') {
            $mitra = Mitra::where('user_id', $user->id)->first();
            // Ambil lapangan yang hanya dimiliki oleh mitra aktif ini
            $facilities = Facility::where('mitra_id', $mitra->id)->latest()->get();
            return view('mitra.facilities.index', compact('facilities'));
        }

        // JIKA YANG LOGIN ADALAH ADMIN (Bawaan Luthfil)
        $facilities = Facility::with('mitra')->latest()->get();
        $mitras = Mitra::whereIn('status', ['Approved', 'approved'])->get();

        return view('admin.facility.index', compact('facilities', 'mitras'));
    }

    // 2. FASE BARU: Menampilkan Form Input Tambah Lapangan
    public function create()
    {
        return view('mitra.facilities.create');
    }

    // 3. PROSES SIMPAN DATA LAPANGAN (Dinamis: Admin vs Mitra)
    public function store(Request $request)
    {
        $user = auth()->user();

        // Aturan Validasi Dasar (Sesuai SRS v4.0)
        $rules = [
            'name' => 'required|string|max:255',
            'type' => 'required|in:Futsal,Basket,Badminton,Tenis,Basketball,Padel', 
            'floor_type' => 'required|string|max:255',
            'price_per_hour' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB
            'description' => 'nullable|string',
        ];

        // Penentuan ID Mitra secara otomatis atau manual
        if ($user->role === 'admin') {
            $rules['mitra_id'] = 'required|exists:mitras,id'; // Admin milih dari dropdown
            $mitraId = $request->mitra_id;
        } else {
            $mitra = Mitra::where('user_id', $user->id)->first(); // Mitra otomatis ke-detect ID-nya
            $mitraId = $mitra->id;
        }

        $request->validate($rules);

        // Upload Gambar Lapangan
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('facilities', 'public');
        }

        // Create ke Database
        Facility::create([
            'mitra_id' => $mitraId,
            'name' => $request->name,
            'type' => $request->type,
            'floor_type' => $request->floor_type,
            'price_per_hour' => $request->price_per_hour,
            'image' => $imagePath,
            'description' => $request->description,
            'is_active' => true,
        ]);

        // Redirect sesuai siapa yang nambahin
        if ($user->role === 'mitra') {
            return redirect()->route('mitra.facilities.index')->with('success', 'Selamat! Lapangan baru berhasil ditambahkan.');
        }

        return redirect()->route('admin.facilities.index')->with('success', 'Selamat! Lapangan baru berhasil ditambahkan.');
    }

    // 4. PROSES HAPUS LAPANGAN
    public function destroy($id)
    {
        $facility = Facility::findOrFail($id);
        $facility->delete();

        if (auth()->user()->role === 'mitra') {
            return redirect()->route('mitra.facilities.index')->with('success', 'Fasilitas lapangan telah berhasil dihapus.');
        }

        return redirect()->route('admin.facilities.index')->with('success', 'Fasilitas lapangan telah berhasil dihapus dari sistem.');
    }
}