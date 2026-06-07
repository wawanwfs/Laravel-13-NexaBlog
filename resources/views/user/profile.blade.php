@extends('layouts.app')
@section('title', 'Edit Profil')

@section('content')
<div style="padding:3rem 0;">
    <div class="container-sm">
        <h1 class="animate-on-scroll" style="font-size:1.75rem;margin-bottom:0.5rem;">👤 Edit Profil</h1>
        <p style="color:var(--text-muted);margin-bottom:2rem;">Perbarui informasi akun dan kata sandi Anda.</p>

        <div style="display:grid;grid-template-columns:1fr 280px;gap:2rem;align-items:start;">

            <!-- Forms -->
            <div>
                <!-- Profile Info -->
                <div class="card animate-on-scroll delay-1" style="margin-bottom:1.5rem;">
                    <div class="card-header">
                        <h2 style="font-family:var(--font-sans);font-size:1rem;font-weight:800;margin:0;">Informasi Profil</h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('user.profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="form-group">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                       value="{{ old('name', $user->name) }}" required>
                                @error('name') <div class="form-error">✕ {{ $message }}</div> @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                       value="{{ old('email', $user->email) }}" required>
                                @error('email') <div class="form-error">✕ {{ $message }}</div> @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">No. Telepon <span style="color:var(--text-muted);font-weight:400;">(opsional)</span></label>
                                <input type="text" name="phone" class="form-control"
                                       value="{{ old('phone', $user->phone) }}" placeholder="+62 812 3456 7890">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Bio <span style="color:var(--text-muted);font-weight:400;">(maks. 500 karakter)</span></label>
                                <textarea name="bio" class="form-control" rows="4" placeholder="Ceritakan tentang diri Anda...">{{ old('bio', $user->bio) }}</textarea>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Foto Profil</label>
                                <input type="file" name="avatar" class="form-control" accept="image/*" onchange="previewAvatar(this)">
                                <div class="form-hint">Format: JPG, PNG, GIF. Maks 2MB.</div>
                            </div>

                            <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
                        </form>
                    </div>
                </div>

                <!-- Change Password -->
                <div class="card animate-on-scroll delay-2">
                    <div class="card-header">
                        <h2 style="font-family:var(--font-sans);font-size:1rem;font-weight:800;margin:0;">🔐 Ubah Password</h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('user.password.update') }}">
                            @csrf
                            @method('PATCH')

                            <div class="form-group">
                                <label class="form-label">Password Saat Ini</label>
                                <input type="password" name="current_password" class="form-control {{ $errors->has('current_password') ? 'is-invalid' : '' }}"
                                       placeholder="Password saat ini" required>
                                @error('current_password') <div class="form-error">✕ {{ $message }}</div> @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">Password Baru</label>
                                <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                       placeholder="Minimal 8 karakter" required>
                                @error('password') <div class="form-error">✕ {{ $message }}</div> @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" class="form-control"
                                       placeholder="Ulangi password baru" required>
                            </div>

                            <button type="submit" class="btn btn-primary">🔑 Ubah Password</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Profile Preview Sidebar -->
            <aside style="position:sticky;top:88px;">
                <div class="card animate-on-scroll">
                    <div class="card-body" style="text-align:center;">
                        <div style="position:relative;display:inline-block;margin-bottom:1rem;">
                            <img id="avatar-preview" src="{{ $user->avatar_url }}" alt="{{ $user->name }}"
                                 style="width:96px;height:96px;border-radius:50%;object-fit:cover;border:4px solid var(--brand);box-shadow:var(--shadow-brand);">
                            <div style="position:absolute;bottom:0;right:0;width:28px;height:28px;background:var(--brand);border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-size:0.7rem;border:2px solid var(--bg-card);">✏️</div>
                        </div>
                        <div style="font-weight:800;font-size:1rem;">{{ $user->name }}</div>
                        <div style="font-size:0.775rem;color:var(--text-muted);margin-bottom:0.75rem;">{{ $user->email }}</div>
                        @if($user->isSuperAdmin())
                        <span class="badge" style="background:rgba(239,68,68,0.15);color:var(--danger);">Superadmin</span>
                        @elseif($user->isAdmin())
                        <span class="badge badge-primary">Admin</span>
                        @else
                        <span class="badge badge-gray">User</span>
                        @endif
                        <div style="margin-top:1rem;padding-top:1rem;border-top:1px solid var(--border-color);font-size:0.8rem;color:var(--text-muted);">
                            Bergabung {{ $user->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>

                <a href="{{ route('user.dashboard') }}" class="btn btn-secondary w-full" style="margin-top:1rem;justify-content:center;">← Kembali ke Dashboard</a>
            </aside>
        </div>
    </div>
</div>

<script>
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatar-preview').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
