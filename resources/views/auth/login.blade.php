@extends('layouts.auth')
@section('title', 'Masuk')

@section('content')
<div class="auth-card">
    <div class="auth-logo" style="display:flex;flex-direction:column;align-items:center;gap:0.75rem;margin-bottom:1.5rem;">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height:60px;width:60px;object-fit:contain;border-radius:12px;box-shadow:var(--shadow-brand);">
        <div class="logo-text" style="font-size:1.8rem;margin:0;">NexaBlog</div>
    </div>


    <h1 class="auth-title">Selamat Datang!</h1>
    <p class="auth-subtitle">Masuk ke akun NexaBlog Anda</p>

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

    <form method="POST" action="{{ route('login') }}">
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
        </div>

        <div class="form-group">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:0.5rem;">
                <label class="form-label" for="password" style="margin:0;">Password</label>
                <a href="{{ route('password.request') }}" style="font-size:0.8rem;color:var(--brand);">Lupa password?</a>
            </div>
            <div style="position:relative;">
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                    placeholder="Masukkan password"
                    required
                >
                <button type="button" onclick="togglePassword('password', 'eye-login')" style="position:absolute;right:0.75rem;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text-muted);font-size:1rem;" id="eye-login">👁️</button>
            </div>
        </div>

        <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:1.25rem;">
            <input type="checkbox" id="remember" name="remember" style="accent-color:var(--brand);">
            <label for="remember" style="font-size:0.875rem;color:var(--text-secondary);cursor:pointer;">Ingat saya</label>
        </div>

        <button type="submit" class="btn btn-primary w-full" style="justify-content:center;">
            Masuk ke Akun
        </button>
    </form>

    <div class="auth-footer">
        Belum punya akun? <a href="{{ route('register') }}" style="font-weight:700;color:var(--brand);">Daftar Sekarang</a>
    </div>

    <!-- Demo Accounts -->
    <div style="margin-top:1.5rem;padding:1rem;background:rgba(var(--bg-card-rgb), 0.35);backdrop-filter:blur(10px);-webkit-backdrop-filter:blur(10px);border-radius:var(--radius-md);border:1px solid var(--border-color);">
        <p style="font-size:0.75rem;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.5rem;">Demo Akun</p>
        <div style="display:flex;flex-direction:column;gap:0.25rem;font-size:0.775rem;color:var(--text-secondary);">
            <div>🔴 <strong>superadmin@nexablog.com</strong> / password</div>
            <div>🟡 <strong>admin@nexablog.com</strong> / password</div>
            <div>🟢 <strong>user@nexablog.com</strong> / password</div>
        </div>
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
