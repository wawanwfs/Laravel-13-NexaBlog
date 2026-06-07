@extends('layouts.admin')
@section('title', 'User Management')

@section('page-header')
<div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
    <div>
        <h1 style="font-size:1.5rem;font-weight:900;margin:0;">👥 User Management</h1>
        <p style="color:var(--text-muted);font-size:0.875rem;margin:0.25rem 0 0;">{{ $users->total() }} pengguna terdaftar</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">✚ Tambah User</a>
</div>
@endsection

@section('content')

<!-- Filters -->
<form method="GET" action="{{ route('admin.users.index') }}" style="display:flex;gap:0.75rem;flex-wrap:wrap;margin-bottom:1.5rem;">
    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari nama atau email..." style="flex:1;min-width:200px;">
    <select name="role" class="form-control" style="width:140px;">
        <option value="">Semua Role</option>
        <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>👤 User</option>
        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>⚙️ Admin</option>
        <option value="superadmin" {{ request('role') === 'superadmin' ? 'selected' : '' }}>🔴 Superadmin</option>
    </select>
    <button type="submit" class="btn btn-primary">🔍 Filter</button>
    @if(request()->hasAny(['search','role']))
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">✕ Reset</a>
    @endif
</form>

<div class="card">
    <div class="table-wrapper" style="border:none;border-radius:0;">
        <table class="table">
            <thead>
                <tr>
                    <th>Pengguna</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Bergabung</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:0.75rem;">
                            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" style="width:40px;height:40px;border-radius:50%;object-fit:cover;border:2px solid var(--border-color);">
                            <div>
                                <div style="font-weight:700;font-size:0.875rem;">{{ $user->name }}</div>
                                @if($user->bio)
                                <div style="font-size:0.75rem;color:var(--text-muted);">{{ Str::limit($user->bio, 40) }}</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td style="font-size:0.875rem;color:var(--text-secondary);">{{ $user->email }}</td>
                    <td>
                        @if($user->isSuperAdmin())
                        <span class="badge" style="background:rgba(239,68,68,0.12);color:var(--danger);">🔴 Superadmin</span>
                        @elseif($user->isAdmin())
                        <span class="badge badge-primary">⚙️ Admin</span>
                        @else
                        <span class="badge badge-gray">👤 User</span>
                        @endif
                    </td>
                    <td style="font-size:0.8rem;color:var(--text-muted);">{{ $user->created_at->format('d M Y') }}</td>
                    <td>
                        <div style="display:flex;gap:0.375rem;">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-secondary btn-sm">✏️ Edit</a>
                            @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" id="del-user-{{ $user->id }}" style="margin:0;">
                                @csrf @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('del-user-{{ $user->id }}', '{{ addslashes($user->name) }}')">🗑</button>
                            </form>
                            @else
                            <span class="btn btn-secondary btn-sm" style="opacity:0.4;cursor:not-allowed;" title="Tidak bisa menghapus akun sendiri">🗑</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;padding:3rem;color:var(--text-muted);">
                        <span style="font-size:2.5rem;">👥</span>
                        <p style="margin-top:0.5rem;">Tidak ada user ditemukan.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="card-footer">
        <div class="pagination" style="margin-top:0;">
            @if(!$users->onFirstPage())
            <a href="{{ $users->previousPageUrl() }}" class="page-btn">←</a>
            @endif
            @foreach($users->getUrlRange(max(1,$users->currentPage()-2), min($users->lastPage(),$users->currentPage()+2)) as $page => $url)
            @if($page == $users->currentPage())
            <span class="page-btn active">{{ $page }}</span>
            @else
            <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
            @endif
            @endforeach
            @if($users->hasMorePages())
            <a href="{{ $users->nextPageUrl() }}" class="page-btn">→</a>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection
