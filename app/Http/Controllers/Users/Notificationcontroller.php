<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\NotificationInapp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = NotificationInapp::where('user_id', Auth::id())
            ->latest('created_at')
            ->paginate(20);

        // Tandai semua sebagai dibaca saat dibuka
        NotificationInapp::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('user.notifications.index', compact('notifications'));
    }

    public function markRead(NotificationInapp $notification)
    {
        abort_unless($notification->user_id === Auth::id(), 403);
        $notification->update(['is_read' => true]);
        return back();
    }

    // API: jumlah notif belum dibaca (untuk badge di navbar)
    public function unreadCount()
    {
        $count = NotificationInapp::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }
}