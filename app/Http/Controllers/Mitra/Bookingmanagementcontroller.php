<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Facility;
use App\Models\NotificationInapp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingManagementController extends Controller
{
    private function mitraFacilityIds(): array
    {
        $mitra = Auth::user()->mitra;
        if (!$mitra) return [];
        return Facility::where('mitra_id', $mitra->id)->pluck('id')->toArray();
    }

    public function index(Request $request)
    {
        $facilityIds = $this->mitraFacilityIds();

        $query = Booking::with('user', 'facility', 'latestPayment')
            ->whereIn('facility_id', $facilityIds)
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('date')) {
            $query->whereDate('booking_date', $request->date);
        }

        $bookings = $query->paginate(15)->withQueryString();

        $stats = [
            'pending'   => Booking::whereIn('facility_id', $facilityIds)->where('status', 'pending')->count(),
            'confirmed' => Booking::whereIn('facility_id', $facilityIds)->where('status', 'confirmed')->count(),
            'today'     => Booking::whereIn('facility_id', $facilityIds)->whereDate('booking_date', today())->count(),
        ];

        return view('mitra.bookings.index', compact('bookings', 'stats'));
    }

    public function confirm(Booking $booking)
    {
        $this->authorizeBooking($booking);

        $booking->update(['status' => 'confirmed']);

        NotificationInapp::send(
            $booking->user_id,
            'Booking Dikonfirmasi ✅',
            "Booking Anda di {$booking->facility->name} pada {$booking->booking_date} telah dikonfirmasi.",
            'booking',
            ['booking_id' => $booking->id]
        );

        return back()->with('success', 'Booking berhasil dikonfirmasi.');
    }

    public function reject(Request $request, Booking $booking)
    {
        $this->authorizeBooking($booking);
        $request->validate(['reason' => 'required|string|max:255']);

        $booking->update(['status' => 'cancelled', 'notes' => $request->reason]);

        NotificationInapp::send(
            $booking->user_id,
            'Booking Ditolak ❌',
            "Booking Anda di {$booking->facility->name} ditolak. Alasan: {$request->reason}",
            'booking'
        );

        return back()->with('success', 'Booking berhasil ditolak.');
    }

    private function authorizeBooking(Booking $booking): void
    {
        $facilityIds = $this->mitraFacilityIds();
        abort_unless(in_array($booking->facility_id, $facilityIds), 403, 'Akses ditolak.');
    }
}