@extends('layouts.admin')
@section('title', 'Moderasi Komentar')

@section('page-header')
<h1 style="font-size:1.5rem;font-weight:900;margin:0;">💬 Moderasi Komentar</h1>
@endsection

@section('content')
<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;">

    <!-- Pending Comments -->
    <div>
        <h2 style="font-family:var(--font-sans);font-size:1rem;font-weight:800;margin-bottom:1rem;display:flex;align-items:center;gap:0.5rem;">
            ⏳ Menunggu Moderasi
            @if($pending->total() > 0)
            <span class="badge badge-warning" style="background:rgba(245,158,11,0.15);color:var(--warning);">{{ $pending->total() }}</span>
            @endif
        </h2>

        @forelse($pending as $comment)
        <div class="card" style="margin-bottom:1rem;">
            <div class="card-body">
                <div style="display:flex;align-items:center;gap:0.625rem;margin-bottom:0.75rem;">
                    <img src="{{ $comment->user->avatar_url }}" style="width:36px;height:36px;border-radius:50%;object-fit:cover;">
                    <div>
                        <div style="font-weight:700;font-size:0.875rem;">{{ $comment->user->name }}</div>
                        <div style="font-size:0.75rem;color:var(--text-muted);">{{ $comment->created_at->diffForHumans() }}</div>
                    </div>
                </div>
                <div style="font-size:0.8rem;color:var(--text-muted);margin-bottom:0.5rem;">
                    Post: <a href="{{ route('blog.show', $comment->post->slug) }}" style="color:var(--brand);" target="_blank">{{ Str::limit($comment->post->title, 40) }}</a>
                </div>
                <p style="font-size:0.9rem;color:var(--text-primary);line-height:1.5;margin-bottom:1rem;padding:0.75rem;background:var(--bg-secondary);border-radius:var(--radius-md);">{{ $comment->content }}</p>
                <div style="display:flex;gap:0.5rem;">
                    <form method="POST" action="{{ route('admin.comments.approve', $comment) }}" style="margin:0;">
                        @csrf @method('PATCH')
                        <button class="btn btn-success btn-sm">✓ Setujui</button>
                    </form>
                    <form method="POST" action="{{ route('admin.comments.reject', $comment) }}" id="del-c-{{ $comment->id }}" style="margin:0;">
                        @csrf @method('DELETE')
                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('del-c-{{ $comment->id }}', 'komentar ini')">✕ Hapus</button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="card" style="text-align:center;padding:2.5rem;">
            <span style="font-size:2.5rem;">✅</span>
            <p style="color:var(--text-muted);margin-top:0.5rem;">Tidak ada komentar yang menunggu.</p>
        </div>
        @endforelse

        @if($pending->hasPages())
        <div class="pagination" style="margin-top:1rem;">
            @foreach($pending->getUrlRange(1, $pending->lastPage()) as $page => $url)
            @if($page == $pending->currentPage())
            <span class="page-btn active">{{ $page }}</span>
            @else
            <a href="{{ $url }}#pending" class="page-btn">{{ $page }}</a>
            @endif
            @endforeach
        </div>
        @endif
    </div>

    <!-- Approved Comments -->
    <div>
        <h2 style="font-family:var(--font-sans);font-size:1rem;font-weight:800;margin-bottom:1rem;display:flex;align-items:center;gap:0.5rem;">
            ✅ Sudah Disetujui
            <span class="badge badge-success">{{ $approved->total() }}</span>
        </h2>

        @forelse($approved as $comment)
        <div class="card" style="margin-bottom:1rem;">
            <div class="card-body">
                <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:0.5rem;">
                    <div style="display:flex;align-items:center;gap:0.625rem;margin-bottom:0.5rem;">
                        <img src="{{ $comment->user->avatar_url }}" style="width:32px;height:32px;border-radius:50%;object-fit:cover;">
                        <div>
                            <div style="font-weight:700;font-size:0.8rem;">{{ $comment->user->name }}</div>
                            <div style="font-size:0.7rem;color:var(--text-muted);">{{ $comment->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('admin.comments.reject', $comment) }}" id="del-ca-{{ $comment->id }}" style="margin:0;">
                        @csrf @method('DELETE')
                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('del-ca-{{ $comment->id }}', 'komentar ini')" style="font-size:0.75rem;padding:0.2rem 0.5rem;">🗑</button>
                    </form>
                </div>
                <div style="font-size:0.75rem;color:var(--text-muted);margin-bottom:0.35rem;">
                    Post: <a href="{{ route('blog.show', $comment->post->slug) }}" style="color:var(--brand);" target="_blank">{{ Str::limit($comment->post->title, 35) }}</a>
                </div>
                <p style="font-size:0.85rem;color:var(--text-secondary);line-height:1.5;margin:0;">{{ Str::limit($comment->content, 120) }}</p>
            </div>
        </div>
        @empty
        <div class="card" style="text-align:center;padding:2.5rem;">
            <span style="font-size:2.5rem;">💬</span>
            <p style="color:var(--text-muted);margin-top:0.5rem;">Belum ada komentar yang disetujui.</p>
        </div>
        @endforelse
    </div>

</div>
@endsection
