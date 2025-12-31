@extends('layouts.app')

@section('title', 'Lupa Password')

@section('content')
<div class="container">
    <div style="max-width: 450px; margin: 4rem auto;">
        <div class="card" style="padding: 2.5rem;">
            <div style="text-align: center; margin-bottom: 2rem;">
                <h2 style="color: var(--primary); margin-bottom: 0.5rem;">Lupa Password?</h2>
                <div style="color: var(--text-light); font-size: 0.875rem; line-height: 1.5;">
                    Lupa password? Tidak masalah. Beritahu kami alamat email Anda dan kami akan mengirimkan link reset password.
                </div>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="alert alert-success" style="margin-bottom: 1rem;">
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

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus placeholder="nama@email.com">
                </div>

                <div style="margin-top: 2rem;">
                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.875rem; font-weight: 600;">
                        Kirim Link Reset Password
                    </button>
                </div>

                <div style="text-align: center; margin-top: 1.5rem;">
                    <a href="{{ route('login') }}" style="font-size: 0.875rem; color: var(--accent);">Kembali ke Login</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
