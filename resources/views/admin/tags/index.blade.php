@extends('layouts.admin')
@section('title', 'Kelola Tags')

@section('page-header')
<h1 style="font-size:1.5rem;font-weight:900;margin:0;">🔖 Kelola Tags</h1>
@endsection

@section('content')
<div style="display:grid;grid-template-columns:1fr 320px;gap:1.5rem;align-items:start;">

    <!-- Tags Table -->
    <div class="card">
        <div class="table-wrapper" style="border:none;border-radius:0;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Tag</th>
                        <th>Slug</th>
                        <th>Jumlah Post</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tags as $tag)
                    <tr>
                        <td>
                            <span class="badge badge-primary" style="font-size:0.85rem;">#{{ $tag->name }}</span>
                        </td>
                        <td style="font-size:0.8rem;color:var(--text-muted);font-family:var(--font-mono);">{{ $tag->slug }}</td>
                        <td><span class="badge badge-gray">{{ $tag->posts_count }}</span></td>
                        <td>
                            <form method="POST" action="{{ route('admin.tags.destroy', $tag) }}" id="del-tag-{{ $tag->id }}" style="margin:0;">
                                @csrf @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('del-tag-{{ $tag->id }}', '#{{ $tag->name }}')">🗑 Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align:center;padding:2rem;color:var(--text-muted);">Belum ada tag.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($tags->hasPages())
        <div class="card-footer">
            <div class="pagination" style="margin-top:0;">
                @foreach($tags->getUrlRange(1, $tags->lastPage()) as $page => $url)
                @if($page == $tags->currentPage())
                <span class="page-btn active">{{ $page }}</span>
                @else
                <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
                @endif
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <!-- Add Tag Form -->
    <div class="card" style="position:sticky;top:88px;">
        <div class="card-header">
            <h3 style="font-family:var(--font-sans);font-size:0.95rem;font-weight:800;margin:0;">✚ Tambah Tag Baru</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.tags.store') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Nama Tag</label>
                    <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                           value="{{ old('name') }}" placeholder="Nama tag baru..." autofocus>
                    @error('name') <div class="form-error">✕ {{ $message }}</div> @enderror
                    <div class="form-hint">Tag akan otomatis di-slugify.</div>
                </div>
                <button type="submit" class="btn btn-primary w-full" style="justify-content:center;">✚ Tambah Tag</button>
            </form>
        </div>
    </div>

</div>
@endsection
