<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Refund;
use App\Models\ActivityLog;
use App\Models\NotificationInapp;
use Illuminate\Http\Request;

class RefundController extends Controller
{
    public function index(Request $request)
    {
        $query = Refund::with('booking.user', 'booking.facility', 'payment')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $refunds = $query->paginate(15)->withQueryString();
        $stats = [
            'pending'   => Refund::where('status', 'pending')->count(),
            'approved'  => Refund::where('status', 'approved')->count(),
            'rejected'  => Refund::where('status', 'rejected')->count(),
            'processed' => Refund::where('status', 'processed')->count(),
        ];

        return view('admin.refunds.index', compact('refunds', 'stats'));
    }

    public function approve(Request $request, Refund $refund)
    {
        $refund->update(['status' => 'approved', 'processed_at' => now()]);
        $refund->payment->update(['status' => 'refunded']);

        NotificationInapp::send(
            $refund->booking->user_id,
            'Refund Disetujui ✅',
            "Pengajuan refund Anda sebesar Rp " . number_format($refund->amount, 0, ',', '.') . " telah disetujui.",
            'payment'
        );

        ActivityLog::record('approve', 'Refund', $refund->id, null, null, "Setujui refund booking #{$refund->booking_id}");

        return back()->with('success', 'Refund berhasil disetujui.');
    }

    public function reject(Request $request, Refund $refund)
    {
        $request->validate(['admin_note' => 'required|string|max:500']);

        $refund->update(['status' => 'rejected', 'admin_note' => $request->admin_note]);

        NotificationInapp::send(
            $refund->booking->user_id,
            'Refund Ditolak ❌',
            "Pengajuan refund Anda ditolak. Alasan: {$request->admin_note}",
            'payment'
        );

        ActivityLog::record('reject', 'Refund', $refund->id, null, null, "Tolak refund booking #{$refund->booking_id}");

        return back()->with('success', 'Refund berhasil ditolak.');
    }

    public function markProcessed(Refund $refund)
    {
        $refund->update(['status' => 'processed', 'processed_at' => now()]);

        NotificationInapp::send(
            $refund->booking->user_id,
            'Dana Refund Dikirim 💸',
            "Dana refund sebesar Rp " . number_format($refund->amount, 0, ',', '.') . " sudah dikirim ke rekening Anda.",
            'payment'
        );

        return back()->with('success', 'Refund ditandai sebagai sudah diproses.');
    }
}