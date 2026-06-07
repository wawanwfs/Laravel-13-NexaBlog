@extends('layouts.auth')
@section('title', 'Reset Password')

@section('content')
<div class="auth-card">
    <div class="auth-logo" style="display:flex;flex-direction:column;align-items:center;gap:0.75rem;margin-bottom:1.5rem;">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height:60px;width:60px;object-fit:contain;border-radius:12px;box-shadow:var(--shadow-brand);">
        <div class="logo-text" style="font-size:1.8rem;margin:0;">NexaBlog</div>
    </div>


    <h1 class="auth-title">Reset Password</h1>
    <p class="auth-subtitle">Buat password baru yang kuat untuk akun Anda.</p>

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

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">

        <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" value="{{ $email }}" disabled style="opacity:0.6;">
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Password Baru</label>
            <div style="position:relative;">
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                    placeholder="Minimal 8 karakter"
                    autofocus
                    required
                >
                <button type="button" onclick="togglePassword('password','eye1')" style="position:absolute;right:0.75rem;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text-muted);" id="eye1">👁️</button>
            </div>
            @error('password')
            <div class="form-error">✕ {{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="password_confirmation">Konfirmasi Password Baru</label>
            <div style="position:relative;">
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    class="form-control"
                    placeholder="Ulangi password baru"
                    required
                >
                <button type="button" onclick="togglePassword('password_confirmation','eye2')" style="position:absolute;right:0.75rem;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text-muted);" id="eye2">👁️</button>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-full" style="justify-content:center;">
            Reset Password
        </button>
    </form>
</div>

<script>
function togglePassword(id, eyeId) {
    const input = document.getElementById(id);
    const eye = document.getElementById(eyeId);
    input.type = input.type === 'password' ? 'text' : 'password';
    eye.textContent = input.type === 'password' ? '👁️' : '🙈';
}
</script>
@endsection
