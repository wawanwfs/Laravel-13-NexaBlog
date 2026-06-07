@extends('layouts.admin')
@section('title', 'Tambah User')

@section('page-header')
<div style="display:flex;align-items:center;gap:1rem;">
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">← Kembali</a>
    <h1 style="font-size:1.5rem;font-weight:900;margin:0;">✚ Tambah User Baru</h1>
</div>
@endsection

@section('content')
<div style="max-width:560px;">
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label">Nama Lengkap *</label>
                    <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                           value="{{ old('name') }}" required autofocus>
                    @error('name') <div class="form-error">✕ {{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Email *</label>
                    <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                           value="{{ old('email') }}" required>
                    @error('email') <div class="form-error">✕ {{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Password *</label>
                    <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                           placeholder="Minimal 8 karakter" required>
                    @error('password') <div class="form-error">✕ {{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Role *</label>
                    <select name="role" class="form-control" required>
                        <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>👤 User</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>⚙️ Admin</option>
                        <option value="superadmin" {{ old('role') === 'superadmin' ? 'selected' : '' }}>🔴 Superadmin</option>
                    </select>
                </div>

                <div style="display:flex;gap:0.75rem;margin-top:1.5rem;">
                    <button type="submit" class="btn btn-primary">💾 Buat User</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
