@extends('layouts.admin')
@section('title', 'Edit User')

@section('page-header')
<div style="display:flex;align-items:center;gap:1rem;">
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">← Kembali</a>
    <h1 style="font-size:1.5rem;font-weight:900;margin:0;">✏️ Edit User</h1>
</div>
@endsection

@section('content')
<div style="max-width:560px;">
    <div class="card">
        <div class="card-header" style="display:flex;align-items:center;gap:0.75rem;">
            <img src="{{ $user->avatar_url }}" style="width:44px;height:44px;border-radius:50%;object-fit:cover;">
            <div>
                <div style="font-weight:800;">{{ $user->name }}</div>
                <div style="font-size:0.775rem;color:var(--text-muted);">{{ $user->email }}</div>
            </div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.users.update', $user) }}">
                @csrf @method('PUT')

                <div class="form-group">
                    <label class="form-label">Nama Lengkap *</label>
                    <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                           value="{{ old('name', $user->name) }}" required>
                    @error('name') <div class="form-error">✕ {{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Email *</label>
                    <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                           value="{{ old('email', $user->email) }}" required>
                    @error('email') <div class="form-error">✕ {{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Password Baru <span style="color:var(--text-muted);font-weight:400;">(kosongkan jika tidak diubah)</span></label>
                    <input type="password" name="password" class="form-control" placeholder="Biarkan kosong jika tidak diubah">
                </div>

                <div class="form-group">
                    <label class="form-label">Role *</label>
                    <select name="role" class="form-control" {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                        <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>👤 User</option>
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>⚙️ Admin</option>
                        <option value="superadmin" {{ old('role', $user->role) === 'superadmin' ? 'selected' : '' }}>🔴 Superadmin</option>
                    </select>
                    @if($user->id === auth()->id())
                    <input type="hidden" name="role" value="{{ $user->role }}">
                    <div class="form-hint">⚠️ Tidak bisa mengubah role akun sendiri.</div>
                    @endif
                </div>

                <div class="form-group">
                    <label class="form-label">Bio</label>
                    <textarea name="bio" class="form-control" rows="3" placeholder="Bio singkat...">{{ old('bio', $user->bio) }}</textarea>
                </div>

                <div style="display:flex;gap:0.75rem;margin-top:1.5rem;">
                    <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
