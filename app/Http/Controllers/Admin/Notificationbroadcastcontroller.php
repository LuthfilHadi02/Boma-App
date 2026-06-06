<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\NotificationInapp;
use Illuminate\Http\Request;

class NotificationBroadcastController extends Controller
{
    public function index()
    {
        $recentBroadcasts = NotificationInapp::where('type', 'system')
            ->latest('created_at')
            ->take(20)
            ->get();

        $userCount = User::where('role', 'user')->count();
        $mitraCount = User::where('role', 'mitra')->count();

        return view('admin.notifications.index', compact('recentBroadcasts', 'userCount', 'mitraCount'));
    }

    public function broadcast(Request $request)
    {
        $request->validate([
            'title'     => 'required|string|max:255',
            'message'   => 'required|string',
            'target'    => 'required|in:all,user,mitra',
        ]);

        $query = User::query();
        if ($request->target !== 'all') {
            $query->where('role', $request->target);
        }

        $users = $query->get();
        $count = 0;

        foreach ($users as $user) {
            NotificationInapp::send($user->id, $request->title, $request->message, 'system');
            $count++;
        }

        return back()->with('success', "Notifikasi berhasil dikirim ke {$count} pengguna.");
    }
}