<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'booking_id'  => 'required|exists:bookings,id',
            'rating'      => 'required|integer|between:1,5',
            'comment'     => 'nullable|string|max:1000',
        ]);

        $booking = Booking::findOrFail($request->booking_id);

        abort_unless($booking->user_id === Auth::id(), 403);
        abort_unless($booking->status === 'completed', 422, 'Hanya booking yang selesai yang bisa direview.');

        $existing = Review::where('booking_id', $booking->id)->first();
        if ($existing) {
            return back()->with('error', 'Anda sudah memberikan review untuk booking ini.');
        }

        Review::create([
            'user_id'     => Auth::id(),
            'facility_id' => $booking->facility_id,
            'booking_id'  => $booking->id,
            'rating'      => $request->rating,
            'comment'     => $request->comment,
        ]);

        return back()->with('success', 'Terima kasih atas ulasan Anda!');
    }
}