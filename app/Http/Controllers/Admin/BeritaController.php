<?php
// FILE INI HANYA ADA DI AKMAL — Denis tidak punya
// Salin ke: app/Http/Controllers/Admin/BeritaController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    public function index()
    {
        $beritas = Berita::latest()->get();
        return view('admin.berita.index', compact('beritas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'              => 'required|max:255',
            'deskripsi_singkat'  => 'required|max:200',
            'konten_lengkap'     => 'required',
            'tanggal_kegiatan'   => 'required|date',
            'link'               => 'nullable|url',
            'foto'               => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $berita                    = new Berita();
        $berita->judul             = $request->judul;
        $berita->slug              = Str::slug($request->judul);
        $berita->deskripsi_singkat = $request->deskripsi_singkat;
        $berita->konten_lengkap    = $request->konten_lengkap;
        $berita->link              = $request->link;
        $berita->tanggal_kegiatan  = $request->tanggal_kegiatan;

        if ($request->hasFile('foto')) {
            $file      = $request->file('foto');
            $namaFoto  = time() . '_' . Str::random(5) . '_' . $file->getClientOriginalName();
            $file->move(public_path('img/berita'), $namaFoto);
            $berita->foto = 'img/berita/' . $namaFoto;
        }

        $berita->save();
        return redirect()->back()->with('success', 'Berita berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);
        if ($berita->foto && file_exists(public_path($berita->foto))) {
            unlink(public_path($berita->foto));
        }
        $berita->delete();
        return redirect()->back()->with('success', 'Berita berhasil dihapus!');
    }
}