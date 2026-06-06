<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Refund;
use App\Models\NotificationInapp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingHistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with('facility', 'latestPayment')
            ->where('user_id', Auth::id())
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->paginate(10)->withQueryString();

        return view('user.history.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        abort_unless($booking->user_id === Auth::id(), 403);
        $booking->load('facility.mitra', 'latestPayment', 'rosters');
        return view('user.history.show', compact('booking'));
    }

    public function cancel(Request $request, Booking $booking)
    {
        abort_unless($booking->user_id === Auth::id(), 403);

        if (!in_array($booking->status, ['pending', 'confirmed'])) {
            return back()->with('error', 'Booking tidak dapat dibatalkan.');
        }

        $request->validate(['reason' => 'required|string|max:500']);

        $booking->update(['status' => 'cancelled']);

        // Buat refund request jika sudah bayar
        $payment = $booking->latestPayment;
        if ($payment && $payment->status === 'paid') {
            Refund::create([
                'booking_id' => $booking->id,
                'payment_id' => $payment->id,
                'reason'     => $request->reason,
                'amount'     => $payment->amount,
                'status'     => 'pending',
            ]);

            NotificationInapp::send(
                Auth::id(),
                'Permintaan Refund Diterima 📝',
                "Booking Anda dibatalkan. Permintaan refund sedang diproses admin.",
                'payment'
            );
        }

        return back()->with('success', 'Booking berhasil dibatalkan.');
    }
}