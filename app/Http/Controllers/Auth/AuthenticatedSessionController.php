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

        // --- MODIFIKASI DIMULAI DARI SINI ---
        
        // Ambil data user yang sedang login
        $user = $request->user();

        // Cek jika user BUKAN admin (is_admin = 0)
        if ($user->is_admin == 0) {
            // Arahkan ke halaman riwayat pembelian
            // Pastikan Anda memiliki route dengan nama 'history.index' di web.php
            return redirect()->route('history.index');
        }

        // Jika Admin, arahkan ke dashboard (default)
        return redirect()->intended(route('dashboard', absolute: false));
        
        // --- AKHIR MODIFIKASI ---
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