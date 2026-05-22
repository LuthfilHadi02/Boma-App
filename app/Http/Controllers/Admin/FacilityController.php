<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\Mitra;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function index()
    {
        $facilities = Facility::with('mitra')->latest()->get();
        $mitras = Mitra::whereIn('status', ['Approved', 'approved'])->get(); // Hanya mitra yg lolos verifikasi

        return view('admin.facility.index', compact('facilities', 'mitras'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mitra_id' => 'required|exists:mitras,id',
            'name' => 'required|string|max:255',
            'type' => 'required|in:Futsal,Basket,Badminton,Tenis',
            'floor_type' => 'required|string|max:255',
            'price_per_hour' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('facilities', 'public');
        }

        Facility::create([
            'mitra_id' => $request->mitra_id,
            'name' => $request->name,
            'type' => $request->type,
            'floor_type' => $request->floor_type,
            'price_per_hour' => $request->price_per_hour,
            'image' => $imagePath,
            'description' => $request->description,
            'is_active' => true,
        ]);

        

        return redirect()->route('admin.facilities.index')->with('success', 'Selamat! Lapangan baru berhasil ditambahkan.');
    }

    // Tambahkan fungsi ini di bagian paling bawah file FacilityController.php

public function destroy($id)
{
    // 1. Cari data lapangannya berdasarkan ID, kalau gak ada langsung otomatis memunculkan error 404
    $facility = \App\Models\Facility::findOrFail($id);

    // 2. Hapus data lapangan dari database
    $facility->delete();

    // 3. Kembalikan halaman ke daftar lapangan dengan alert sukses formal
    return redirect()->route('admin.facilities.index')->with('success', 'Fasilitas lapangan telah berhasil dihapus dari sistem.');
}
}