@extends('layouts.admin')
@section('title', 'Kelola Posts')

@section('page-header')
<div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
    <div>
        <h1 style="font-size:1.5rem;font-weight:900;margin:0;">📝 Kelola Artikel</h1>
        <p style="color:var(--text-muted);font-size:0.875rem;margin:0.25rem 0 0;">Total {{ $posts->total() }} artikel</p>
    </div>
    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">✚ Tulis Artikel Baru</a>
</div>
@endsection

@section('content')

<!-- Filters -->
<form method="GET" action="{{ route('admin.posts.index') }}" style="display:flex;gap:0.75rem;flex-wrap:wrap;margin-bottom:1.5rem;">
    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari judul..." style="flex:1;min-width:200px;">
    <select name="status" class="form-control" style="width:140px;">
        <option value="">Semua Status</option>
        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
    </select>
    <select name="category" class="form-control" style="width:160px;">
        <option value="">Semua Kategori</option>
        @foreach($categories as $cat)
        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
        @endforeach
    </select>
    <button type="submit" class="btn btn-primary">🔍 Filter</button>
    @if(request()->hasAny(['search','status','category']))
    <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">✕ Reset</a>
    @endif
</form>

<!-- Table -->
<div class="card">
    <div class="table-wrapper" style="border:none;border-radius:0;">
        <table class="table">
            <thead>
                <tr>
                    <th style="width:40%;">Judul</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Views</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:0.75rem;">
                            @if($post->thumbnail)
                            <img src="{{ $post->thumbnail_url }}" style="width:48px;height:36px;border-radius:6px;object-fit:cover;flex-shrink:0;">
                            @else
                            <div style="width:48px;height:36px;border-radius:6px;background:var(--gradient-card);display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:1rem;">📝</div>
                            @endif
                            <div>
                                <div style="font-weight:700;font-size:0.875rem;max-width:280px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $post->title }}</div>
                                <div style="font-size:0.75rem;color:var(--text-muted);">oleh {{ $post->user->name }} · {{ $post->reading_time }} mnt baca</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($post->category)
                        <span class="badge" style="background:{{ $post->category->color }}20;color:{{ $post->category->color }};border:1px solid {{ $post->category->color }}40;">{{ $post->category->name }}</span>
                        @else
                        <span style="color:var(--text-muted);font-size:0.8rem;">—</span>
                        @endif
                    </td>
                    <td>
                        @if($post->status === 'published')
                        <span class="badge badge-success">✓ Published</span>
                        @else
                        <span class="badge badge-gray">Draft</span>
                        @endif
                        @if($post->featured)
                        <span class="badge" style="background:rgba(245,158,11,0.12);color:var(--warning);margin-left:0.25rem;">⭐</span>
                        @endif
                    </td>
                    <td style="font-size:0.875rem;font-weight:600;">{{ number_format($post->views) }}</td>
                    <td style="font-size:0.8rem;color:var(--text-muted);">{{ $post->created_at->format('d M Y') }}</td>
                    <td>
                        <div style="display:flex;gap:0.375rem;align-items:center;">
                            <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-secondary btn-sm" title="Edit">✏️</a>
                            <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-secondary btn-sm" target="_blank" title="Preview">👁</a>
                            <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" id="del-post-{{ $post->id }}" style="margin:0;">
                                @csrf @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('del-post-{{ $post->id }}', '{{ addslashes($post->title) }}')" title="Hapus">🗑</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:3rem;color:var(--text-muted);">
                        <span style="font-size:2.5rem;">📭</span>
                        <p style="margin-top:0.5rem;">Belum ada artikel. <a href="{{ route('admin.posts.create') }}" style="color:var(--brand);">Buat sekarang →</a></p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($posts->hasPages())
    <div class="card-footer">
        <div class="pagination" style="margin-top:0;">
            @if(!$posts->onFirstPage())
            <a href="{{ $posts->previousPageUrl() }}" class="page-btn">←</a>
            @endif
            @foreach($posts->getUrlRange(max(1,$posts->currentPage()-2), min($posts->lastPage(),$posts->currentPage()+2)) as $page => $url)
            @if($page == $posts->currentPage())
            <span class="page-btn active">{{ $page }}</span>
            @else
            <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
            @endif
            @endforeach
            @if($posts->hasMorePages())
            <a href="{{ $posts->nextPageUrl() }}" class="page-btn">→</a>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection
