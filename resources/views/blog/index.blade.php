@extends('layouts.app')
@section('title', 'Blog')

@section('content')
<div style="padding: 3rem 0;">
    <div class="container">
        <div style="display:grid;grid-template-columns:1fr 280px;gap:2.5rem;align-items:start;">

            <!-- Main content -->
            <div>
                <!-- Header -->
                <div class="animate-on-scroll" style="margin-bottom:2rem;">
                    <h1 style="font-size:2rem;margin-bottom:0.5rem;">
                        @if($selectedCategory)
                            Kategori: {{ ucfirst($selectedCategory) }}
                        @elseif($selectedTag)
                            Tag: #{{ $selectedTag }}
                        @elseif($searchQuery)
                            Hasil pencarian: "{{ $searchQuery }}"
                        @else
                            Semua Artikel
                        @endif
                    </h1>
                    <p style="color:var(--text-muted);">Menampilkan {{ $posts->total() }} artikel</p>
                </div>

                <!-- Search Bar -->
                <div class="animate-on-scroll delay-1" style="margin-bottom:2rem;">
                    <form method="GET" action="{{ route('blog.index') }}" style="display:flex;gap:0.5rem;">
                        <input type="text" name="search" value="{{ $searchQuery }}" class="form-control" placeholder="Cari artikel..." style="flex:1;">
                        @if($selectedCategory)
                        <input type="hidden" name="category" value="{{ $selectedCategory }}">
                        @endif
                        <button type="submit" class="btn btn-primary">🔍 Cari</button>
                        @if($searchQuery || $selectedCategory || $selectedTag)
                        <a href="{{ route('blog.index') }}" class="btn btn-secondary">✕ Reset</a>
                        @endif
                    </form>
                </div>

                <!-- Posts Grid -->
                @if($posts->count())
                <div class="posts-grid">
                    @foreach($posts as $i => $post)
                    <div class="post-card animate-on-scroll delay-{{ min($i % 3, 5) }}">
                        @if($post->thumbnail)
                        <div class="post-card-image">
                            <img src="{{ $post->thumbnail_url }}" alt="{{ $post->title }}" loading="lazy">
                        </div>
                        @else
                        <div class="post-card-image" style="background:var(--gradient-card);display:flex;align-items:center;justify-content:center;">
                            <span style="font-size:3rem;">📝</span>
                        </div>
                        @endif
                        <div class="post-card-body">
                            @if($post->category)
                            <a href="{{ route('blog.category', $post->category->slug) }}">
                                <span class="post-card-category" style="background:{{ $post->category->color }};">{{ $post->category->name }}</span>
                            </a>
                            @endif
                            <h2 class="post-card-title">
                                <a href="{{ route('blog.show', $post->slug) }}" style="color:inherit;text-decoration:none;">{{ $post->title }}</a>
                            </h2>
                            <p class="post-card-excerpt">{{ $post->excerpt }}</p>
                            <div class="post-card-meta">
                                <div class="post-card-author">
                                    <img src="{{ $post->user->avatar_url }}" alt="{{ $post->user->name }}">
                                    <span>{{ $post->user->name }}</span>
                                </div>
                                <span>{{ $post->published_at?->format('d M Y') }}</span>
                                <span>⏱ {{ $post->reading_time }} mnt</span>
                                <span>👁 {{ number_format($post->views) }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="pagination">
                    @if($posts->onFirstPage())
                        <span class="page-btn disabled">←</span>
                    @else
                        <a href="{{ $posts->previousPageUrl() }}" class="page-btn">←</a>
                    @endif

                    @foreach($posts->getUrlRange(max(1, $posts->currentPage()-2), min($posts->lastPage(), $posts->currentPage()+2)) as $page => $url)
                        @if($page == $posts->currentPage())
                            <span class="page-btn active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if($posts->hasMorePages())
                        <a href="{{ $posts->nextPageUrl() }}" class="page-btn">→</a>
                    @else
                        <span class="page-btn disabled">→</span>
                    @endif
                </div>

                @else
                <div style="text-align:center;padding:5rem 2rem;color:var(--text-muted);">
                    <span style="font-size:4rem;">📭</span>
                    <h3 style="margin-top:1rem;color:var(--text-secondary);">Tidak ada artikel ditemukan</h3>
                    <p>Coba ubah kata kunci pencarian atau pilih kategori lain.</p>
                    <a href="{{ route('blog.index') }}" class="btn btn-primary" style="margin-top:1rem;">Lihat Semua Artikel</a>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <aside style="position:sticky;top:88px;">
                <!-- Categories -->
                <div class="card" style="margin-bottom:1.5rem;">
                    <div class="card-header">
                        <h3 style="font-family:var(--font-sans);font-size:0.95rem;font-weight:800;margin:0;">🏷️ Kategori</h3>
                    </div>
                    <div class="card-body" style="padding:0.75rem;">
                        @foreach($categories as $cat)
                        <a href="{{ route('blog.category', $cat->slug) }}"
                           style="display:flex;align-items:center;justify-content:space-between;padding:0.6rem 0.75rem;border-radius:var(--radius-md);color:{{ $selectedCategory === $cat->slug ? 'white' : 'var(--text-secondary)' }};background:{{ $selectedCategory === $cat->slug ? $cat->color : 'transparent' }};text-decoration:none;font-size:0.875rem;font-weight:500;transition:all 0.2s;margin-bottom:0.1rem;"
                           onmouseover="if('{{ $selectedCategory }}' !== '{{ $cat->slug }}') { this.style.background='var(--bg-tertiary)';this.style.color='var(--brand)'; }"
                           onmouseout="if('{{ $selectedCategory }}' !== '{{ $cat->slug }}') { this.style.background='transparent';this.style.color='var(--text-secondary)'; }">
                            <span>{{ $cat->name }}</span>
                            <span class="badge badge-gray">{{ $cat->published_posts_count }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>

                <!-- Tags -->
                @if($tags->count())
                <div class="card">
                    <div class="card-header">
                        <h3 style="font-family:var(--font-sans);font-size:0.95rem;font-weight:800;margin:0;">🔖 Tags Populer</h3>
                    </div>
                    <div class="card-body">
                        <div style="display:flex;flex-wrap:wrap;gap:0.5rem;">
                            @foreach($tags as $tag)
                            <a href="{{ route('blog.index', ['tag' => $tag->slug]) }}"
                               style="padding:0.3rem 0.75rem;border-radius:var(--radius-full);font-size:0.775rem;font-weight:600;background:{{ $selectedTag === $tag->slug ? 'var(--gradient-brand)' : 'var(--bg-tertiary)' }};color:{{ $selectedTag === $tag->slug ? 'white' : 'var(--text-secondary)' }};text-decoration:none;border:1px solid var(--border-color);transition:all 0.2s;"
                               onmouseover="this.style.background='var(--brand)';this.style.color='white'"
                               onmouseout="this.style.background='{{ $selectedTag === $tag->slug ? 'var(--gradient-brand)' : 'var(--bg-tertiary)' }}';this.style.color='{{ $selectedTag === $tag->slug ? 'white' : 'var(--text-secondary)' }}'">
                                #{{ $tag->name }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </aside>

        </div>
    </div>
</div>
@endsection
