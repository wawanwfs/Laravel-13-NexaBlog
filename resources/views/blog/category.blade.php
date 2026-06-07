@extends('layouts.app')
@section('title', $category->name)

@section('content')
<div style="padding:3rem 0;">
    <div class="container">
        <!-- Category Header -->
        <div class="animate-on-scroll" style="text-align:center;margin-bottom:3rem;padding:3rem;background:var(--gradient-card);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);border-radius:var(--radius-xl);border:1px solid var(--border-color);">
            <div style="width:64px;height:64px;border-radius:50%;background:{{ $category->color }}20;border:3px solid {{ $category->color }};display:flex;align-items:center;justify-content:center;font-size:2rem;margin:0 auto 1rem;">
                🏷️
            </div>
            <h1 style="font-size:2rem;margin-bottom:0.5rem;">{{ $category->name }}</h1>
            @if($category->description)
            <p style="color:var(--text-secondary);max-width:500px;margin:0 auto;">{{ $category->description }}</p>
            @endif
            <div style="margin-top:1rem;">
                <span class="badge badge-primary">{{ $posts->total() }} Artikel</span>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 260px;gap:2rem;align-items:start;">
            <div>
                @if($posts->count())
                <div class="posts-grid">
                    @foreach($posts as $i => $post)
                    <div class="post-card animate-on-scroll delay-{{ min($i % 3, 5) }}">
                        <div class="post-card-image" style="@if(!$post->thumbnail) background:var(--gradient-card);display:flex;align-items:center;justify-content:center; @endif">
                            @if($post->thumbnail)
                            <img src="{{ $post->thumbnail_url }}" alt="{{ $post->title }}" loading="lazy">
                            @else
                            <span style="font-size:3rem;">📝</span>
                            @endif
                        </div>
                        <div class="post-card-body">
                            <h2 class="post-card-title">
                                <a href="{{ route('blog.show', $post->slug) }}" style="color:inherit;text-decoration:none;">{{ $post->title }}</a>
                            </h2>
                            <p class="post-card-excerpt">{{ $post->excerpt }}</p>
                            <div class="post-card-meta">
                                <div class="post-card-author">
                                    <img src="{{ $post->user->avatar_url }}" alt="{{ $post->user->name }}">
                                    <span>{{ $post->user->name }}</span>
                                </div>
                                <span>{{ $post->published_at?->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <!-- Pagination -->
                <div class="pagination">
                    @if(!$posts->onFirstPage())
                    <a href="{{ $posts->previousPageUrl() }}" class="page-btn">←</a>
                    @endif
                    @foreach($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
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
                @else
                <div style="text-align:center;padding:4rem;color:var(--text-muted);">
                    <p>Belum ada artikel dalam kategori ini.</p>
                    <a href="{{ route('blog.index') }}" class="btn btn-primary" style="margin-top:1rem;">Lihat Semua Artikel</a>
                </div>
                @endif
            </div>

            <!-- Sidebar: All Categories -->
            <aside style="position:sticky;top:88px;">
                <div class="card">
                    <div class="card-header">
                        <h3 style="font-family:var(--font-sans);font-size:0.95rem;font-weight:800;margin:0;">🏷️ Semua Kategori</h3>
                    </div>
                    <div class="card-body" style="padding:0.75rem;">
                        @foreach($categories as $cat)
                        <a href="{{ route('blog.category', $cat->slug) }}"
                           style="display:flex;align-items:center;justify-content:space-between;padding:0.6rem 0.75rem;border-radius:var(--radius-md);color:{{ $category->slug === $cat->slug ? 'white' : 'var(--text-secondary)' }};background:{{ $category->slug === $cat->slug ? $cat->color : 'transparent' }};text-decoration:none;font-size:0.875rem;font-weight:500;transition:all 0.2s;margin-bottom:0.1rem;">
                            <span>{{ $cat->name }}</span>
                            <span class="badge badge-gray">{{ $cat->published_posts_count }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>
@endsection
