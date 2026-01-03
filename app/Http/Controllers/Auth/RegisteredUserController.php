<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            // Default 'is_admin' biasanya sudah 0 dari database, jadi aman.
        ]);

        event(new Registered($user));

        Auth::login($user);

        // --- LOGIKA PENGALIHAN (REDIRECT) ---
        
        // Jika User Biasa (is_admin = 0), arahkan ke Home (/)
        if ($user->is_admin == 0) {
            return redirect('/'); 
        }

        // Jika Admin (is_admin = 1), tetap ke Dashboard
        return redirect(route('dashboard', absolute: false));
    }
}