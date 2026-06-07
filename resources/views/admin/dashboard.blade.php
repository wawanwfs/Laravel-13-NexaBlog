@extends('layouts.admin')
@section('title', 'Dashboard Admin')

@section('page-header')
<div style="display:flex;align-items:center;justify-content:space-between;">
    <div>
        <h1 style="font-size:1.5rem;font-weight:900;margin:0;">📊 Dashboard Overview</h1>
        <p style="color:var(--text-muted);font-size:0.875rem;margin:0.25rem 0 0;">Selamat datang, {{ auth()->user()->name }}!</p>
    </div>
    <div>
        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">✚ Tulis Artikel</a>
    </div>
</div>
@endsection

@section('content')

<!-- Stat Cards -->
<div class="stat-cards">
    <div class="stat-card">
        <div class="icon" style="background:rgba(99,102,241,0.12);color:var(--brand);">📝</div>
        <div class="value">{{ $stats['posts'] }}</div>
        <div class="name">Total Posts</div>
        <div style="font-size:0.775rem;color:var(--success);margin-top:0.25rem;">{{ $stats['published'] }} published · {{ $stats['drafts'] }} draft</div>
    </div>
    <div class="stat-card">
        <div class="icon" style="background:rgba(16,185,129,0.12);color:var(--success);">👥</div>
        <div class="value">{{ $stats['users'] }}</div>
        <div class="name">Total Users</div>
    </div>
    <div class="stat-card">
        <div class="icon" style="background:rgba(245,158,11,0.12);color:var(--warning);">💬</div>
        <div class="value">{{ $stats['comments'] }}</div>
        <div class="name">Total Komentar</div>
        @if($stats['pending'] > 0)
        <div style="font-size:0.775rem;color:var(--warning);margin-top:0.25rem;">{{ $stats['pending'] }} menunggu moderasi</div>
        @endif
    </div>
    <div class="stat-card">
        <div class="icon" style="background:rgba(59,130,246,0.12);color:var(--info);">👁</div>
        <div class="value">{{ number_format($stats['views']) }}</div>
        <div class="name">Total Views</div>
    </div>
</div>

<div style="display:grid;grid-template-columns:2fr 1fr;gap:1.5rem;margin-top:0.5rem;">

    <!-- Recent Posts -->
    <div class="card">
        <div class="card-header" style="display:flex;align-items:center;justify-content:space-between;">
            <h2 style="font-family:var(--font-sans);font-size:0.95rem;font-weight:800;margin:0;">📝 Artikel Terbaru</h2>
            <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary btn-sm">Lihat Semua</a>
        </div>
        <div class="table-wrapper" style="border-radius:0;border:none;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Status</th>
                        <th>Penulis</th>
                        <th>Views</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentPosts as $post)
                    <tr>
                        <td>
                            <div style="font-weight:600;max-width:220px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $post->title }}</div>
                            @if($post->category)
                            <div style="font-size:0.75rem;color:var(--text-muted);">{{ $post->category->name }}</div>
                            @endif
                        </td>
                        <td>
                            @if($post->status === 'published')
                            <span class="badge badge-success">Published</span>
                            @else
                            <span class="badge badge-gray">Draft</span>
                            @endif
                        </td>
                        <td style="font-size:0.8rem;color:var(--text-secondary);">{{ $post->user->name }}</td>
                        <td style="font-size:0.875rem;">{{ number_format($post->views) }}</td>
                        <td>
                            <div style="display:flex;gap:0.375rem;">
                                <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-secondary btn-sm">✏️</a>
                                <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-secondary btn-sm" target="_blank">👁</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div style="display:flex;flex-direction:column;gap:1.5rem;">
        <!-- Pending Comments -->
        @if($pendingComments->count() > 0)
        <div class="card">
            <div class="card-header" style="display:flex;align-items:center;justify-content:space-between;">
                <h2 style="font-family:var(--font-sans);font-size:0.95rem;font-weight:800;margin:0;">⏳ Komentar Pending</h2>
                <a href="{{ route('admin.comments.index') }}" class="btn btn-secondary btn-sm">Kelola</a>
            </div>
            <div class="card-body" style="padding:0.75rem;">
                @foreach($pendingComments as $comment)
                <div style="padding:0.75rem;border-radius:var(--radius-md);background:var(--bg-secondary);margin-bottom:0.5rem;">
                    <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.35rem;">
                        <img src="{{ $comment->user->avatar_url }}" style="width:24px;height:24px;border-radius:50%;">
                        <span style="font-size:0.775rem;font-weight:700;">{{ $comment->user->name }}</span>
                        <span style="font-size:0.7rem;color:var(--text-muted);">di "{{ Str::limit($comment->post->title, 20) }}"</span>
                    </div>
                    <p style="font-size:0.8rem;color:var(--text-secondary);margin:0 0 0.5rem;">{{ Str::limit($comment->content, 80) }}</p>
                    <div style="display:flex;gap:0.375rem;">
                        <form method="POST" action="{{ route('admin.comments.approve', $comment) }}" style="margin:0;">
                            @csrf @method('PATCH')
                            <button class="btn btn-success btn-sm" style="font-size:0.75rem;padding:0.2rem 0.6rem;">✓ Setuju</button>
                        </form>
                        <form method="POST" action="{{ route('admin.comments.reject', $comment) }}" style="margin:0;">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" style="font-size:0.75rem;padding:0.2rem 0.6rem;">✕ Hapus</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Top Posts -->
        <div class="card">
            <div class="card-header">
                <h2 style="font-family:var(--font-sans);font-size:0.95rem;font-weight:800;margin:0;">🔥 Artikel Terpopuler</h2>
            </div>
            <div class="card-body" style="padding:0.75rem;">
                @foreach($topPosts as $i => $post)
                <div style="display:flex;align-items:center;gap:0.75rem;padding:0.625rem 0.5rem;border-radius:var(--radius-md);transition:background 0.2s;" onmouseover="this.style.background='var(--bg-secondary)'" onmouseout="this.style.background=''">
                    <span style="width:24px;height:24px;border-radius:50%;background:var(--gradient-brand);color:white;display:flex;align-items:center;justify-content:center;font-size:0.75rem;font-weight:800;flex-shrink:0;">{{ $i+1 }}</span>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:0.8rem;font-weight:600;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $post->title }}</div>
                        <div style="font-size:0.7rem;color:var(--text-muted);">{{ number_format($post->views) }} views</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>
@endsection
