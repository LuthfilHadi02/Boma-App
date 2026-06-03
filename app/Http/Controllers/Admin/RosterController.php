<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Roster;
use Illuminate\Support\Facades\Storage;


class RosterController extends Controller
{
   public function index(Request $request)
    {
        // Ambil parameter ?gender= dari URL. Kalau kosong, otomatis default ke 'putra'
        $gender = $request->query('gender', 'putra');
        
        // Filter data pemain berdasarkan gender
        $players = \App\Models\Roster::where('gender', $gender)->get();
        
        return view('admin.roster.index', compact('players', 'gender'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'position' => 'required',
            'number' => 'required',
            'team_category' => 'required',
            'gender' => 'required|in:putra,putri',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Proses upload foto
        $path = $request->file('photo')->store('roster_photos', 'public');

        Roster::create([
            'name' => $request->name,
            'position' => $request->position,
            'number' => $request->number,
            'team_category' => $request->team_category,
            'gender' => $request->gender,
            'photo' => $path,
        ]);

        return back()->with('success', 'Pemain berhasil ditambahkan!');
    }
        //UPDATE ROASTER
        public function update(Request $request, $id)
    {
        $player = Roster::findOrFail($id); 

        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'number' => 'required|integer',
            'team_category' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // nullable karena foto gak wajib diganti
        ]);

        $player->name = $request->name;
        $player->position = $request->position;
        $player->number = $request->number;
        $player->team_category = $request->team_category;
        $player->gender = $request->gender ?? $player->gender;

        // Jika admin upload foto baru
        if ($request->hasFile('photo')) {
            // Hapus foto lama dari storage biar gak menumpuk jadi sampah
            if ($player->photo && Storage::disk('public')->exists($player->photo)) {
                Storage::disk('public')->delete($player->photo);
            }
            
            // Simpan foto baru
            $path = $request->file('photo')->store('rosters', 'public');
            $player->photo = $path;
        }

        $player->save();

        return redirect()->back()->with('success', 'Data pemain berhasil diperbarui!');
    }
    //DELETE ROASTER
    public function destroy($id)
        {
            $player = Roster::findOrFail($id);

            // Hapus file fotonya dari storage terlebih dahulu
            if ($player->photo && Storage::disk('public')->exists($player->photo)) {
                Storage::disk('public')->delete($player->photo);
            }

            // Hapus data dari database
            $player->delete();

            return redirect()->back()->with('success', 'Pemain berhasil dihapus dari roster!');
        }
}