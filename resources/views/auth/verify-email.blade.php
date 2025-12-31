@extends('layouts.app')

@section('title', 'Verifikasi Email')

@section('content')
<div class="container">
    <div style="max-width: 500px; margin: 4rem auto;">
        <div class="card" style="padding: 2.5rem;">
            <div style="text-align: center; margin-bottom: 2rem;">
                <h2 style="color: var(--primary); margin-bottom: 0.5rem;">Verifikasi Email</h2>
                <div style="color: var(--text-light); font-size: 0.875rem; line-height: 1.5;">
                    Terima kasih telah mendaftar! Sebelum memulai, harap verifikasi alamat email Anda dengan mengklik link yang baru saja kami kirimkan. Jika Anda tidak menerima email, kami dengan senang hati mengirimkan kembali.
                </div>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="alert alert-success" style="margin-bottom: 1.5rem; font-size: 0.875rem;">
                    Link verifikasi baru telah dikirimkan ke alamat email yang Anda berikan saat pendaftaran.
                </div>
            @endif

            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 2rem;">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        Kirim Ulang Email Verifikasi
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" style="background: none; border: none; cursor: pointer; color: var(--text-light); font-size: 0.875rem; text-decoration: underline;">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
