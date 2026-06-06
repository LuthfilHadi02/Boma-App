<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Facility;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index()
    {
        $mitra = Auth::user()->mitra;
        $facilityIds = Facility::where('mitra_id', $mitra->id)->pluck('id');

        $reviews = Review::with('user', 'facility', 'booking')
            ->whereIn('facility_id', $facilityIds)
            ->latest()
            ->paginate(15);

        $avgRating = Review::whereIn('facility_id', $facilityIds)->avg('rating');

        return view('mitra.reviews.index', compact('reviews', 'avgRating'));
    }
}