@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="container">
    <div style="max-width: 450px; margin: 4rem auto;">
        <div class="card" style="padding: 2.5rem;">
            <div style="text-align: center; margin-bottom: 2rem;">
                <h2 style="color: var(--primary); margin-bottom: 0.5rem;">Reset Password</h2>
                <p style="color: var(--text-light);">Silakan buat password baru Anda</p>
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

            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" name="email" class="form-control" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label">Password Baru</label>
                    <input id="password" type="password" name="password" class="form-control" required autocomplete="new-password">
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required autocomplete="new-password">
                </div>

                <div style="margin-top: 2rem;">
                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.875rem; font-weight: 600;">
                        Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
