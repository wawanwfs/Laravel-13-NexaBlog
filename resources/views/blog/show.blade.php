@extends('layouts.app')
@section('title', $post->title)
@section('meta_description', $post->excerpt)

@section('content')
<article style="padding:3rem 0;">
    <div class="container-sm">

        <!-- Breadcrumb -->
        <nav style="font-size:0.8rem;color:var(--text-muted);margin-bottom:1.5rem;">
            <a href="{{ route('landing') }}" style="color:var(--brand);">Beranda</a>
            <span style="margin:0 0.5rem;">›</span>
            <a href="{{ route('blog.index') }}" style="color:var(--brand);">Blog</a>
            @if($post->category)
            <span style="margin:0 0.5rem;">›</span>
            <a href="{{ route('blog.category', $post->category->slug) }}" style="color:var(--brand);">{{ $post->category->name }}</a>
            @endif
            <span style="margin:0 0.5rem;">›</span>
            <span>{{ Str::limit($post->title, 40) }}</span>
        </nav>

        <!-- Category & Featured Badge -->
        <div style="display:flex;gap:0.5rem;margin-bottom:1rem;">
            @if($post->category)
            <span class="badge" style="background:{{ $post->category->color }};color:white;font-size:0.8rem;">{{ $post->category->name }}</span>
            @endif
            @if($post->featured)
            <span class="badge" style="background:var(--warning);color:white;">⭐ Unggulan</span>
            @endif
        </div>

        <!-- Title -->
        <h1 style="font-size:clamp(1.75rem,4vw,2.75rem);line-height:1.2;margin-bottom:1.25rem;">{{ $post->title }}</h1>

        <!-- Meta -->
        <div style="display:flex;align-items:center;gap:1.25rem;flex-wrap:wrap;margin-bottom:2rem;padding-bottom:1.5rem;border-bottom:1px solid var(--border-color);">
            <div style="display:flex;align-items:center;gap:0.75rem;">
                <img src="{{ $post->user->avatar_url }}" alt="{{ $post->user->name }}" style="width:44px;height:44px;border-radius:50%;object-fit:cover;border:2px solid var(--brand);">
                <div>
                    <div style="font-weight:700;font-size:0.9rem;">{{ $post->user->name }}</div>
                    <div style="font-size:0.775rem;color:var(--text-muted);">{{ $post->published_at?->format('d F Y') }}</div>
                </div>
            </div>
            <div style="display:flex;gap:1rem;font-size:0.8rem;color:var(--text-muted);">
                <span>⏱ {{ $post->reading_time }} menit baca</span>
                <span>👁 {{ number_format($post->views) }} views</span>
                <span>💬 {{ $post->approvedComments->count() }} komentar</span>
            </div>
        </div>

        <!-- Thumbnail -->
        @if($post->thumbnail)
        <div style="border-radius:var(--radius-xl);overflow:hidden;margin-bottom:2.5rem;box-shadow:var(--shadow-lg);">
            <img src="{{ $post->thumbnail_url }}" alt="{{ $post->title }}" style="width:100%;max-height:500px;object-fit:cover;">
        </div>
        @endif

        <!-- Excerpt -->
        @if($post->excerpt)
        <div style="padding:1.25rem 1.5rem;background:var(--brand-bg);border-left:4px solid var(--brand);border-radius:var(--radius-md);margin-bottom:2rem;font-size:1.05rem;color:var(--text-secondary);font-style:italic;line-height:1.7;">
            {{ $post->excerpt }}
        </div>
        @endif

        <!-- Content -->
        <div style="font-size:1.05rem;line-height:1.85;color:var(--text-primary);" class="post-content">
            {!! $post->content !!}
        </div>

        <!-- Tags -->
        @if($post->tags->count())
        <div style="margin-top:2.5rem;padding-top:1.5rem;border-top:1px solid var(--border-color);">
            <span style="font-size:0.8rem;font-weight:700;color:var(--text-muted);text-transform:uppercase;margin-right:0.75rem;">🔖 Tags:</span>
            @foreach($post->tags as $tag)
            <a href="{{ route('blog.index', ['tag' => $tag->slug]) }}"
               class="badge badge-primary"
               style="margin-right:0.5rem;margin-bottom:0.5rem;text-decoration:none;padding:0.35rem 0.875rem;">
                #{{ $tag->name }}
            </a>
            @endforeach
        </div>
        @endif

        <!-- Author Box -->
        <div style="margin-top:2.5rem;padding:1.75rem;background:rgba(var(--bg-card-rgb), 0.5);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);border-radius:var(--radius-xl);border:1px solid var(--border-color);display:flex;gap:1.25rem;align-items:flex-start;">
            <img src="{{ $post->user->avatar_url }}" alt="{{ $post->user->name }}" style="width:64px;height:64px;border-radius:50%;object-fit:cover;flex-shrink:0;">
            <div>
                <div style="font-weight:800;font-size:1rem;margin-bottom:0.25rem;">{{ $post->user->name }}</div>
                <div class="badge badge-gray" style="margin-bottom:0.75rem;">Penulis</div>
                @if($post->user->bio)
                <p style="color:var(--text-secondary);font-size:0.875rem;line-height:1.6;margin:0;">{{ $post->user->bio }}</p>
                @endif
            </div>
        </div>

        <!-- Comments -->
        <div style="margin-top:3rem;">
            <h2 style="font-family:var(--font-sans);font-size:1.25rem;font-weight:800;margin-bottom:1.5rem;">
                💬 Komentar ({{ $post->approvedComments->count() }})
            </h2>

            <!-- Comment Form -->
            @auth
            <form method="POST" action="{{ route('blog.comments.store', $post) }}" style="margin-bottom:2rem;">
                @csrf
                <div class="form-group">
                    <label class="form-label">Tulis Komentar</label>
                    <textarea name="content" class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}" rows="4" placeholder="Bagikan pemikiran Anda..." required>{{ old('content') }}</textarea>
                    @error('content')
                    <div class="form-error">✕ {{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Kirim Komentar</button>
                <p style="font-size:0.775rem;color:var(--text-muted);margin-top:0.5rem;">Komentar akan ditampilkan setelah disetujui moderator.</p>
            </form>
            @else
            <div style="padding:1.5rem;background:rgba(var(--bg-card-rgb), 0.5);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);border-radius:var(--radius-lg);border:1px solid var(--border-color);text-align:center;margin-bottom:2rem;">
                <p style="color:var(--text-secondary);margin-bottom:0.75rem;">Login untuk memberikan komentar.</p>
                <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Masuk</a>
                <a href="{{ route('register') }}" class="btn btn-secondary btn-sm">Daftar</a>
            </div>
            @endauth


            <!-- Comment List -->
            @forelse($post->approvedComments as $comment)
            <div style="display:flex;gap:1rem;margin-bottom:1.5rem;padding-bottom:1.5rem;border-bottom:1px solid var(--border-color);">
                <img src="{{ $comment->user->avatar_url }}" alt="{{ $comment->user->name }}" style="width:40px;height:40px;border-radius:50%;object-fit:cover;flex-shrink:0;">
                <div>
                    <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:0.4rem;">
                        <span style="font-weight:700;font-size:0.875rem;">{{ $comment->user->name }}</span>
                        <span style="font-size:0.75rem;color:var(--text-muted);">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                    <p style="color:var(--text-secondary);font-size:0.9rem;line-height:1.6;margin:0;">{{ $comment->content }}</p>
                </div>
            </div>
            @empty
            <div style="text-align:center;padding:2rem;color:var(--text-muted);">
                <span style="font-size:2.5rem;">💭</span>
                <p style="margin-top:0.5rem;">Belum ada komentar. Jadilah yang pertama!</p>
            </div>
            @endforelse
        </div>
    </div>
</article>

<!-- Related Posts -->
@if($relatedPosts->count())
<section style="padding:3rem 0;background:var(--bg-secondary);border-top:1px solid var(--border-color);">
    <div class="container">
        <h2 style="font-family:var(--font-sans);font-size:1.25rem;font-weight:800;margin-bottom:1.5rem;">📚 Artikel Terkait</h2>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:1.5rem;">
            @foreach($relatedPosts as $related)
            <div class="post-card">
                <div class="post-card-image" style="background:var(--gradient-card);display:flex;align-items:center;justify-content:center;">
                    @if($related->thumbnail)
                    <img src="{{ $related->thumbnail_url }}" alt="{{ $related->title }}">
                    @else
                    <span style="font-size:2.5rem;">📝</span>
                    @endif
                </div>
                <div class="post-card-body">
                    @if($related->category)
                    <span class="post-card-category" style="background:{{ $related->category->color }};">{{ $related->category->name }}</span>
                    @endif
                    <h3 class="post-card-title">
                        <a href="{{ route('blog.show', $related->slug) }}" style="color:inherit;text-decoration:none;">{{ $related->title }}</a>
                    </h3>
                    <div class="post-card-meta">
                        <span>{{ $related->published_at?->diffForHumans() }}</span>
                        <span>⏱ {{ $related->reading_time }} mnt</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@push('styles')
<style>
.post-content h2, .post-content h3, .post-content h4 {
    font-family: var(--font-serif);
    margin: 2rem 0 1rem;
    color: var(--text-primary);
}
.post-content h2 { font-size: 1.6rem; }
.post-content h3 { font-size: 1.3rem; }
.post-content p { margin-bottom: 1.25rem; }
.post-content ul, .post-content ol { margin: 1rem 0 1.25rem 1.5rem; }
.post-content li { margin-bottom: 0.5rem; }
.post-content blockquote {
    border-left: 4px solid var(--brand);
    padding: 1rem 1.5rem;
    margin: 1.5rem 0;
    background: var(--brand-bg);
    border-radius: 0 var(--radius-md) var(--radius-md) 0;
    color: var(--text-secondary);
    font-style: italic;
}
.post-content img { border-radius: var(--radius-lg); box-shadow: var(--shadow-md); margin: 1.5rem 0; }
.post-content a { color: var(--brand); text-decoration: underline; }
.post-content code { background: var(--bg-tertiary); padding: 0.15em 0.4em; border-radius: 4px; font-size: 0.875em; }
.post-content pre { margin: 1.5rem 0; }
</style>
@endpush
@endsection
