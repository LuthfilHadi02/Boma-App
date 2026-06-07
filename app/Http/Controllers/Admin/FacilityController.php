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

    // 3. SIMPAN LAPANGAN (Suntikan Fix Jam Operasional)
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
            // SUNTIKAN FIX VALIDASI: Jam operasional wajib diisi pas bikin baru bray
            'opening_time'   => 'required|date_format:H:i',
            'closing_time'   => 'required|date_format:H:i|after:opening_time',
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

        // SUNTIKAN FIX CREATE: Amankan opening_time & closing_time ke database
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
            'opening_time'  => $request->opening_time,
            'closing_time'  => $request->closing_time,
            'is_active'     => true,
        ]);

        if ($user->role === 'mitra') {
            return redirect()->route('mitra.facilities.index')->with('success', 'Lapangan baru berhasil ditambahkan bray!');
        }

        return redirect()->route('admin.facilities.index')->with('success', 'Lapangan baru berhasil ditambahkan ke sistem oleh Admin.');
    }

    // 4. HAPUS LAPANGAN
// 4. HAPUS LAPANGAN (REVISI SAKTI ANTI-ERROR 500)
    public function destroy($id)
    {
        $facility = Facility::findOrFail($id);

        // Validasi Keamanan (Satpam)
        if (auth()->user()->role === 'mitra') {
            $mitra = \App\Models\Mitra::where('user_id', auth()->id())->first();
            if (!$mitra || $facility->mitra_id !== $mitra->id) {
                abort(403, 'Akses ditolak! Lu bukan pemilik lapangan ini.');
            }
        }

        // Proses Hapus dengan Jaring Pengaman Try-Catch bray
        try {
            $facility->delete();

            if (auth()->user()->role === 'mitra') {
                return redirect()->route('mitra.facilities.index')->with('success', 'Lapangan berhasil dihapus.');
            }

            return redirect()->route('admin.facilities.index')->with('success', 'Lapangan berhasil dihapus dari sistem.');

        } catch (\Illuminate\Database\QueryException $e) {
            // 🚨 JIKA GAGAL KARENA CONSTRAINT INTEGRITY (KODE ERROR 23000 / FOREIGN KEY KONFLIK)
            if ($e->getCode() === '23000' || str_contains($e->getMessage(), '1451')) {
                if (auth()->user()->role === 'mitra') {
                    return redirect()->route('mitra.facilities.index')->with('error', 'Waduh pak, lapangan ini gagal dihapus karena masih terikat dengan data riwayat transaksi/booking mahasiswa.');
                }
                return redirect()->route('admin.facilities.index')->with('error', 'Lapangan tidak bisa dihapus karena masih ada transaksi yang terkait.');
            }

            // Jika ada error database tipe lain yang aneh-aneh
            return back()->with('error', 'Terjadi kesalahan sistem saat mencoba menghapus data.');
        }
    }
    // 5. FORM EDIT LAPANGAN
    public function edit($id)
    {
        $facility = \App\Models\Facility::findOrFail($id);

        if (auth()->user()->role === 'mitra') {
            $mitra = \App\Models\Mitra::where('user_id', auth()->id())->firstOrFail();
            if ($facility->mitra_id !== $mitra->id) {
                abort(403, 'Kamu tidak punya akses untuk edit lapangan ini.');
            }
        }

        $selectedAmenities = $facility->amenities
            ? json_decode($facility->amenities, true)
            : [];

        return view('mitra.facilities.edit', compact('facility', 'selectedAmenities'));
    }

    // 6. PROSES UPDATE LAPANGAN (PUT)
    public function update(Request $request, $id)
    {
        $facility = \App\Models\Facility::findOrFail($id);

        if (auth()->user()->role === 'mitra') {
            $mitra = \App\Models\Mitra::where('user_id', auth()->id())->firstOrFail();
            if ($facility->mitra_id !== $mitra->id) {
                abort(403);
            }
        }

        $request->validate([
            'name'           => 'required|string|max:255',
            'type'           => 'required|in:Futsal,Basket,Badminton,Tenis,Basketball,Padel',
            'floor_type'     => 'required|string|max:255',
            'price_per_hour' => 'required|numeric|min:0',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description'    => 'nullable|string',
            'gmaps_link'     => 'required|url',
            'amenities'      => 'nullable|array',
            'opening_time'   => 'required|date_format:H:i', // Ubah ke required bray biar konsisten aman
            'closing_time'   => 'required|date_format:H:i|after:opening_time',
        ]);

        $amenitiesData = $request->has('amenities')
            ? json_encode($request->input('amenities'))
            : null;

        $imagePath = $facility->image;
        if ($request->hasFile('image')) {
            if ($facility->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($facility->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($facility->image);
            }
            $imagePath = $request->file('image')->store('facilities', 'public');
        }

        $facility->update([
            'name'           => $request->name,
            'type'           => $request->type,
            'floor_type'     => $request->floor_type,
            'price_per_hour' => $request->price_per_hour,
            'image'          => $imagePath,
            'description'    => $request->description,
            'amenities'      => $amenitiesData,
            'gmaps_link'     => $request->gmaps_link,
            'opening_time'   => $request->opening_time,
            'closing_time'   => $request->closing_time,
        ]);

        if (auth()->user()->role === 'mitra') {
            return redirect()->route('mitra.facilities.index')->with('success', 'Data lapangan berhasil diperbarui!');
        }
        
        return redirect()->route('admin.facilities.index')->with('success', 'Data lapangan berhasil diperbarui oleh Admin!');
    }

        // SELIPKAN DI PALING BAWAH FILE FACILITYCONTROLLER LU BRAY
    public function jadwalSewa()
    {
        $user = auth()->user();
        
        // Pastikan yang akses beneran Mitra bray
        if ($user->role !== 'mitra') {
            abort(403, 'Hanya Mitra yang bisa melihat jadwal sewa lapangan mereka.');
        }

        $mitra = \App\Models\Mitra::where('user_id', $user->id)->first();
        
        if (!$mitra) {
            return redirect()->route('home')->with('error', 'Profil Mitra tidak ditemukan.');
        }

        // Ambil semua data lapangan milik mitra ini, sekalian angkut data bookings yang statusnya sukses/paid/confirmed
        // Biar ketahuan siapa aja yang udah bayar dan berhak main bray
        $facilities = \App\Models\Facility::where('mitra_id', $mitra->id)
            ->with(['bookings' => function($query) {
                $query->whereIn('status', ['confirmed', 'paid']) // Hanya tampilkan yang deal/lunas bray
                    ->with('user') // Angkut data user mahasiswa yang booking
                    ->orderBy('booking_date', 'asc')
                    ->orderBy('start_time', 'asc');
            }])
            ->latest()
            ->get();

        return view('mitra.facilities.jadwal', compact('facilities'));
    }
}