@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container">
    <div style="max-width: 450px; margin: 2rem auto;">
        <div class="card" style="padding: 2.5rem; border-top: 5px solid var(--primary);">
            <div style="text-align: center; margin-bottom: 2rem;">
                <h2 style="color: var(--primary); margin-bottom: 0.5rem;">Selamat Datang Kembali</h2>
                <p style="color: var(--text-light);">Silakan login ke akun Anda</p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="alert alert-info" style="margin-bottom: 1rem;">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="alert alert-error" style="margin-bottom: 1rem; font-size: 0.875rem;">
                    <ul style="margin: 0; padding-left: 1rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="nama@email.com">
                </div>

                <!-- Password -->
                <div class="form-group">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                        <label for="password" class="form-label" style="margin-bottom: 0;">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" style="font-size: 0.8125rem; color: var(--accent);">
                                Lupa password?
                            </a>
                        @endif
                    </div>
                    <input id="password" type="password" name="password" class="form-control" required autocomplete="current-password" placeholder="••••••••">
                </div>

                <!-- Remember Me -->
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: flex; align-items: center; cursor: pointer; font-size: 0.875rem; color: var(--text-light);">
                        <input id="remember_me" type="checkbox" name="remember" style="width: 1rem; height: 1rem; margin-right: 0.5rem; accent-color: var(--primary);">
                        <span>Ingat saya</span>
                    </label>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.875rem; font-size: 1rem; font-weight: 600;">
                        Masuk Sekarang
                    </button>
                </div>

                <div style="text-align: center; font-size: 0.875rem; color: var(--text-light);">
                    Belum punya akun? <a href="{{ route('register') }}" style="color: var(--secondary); font-weight: 600;">Daftar di sini</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
