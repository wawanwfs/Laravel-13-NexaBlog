@extends('layouts.auth')
@section('title', 'Lupa Password')

@section('content')
<div class="auth-card">
    <div class="auth-logo" style="display:flex;flex-direction:column;align-items:center;gap:0.75rem;margin-bottom:1.5rem;">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height:60px;width:60px;object-fit:contain;border-radius:12px;box-shadow:var(--shadow-brand);">
        <div class="logo-text" style="font-size:1.8rem;margin:0;">NexaBlog</div>
    </div>


    <h1 class="auth-title">Lupa Password?</h1>
    <p class="auth-subtitle">Masukkan email Anda dan kami akan mengirimkan link reset password.</p>

    @if(session('success'))
    <div class="alert alert-success">
        <span>✓</span> {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-error">
        <span>✕</span>
        <div>
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="form-group">
            <label class="form-label" for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                value="{{ old('email') }}"
                placeholder="nama@email.com"
                autofocus
                required
            >
            @error('email')
            <div class="form-error">✕ {{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-full" style="justify-content:center;">
            Kirim Link Reset Password
        </button>
    </form>

    <div class="auth-footer">
        Ingat password? <a href="{{ route('login') }}" style="font-weight:700;color:var(--brand);">Kembali Masuk</a>
    </div>
</div>
@endsection
