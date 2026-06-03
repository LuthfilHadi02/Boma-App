<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // 1. Ambil data user yang baru saja sukses login
        $user = auth()->user();

        // 2. Cek apakah dia Admin
        if ($user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        }

        // 3. Cek apakah dia Mitra Lapangan
        if ($user->role === 'mitra') {
            return redirect()->intended(route('mitra.dashboard'));
        }

        // 4. Kalau bukan keduanya, berarti dia Student / User Umum
        return redirect()->intended(route('dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
