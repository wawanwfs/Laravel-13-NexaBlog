@extends('layouts.auth')
@section('title', 'Daftar')

@section('content')
<div class="auth-card">
    <div class="auth-logo" style="display:flex;flex-direction:column;align-items:center;gap:0.75rem;margin-bottom:1.5rem;">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height:60px;width:60px;object-fit:contain;border-radius:12px;box-shadow:var(--shadow-brand);">
        <div class="logo-text" style="font-size:1.8rem;margin:0;">NexaBlog</div>
    </div>


    <h1 class="auth-title">Buat Akun</h1>
    <p class="auth-subtitle">Bergabung dengan komunitas NexaBlog</p>

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

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <label class="form-label" for="name">Nama Lengkap</label>
            <input
                type="text"
                id="name"
                name="name"
                class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                value="{{ old('name') }}"
                placeholder="Nama lengkap Anda"
                autofocus
                required
            >
            @error('name')
            <div class="form-error">✕ {{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                value="{{ old('email') }}"
                placeholder="nama@email.com"
                required
            >
            @error('email')
            <div class="form-error">✕ {{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <div style="position:relative;">
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                    placeholder="Minimal 8 karakter"
                    required
                >
                <button type="button" onclick="togglePassword('password', 'eye1')" style="position:absolute;right:0.75rem;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text-muted);" id="eye1">👁️</button>
            </div>
            @error('password')
            <div class="form-error">✕ {{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
            <div style="position:relative;">
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    class="form-control"
                    placeholder="Ulangi password Anda"
                    required
                >
                <button type="button" onclick="togglePassword('password_confirmation', 'eye2')" style="position:absolute;right:0.75rem;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text-muted);" id="eye2">👁️</button>
            </div>
        </div>

        <div style="font-size:0.775rem;color:var(--text-muted);margin-bottom:1.25rem;">
            Dengan mendaftar, Anda menyetujui <a href="#" style="color:var(--brand);">Syarat & Ketentuan</a> dan <a href="#" style="color:var(--brand);">Kebijakan Privasi</a> kami.
        </div>

        <button type="submit" class="btn btn-primary w-full" style="justify-content:center;">
            Buat Akun Sekarang
        </button>
    </form>

    <div class="auth-footer">
        Sudah punya akun? <a href="{{ route('login') }}" style="font-weight:700;color:var(--brand);">Masuk</a>
    </div>
</div>

<script>
function togglePassword(id, eyeId) {
    const input = document.getElementById(id);
    const eye = document.getElementById(eyeId);
    if (input.type === 'password') {
        input.type = 'text';
        eye.textContent = '🙈';
    } else {
        input.type = 'password';
        eye.textContent = '👁️';
    }
}
</script>
@endsection
