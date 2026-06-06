<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Console\Command;

class CancelExpiredBookings extends Command
{
    protected $signature   = 'bookings:cancel-expired';
    protected $description = 'Otomatis batalkan booking pending yang tidak dibayar lebih dari 15 menit';

    public function handle(): void
    {
        $expiredBookings = Booking::where('status', 'pending')
            ->where('created_at', '<', now()->subMinutes(15))
            ->get();

        if ($expiredBookings->isEmpty()) {
            $this->info('Tidak ada booking expired.');
            return;
        }

        foreach ($expiredBookings as $booking) {
            $booking->update(['status' => 'cancelled']);

            Payment::where('booking_id', $booking->id)
                ->where('status', 'pending')
                ->update(['status' => 'failed']);

            $this->line("Cancelled booking #{$booking->id} — {$booking->booking_date} {$booking->start_time}");
        }

        $this->info("Total dibatalkan: {$expiredBookings->count()} booking.");
    }
}