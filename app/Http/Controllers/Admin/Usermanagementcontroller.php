<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load('bookings.facility', 'bookings.latestPayment');
        return view('admin.users.show', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|in:admin,mitra,user',
            'prodi' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $before = $user->only(['name', 'email', 'role']);
        $user->update($request->only(['name', 'email', 'role', 'prodi', 'phone']));

        ActivityLog::record('update', 'User', $user->id, $before, $user->only(['name', 'email', 'role']), "Update data user: {$user->name}");

        return back()->with('success', 'Data user berhasil diperbarui.');
    }

    public function resetPassword(User $user)
    {
        $newPassword = 'boma' . rand(10000, 99999);
        $user->update(['password' => Hash::make($newPassword)]);

        ActivityLog::record('reset_password', 'User', $user->id, null, null, "Reset password user: {$user->name}");

        return back()->with('success', "Password berhasil direset menjadi: {$newPassword}");
    }

    public function toggleBan(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Tidak dapat memblokir akun admin.');
        }

        $wasBanned = $user->is_banned ?? false;
        $user->update(['is_banned' => !$wasBanned]);

        $action = $wasBanned ? 'unban' : 'ban';
        ActivityLog::record($action, 'User', $user->id, null, null, ucfirst($action) . " user: {$user->name}");

        return back()->with('success', 'Status user berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        ActivityLog::record('delete', 'User', $user->id, $user->toArray(), null, "Hapus user: {$user->name}");
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }
}