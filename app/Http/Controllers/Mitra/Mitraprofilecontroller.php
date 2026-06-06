<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Mitra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MitraProfileController extends Controller
{
    public function edit()
    {
        $mitra = Auth::user()->mitra;
        abort_if(!$mitra, 404);
        return view('mitra.profile.edit', compact('mitra'));
    }

    public function update(Request $request)
    {
        $mitra = Auth::user()->mitra;
        abort_if(!$mitra, 404);

        $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'alamat'     => 'required|string',
            'no_hp'      => 'required|string|max:20',
            'foto'       => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['nama_usaha', 'alamat', 'no_hp']);

        if ($request->hasFile('foto')) {
            if ($mitra->foto) Storage::disk('public')->delete($mitra->foto);
            $data['foto'] = $request->file('foto')->store('mitra/photos', 'public');
        }

        $mitra->update($data);

        return back()->with('success', 'Profil bisnis berhasil diperbarui.');
    }
}