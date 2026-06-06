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

        if ($user->role === 'mitra') {
            $mitra = Mitra::where('user_id', $user->id)->first();
            $facilities = Facility::where('mitra_id', $mitra->id)->latest()->get();
            return view('mitra.facilities.index', compact('facilities'));
        }

        $facilities = Facility::with('mitra')->latest()->get();
        $mitras = Mitra::whereIn('status', ['Approved', 'approved'])->get();

        return view('admin.facility.index', compact('facilities', 'mitras'));
    }

    // 2. FORM TAMBAH LAPANGAN (Mitra)
    public function create()
    {
        return view('mitra.facilities.create');
    }

    // 3. SIMPAN LAPANGAN
    // ✅ PAKAI VERSI DENIS — sudah support amenities[] + gmaps_link
    // Akmal punya versi lama yang belum ada dua field ini
    public function store(Request $request)
    {
        $user = auth()->user();

        $rules = [
            'name'           => 'required|string|max:255',
            'type'           => 'required|in:Futsal,Basket,Badminton,Tenis,Basketball,Padel',
            'floor_type'     => 'required|string|max:255',
            'price_per_hour' => 'required|numeric|min:0',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description'    => 'nullable|string',
            'gmaps_link'     => 'required|url',
            'amenities'      => 'nullable|array',
        ];

        if ($user->role === 'admin') {
            $rules['mitra_id'] = 'required|exists:mitras,id';
            $mitraId = $request->mitra_id;
        } else {
            $mitra   = \App\Models\Mitra::where('user_id', $user->id)->first();
            $mitraId = $mitra->id;
        }

        $request->validate($rules);

        // Olah amenities array → JSON
        $amenitiesData = null;
        if ($request->has('amenities')) {
            $amenitiesData = json_encode($request->input('amenities'));
        }

        // Upload gambar
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('facilities', 'public');
        }

        Facility::create([
            'mitra_id'      => $mitraId,
            'name'          => $request->name,
            'type'          => $request->type,
            'floor_type'    => $request->floor_type,
            'price_per_hour'=> $request->price_per_hour,
            'image'         => $imagePath,
            'description'   => $request->description,
            'amenities'     => $amenitiesData,
            'gmaps_link'    => $request->gmaps_link,
            'is_active'     => true,
        ]);

        if ($user->role === 'mitra') {
            return redirect()->route('mitra.facilities.index')->with('success', 'Lapangan baru berhasil ditambahkan.');
        }

        return redirect()->route('admin.facilities.index')->with('success', 'Lapangan baru berhasil ditambahkan.');
    }

    // 4. HAPUS LAPANGAN
    public function destroy($id)
    {
        $facility = Facility::findOrFail($id);
        $facility->delete();

        if (auth()->user()->role === 'mitra') {
            return redirect()->route('mitra.facilities.index')->with('success', 'Lapangan berhasil dihapus.');
        }

        return redirect()->route('admin.facilities.index')->with('success', 'Lapangan berhasil dihapus dari sistem.');
    }
}