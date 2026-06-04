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

   public function store(Request $request)
    {
        $user = auth()->user();

        // 1. ATURAN VALIDASI (Kita tambahin rules amenities dan gmaps_link)
        $rules = [
            'name' => 'required|string|max:255',
            'type' => 'required|in:Futsal, Basket, Badminton, Tenis, Basketball, Padel', 
            'floor_type' => 'required|string|max:255',
            'price_per_hour' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
            'description' => 'nullable|string',
            'gmaps_link' => 'required|url', 
            'amenities' => 'nullable|array', 
        ];

        if ($user->role === 'admin') {
            $rules['mitra_id'] = 'required|exists:mitras,id';
            $mitraId = $request->mitra_id;
        } else {
            $mitra = \App\Models\Mitra::where('user_id', $user->id)->first();
            $mitraId = $mitra->id;
        }

        $request->validate($rules);

        // 2. OLAH ARRAY CHECKBOX AMENITIES JADI JSON (Biar bisa masuk kolom teks database)
        $amenitiesData = null;
        if ($request->has('amenities')) {
            $amenitiesData = json_encode($request->input('amenities'));
        }

        // 3. UPLOAD GAMBAR LAPANGAN
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('facilities', 'public');
        }

        // 4. EKSEKUSI INSERT DATA KE DATABASE
        Facility::create([
            'mitra_id' => $mitraId,
            'name' => $request->name,
            'type' => $request->type,
            'floor_type' => $request->floor_type,
            'price_per_hour' => $request->price_per_hour,
            'image' => $imagePath,
            'description' => $request->description,
            'amenities' => $amenitiesData,   
            'gmaps_link' => $request->gmaps_link, 
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