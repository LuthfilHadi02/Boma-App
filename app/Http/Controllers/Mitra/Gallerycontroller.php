<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\FacilityImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    private function authorizeFacility(Facility $facility): void
    {
        $mitra = Auth::user()->mitra;
        abort_unless($mitra && $facility->mitra_id === $mitra->id, 403);
    }

    public function index(Facility $facility)
    {
        $this->authorizeFacility($facility);
        $images = FacilityImage::where('facility_id', $facility->id)->orderBy('sort_order')->get();
        return view('mitra.gallery.index', compact('facility', 'images'));
    }

    public function store(Request $request, Facility $facility)
    {
        $this->authorizeFacility($facility);

        $request->validate([
            'images'   => 'required|array|max:10',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        $currentCount = FacilityImage::where('facility_id', $facility->id)->count();
        $noPrimary    = $currentCount === 0;

        foreach ($request->file('images') as $i => $file) {
            $path = $file->store("facilities/{$facility->id}", 'public');
            FacilityImage::create([
                'facility_id' => $facility->id,
                'image_path'  => $path,
                'is_primary'  => $noPrimary && $i === 0,
                'sort_order'  => $currentCount + $i,
            ]);
        }

        return back()->with('success', 'Foto berhasil diunggah.');
    }

    public function setPrimary(Facility $facility, FacilityImage $image)
    {
        $this->authorizeFacility($facility);
        FacilityImage::where('facility_id', $facility->id)->update(['is_primary' => false]);
        $image->update(['is_primary' => true]);
        return back()->with('success', 'Foto utama berhasil diubah.');
    }

    public function destroy(Facility $facility, FacilityImage $image)
    {
        $this->authorizeFacility($facility);
        Storage::disk('public')->delete($image->image_path);
        $image->delete();
        return back()->with('success', 'Foto berhasil dihapus.');
    }
}