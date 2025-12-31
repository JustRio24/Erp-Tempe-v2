@extends('layouts.app')

@section('title', 'Daftar Akun')

@section('content')
<div class="container">
    <div style="max-width: 500px; margin: 2rem auto;">
        <div class="card" style="padding: 2.5rem; border-top: 5px solid var(--secondary);">
            <div style="text-align: center; margin-bottom: 2rem;">
                <h2 style="color: var(--primary); margin-bottom: 0.5rem;">Buat Akun Baru</h2>
                <p style="color: var(--text-light);">Bergabunglah dengan Tempe 3 Puteri</p>
            </div>

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

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="form-group">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input id="name" type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Nama Anda">
                </div>

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required autocomplete="username" placeholder="nama@email.com">
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" type="password" name="password" class="form-control" required autocomplete="new-password" placeholder="Minimal 8 karakter">
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required autocomplete="new-password" placeholder="Ulangi password">
                </div>

                <div style="margin-bottom: 1.5rem; margin-top: 2rem;">
                    <button type="submit" class="btn btn-secondary" style="width: 100%; padding: 0.875rem; font-size: 1rem; font-weight: 600;">
                        Daftar Akun
                    </button>
                </div>

                <div style="text-align: center; font-size: 0.875rem; color: var(--text-light);">
                    Sudah punya akun? <a href="{{ route('login') }}" style="color: var(--primary); font-weight: 600;">Masuk di sini</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
