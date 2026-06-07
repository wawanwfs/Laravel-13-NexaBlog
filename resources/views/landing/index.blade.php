@extends('layouts.app')
@section('title', 'Beranda')
@section('meta_description', 'NexaBlog - Platform blog modern untuk berbagi ide, cerita, dan pengetahuan berkualitas.')

@section('content')

<!-- ── Hero Section (3D) ────────────────────────────────── -->
<section class="hero">
    <canvas id="hero-canvas"></canvas>

    <div class="hero-content">
        <div class="hero-badge animate-on-scroll">
            ✨ Platform Blog Modern #1
        </div>

        <h1>
            Temukan <span class="gradient-text">Ide & Inspirasi</span><br>
            Yang Mengubah Dunia
        </h1>

        <p class="hero-subtitle">
            NexaBlog adalah platform blog terbaik untuk berbagi pengetahuan,<br>
            cerita, dan inovasi bersama ribuan pembaca setia.
        </p>

        <div class="hero-actions">
            <a href="{{ route('blog.index') }}" class="btn btn-primary btn-lg">
                📚 Jelajahi Blog
            </a>
            @guest
            <a href="{{ route('register') }}" class="btn btn-outline btn-lg" style="border-color:white;color:white;background:rgba(255,255,255,0.1);backdrop-filter:blur(8px);">
                🚀 Mulai Menulis
            </a>
            @else
            <a href="{{ route('user.dashboard') }}" class="btn btn-outline btn-lg" style="border-color:white;color:white;background:rgba(255,255,255,0.1);backdrop-filter:blur(8px);">
                📊 Dashboard Saya
            </a>
            @endguest
        </div>

        <div class="hero-stats">
            <div class="hero-stat">
                <div class="number">{{ number_format($stats['posts']) }}+</div>
                <div class="label">Artikel</div>
            </div>
            <div class="hero-stat">
                <div class="number">{{ number_format($stats['authors']) }}+</div>
                <div class="label">Penulis</div>
            </div>
            <div class="hero-stat">
                <div class="number">{{ number_format($stats['readers']) }}+</div>
                <div class="label">Pembaca</div>
            </div>
            <div class="hero-stat">
                <div class="number">{{ $stats['categories'] }}</div>
                <div class="label">Kategori</div>
            </div>
        </div>
    </div>

    <div class="scroll-indicator">↓</div>
</section>

<!-- ── Featured Posts ─────────────────────────────────────── -->
@if($featuredPosts->count())
<section class="section section-glass">
    <div class="container">

        <div class="section-header animate-on-scroll">
            <span class="eyebrow">⭐ Unggulan</span>
            <h2>Artikel Pilihan Editor</h2>
            <p>Artikel terbaik yang dipilih langsung oleh tim editorial NexaBlog.</p>
        </div>

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;" class="animate-on-scroll delay-1">
            @foreach($featuredPosts as $i => $post)
            @if($i === 0)
            <!-- Main featured -->
            <div class="post-card" style="grid-row: span 2;">
                @if($post->thumbnail)
                <div class="post-card-image" style="aspect-ratio:16/10;">
                    <img src="{{ $post->thumbnail_url }}" alt="{{ $post->title }}">
                </div>
                @else
                <div class="post-card-image" style="aspect-ratio:16/10;background:var(--gradient-brand);display:flex;align-items:center;justify-content:center;">
                    <span style="font-size:4rem;">📰</span>
                </div>
                @endif
                <div class="post-card-body">
                    @if($post->category)
                    <span class="post-card-category" style="background:{{ $post->category->color }};">{{ $post->category->name }}</span>
                    @endif
                    <h2 class="post-card-title" style="-webkit-line-clamp:3;font-size:1.5rem;">
                        <a href="{{ route('blog.show', $post->slug) }}" style="color:inherit;text-decoration:none;">{{ $post->title }}</a>
                    </h2>
                    <p class="post-card-excerpt" style="-webkit-line-clamp:4;">{{ $post->excerpt }}</p>
                    <div class="post-card-meta">
                        <div class="post-card-author">
                            <img src="{{ $post->user->avatar_url }}" alt="{{ $post->user->name }}">
                            <span>{{ $post->user->name }}</span>
                        </div>
                        <span>{{ $post->published_at?->diffForHumans() }}</span>
                        <span>👁 {{ number_format($post->views) }}</span>
                        <span>⏱ {{ $post->reading_time }} mnt</span>
                    </div>
                </div>
            </div>
            @else
            <!-- Side featured -->
            <div class="post-card" style="flex-direction:row;">
                <div class="post-card-body">
                    @if($post->category)
                    <span class="post-card-category" style="background:{{ $post->category->color }};">{{ $post->category->name }}</span>
                    @endif
                    <h3 class="post-card-title">
                        <a href="{{ route('blog.show', $post->slug) }}" style="color:inherit;text-decoration:none;">{{ $post->title }}</a>
                    </h3>
                    <div class="post-card-meta">
                        <span>{{ $post->published_at?->diffForHumans() }}</span>
                        <span>👁 {{ number_format($post->views) }}</span>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- ── Features Section ───────────────────────────────────── -->
<section class="section section-glass-alt">
    <div class="container">
        <div class="section-header animate-on-scroll">
            <span class="eyebrow">🎯 Kenapa NexaBlog?</span>
            <h2>Platform Yang Dirancang Untuk Anda</h2>
            <p>Fitur lengkap untuk membaca, menulis, dan berinteraksi dengan komunitas penulis terbaik.</p>
        </div>

        <div class="features-grid" data-stagger="0.1">
            <div class="feature-card animate-on-scroll">
                <div class="feature-icon">📝</div>
                <h3>Konten Berkualitas</h3>
                <p>Semua konten dimoderasi tim editor berpengalaman untuk memastikan kualitas dan akurasi informasi.</p>
            </div>
            <div class="feature-card animate-on-scroll delay-1">
                <div class="feature-icon">🌙</div>
                <h3>Mode Gelap & Terang</h3>
                <p>Tampilan yang nyaman di mata dengan dukungan dark mode dan light mode yang bisa diatur sesuai preferensi.</p>
            </div>
            <div class="feature-card animate-on-scroll delay-2">
                <div class="feature-icon">🔍</div>
                <h3>Pencarian Cerdas</h3>
                <p>Temukan artikel yang Anda cari dengan cepat menggunakan fitur pencarian dan filter kategori yang powerful.</p>
            </div>
            <div class="feature-card animate-on-scroll delay-3">
                <div class="feature-icon">💬</div>
                <h3>Komunitas Aktif</h3>
                <p>Berinteraksi dengan penulis dan pembaca lain melalui sistem komentar yang termoderasi dengan baik.</p>
            </div>
            <div class="feature-card animate-on-scroll delay-4">
                <div class="feature-icon">🏷️</div>
                <h3>Kategori Lengkap</h3>
                <p>Artikel diorganisir dalam kategori yang terstruktur sehingga mudah ditemukan sesuai minat Anda.</p>
            </div>
            <div class="feature-card animate-on-scroll delay-5">
                <div class="feature-icon">📱</div>
                <h3>Responsif di Semua Perangkat</h3>
                <p>Tampilan optimal di smartphone, tablet, maupun desktop dengan desain yang fully responsive.</p>
            </div>
        </div>
    </div>
</section>

<!-- ── Latest Posts ───────────────────────────────────────── -->
<section class="section section-glass">
    <div class="container">
        <div class="section-header animate-on-scroll" style="display:flex;align-items:center;justify-content:space-between;text-align:left;margin-bottom:2rem;">
            <div>
                <span class="eyebrow">📚 Terbaru</span>
                <h2 style="margin-bottom:0;">Artikel Terbaru</h2>
            </div>
            <a href="{{ route('blog.index') }}" class="btn btn-outline">Lihat Semua →</a>
        </div>

        @if($latestPosts->count())
        <div class="posts-grid">
            @foreach($latestPosts as $i => $post)
            <div class="post-card animate-on-scroll delay-{{ min($i, 5) }}">
                @if($post->thumbnail)
                <div class="post-card-image">
                    <img src="{{ $post->thumbnail_url }}" alt="{{ $post->title }}">
                </div>
                @else
                <div class="post-card-image" style="background:var(--gradient-card);display:flex;align-items:center;justify-content:center;">
                    <span style="font-size:3rem;">{{ ['📝','💡','🚀','🎯','💻','🌟'][$i % 6] }}</span>
                </div>
                @endif
                <div class="post-card-body">
                    @if($post->category)
                    <span class="post-card-category" style="background:{{ $post->category->color }};">{{ $post->category->name }}</span>
                    @endif
                    <h3 class="post-card-title">
                        <a href="{{ route('blog.show', $post->slug) }}" style="color:inherit;text-decoration:none;">{{ $post->title }}</a>
                    </h3>
                    <p class="post-card-excerpt">{{ $post->excerpt }}</p>
                    <div class="post-card-meta">
                        <div class="post-card-author">
                            <img src="{{ $post->user->avatar_url }}" alt="{{ $post->user->name }}">
                            <span>{{ $post->user->name }}</span>
                        </div>
                        <span>{{ $post->published_at?->diffForHumans() }}</span>
                        <span>⏱ {{ $post->reading_time }} mnt</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div style="text-align:center;padding:4rem;color:var(--text-muted);">
            <span style="font-size:3rem;">📭</span>
            <p style="margin-top:1rem;">Belum ada artikel yang dipublikasikan.</p>
        </div>
        @endif
    </div>
</section>

<!-- ── Stats Counter ──────────────────────────────────────── -->
<section class="stats-section">
    <div class="container" style="position:relative;z-index:1;">
        <div class="section-header animate-on-scroll" style="margin-bottom:3rem;">
            <span class="eyebrow">📊 NexaBlog dalam Angka</span>
            <h2>Platform Terpercaya Ribuan Pembaca</h2>
        </div>


        <div class="stats-grid">
            <div class="stat-item animate-on-scroll">
                <div class="stat-number">
                    <span data-count="{{ $stats['posts'] }}" data-suffix="+">0</span>
                </div>
                <div class="stat-label">Artikel Terbit</div>
            </div>
            <div class="stat-item animate-on-scroll delay-1">
                <div class="stat-number">
                    <span data-count="{{ $stats['readers'] }}" data-suffix="+">0</span>
                </div>
                <div class="stat-label">Pembaca Aktif</div>
            </div>
            <div class="stat-item animate-on-scroll delay-2">
                <div class="stat-number">
                    <span data-count="{{ $stats['authors'] }}" data-suffix="+">0</span>
                </div>
                <div class="stat-label">Penulis Kreatif</div>
            </div>
            <div class="stat-item animate-on-scroll delay-3">
                <div class="stat-number">
                    <span data-count="{{ $stats['categories'] }}">0</span>
                </div>
                <div class="stat-label">Kategori Topik</div>
            </div>
        </div>
    </div>
</section>

<!-- ── Categories ─────────────────────────────────────────── -->
<section class="section section-glass-alt">
    <div class="container">
        <div class="section-header animate-on-scroll">
            <span class="eyebrow">🏷️ Kategori</span>
            <h2>Jelajahi Berdasarkan Topik</h2>
            <p>Temukan konten yang sesuai dengan minat dan kebutuhan Anda.</p>
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:1rem;">
            @foreach($categories as $i => $category)
            <a href="{{ route('blog.category', $category->slug) }}"
               class="animate-on-scroll delay-{{ $i }}"
               style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:1.5rem;border-radius:var(--radius-lg);background:var(--bg-card);border:2px solid var(--border-color);transition:all 0.25s;text-decoration:none;gap:0.75rem;"
               onmouseover="this.style.borderColor='{{ $category->color }}';this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 30px rgba(0,0,0,0.1)'"
               onmouseout="this.style.borderColor='var(--border-color)';this.style.transform='';this.style.boxShadow=''">
                <span style="width:48px;height:48px;border-radius:50%;background:{{ $category->color }}20;display:flex;align-items:center;justify-content:center;font-size:1.5rem;">
                    {{ ['🖥️','🎨','💼','🌿','📖','📰'][($i) % 6] }}
                </span>
                <div style="text-align:center;">
                    <div style="font-weight:700;color:var(--text-primary);font-size:0.9rem;">{{ $category->name }}</div>
                    <div style="font-size:0.75rem;color:var(--text-muted);">{{ $category->published_posts_count }} artikel</div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- ── CTA Section ─────────────────────────────────────────── -->
@guest
<section class="section section-glass">
    <div class="container">
        <div class="animate-on-scroll cta-card">
            <h2 style="color:white;font-size:2rem;margin-bottom:1rem;position:relative;">Bergabunglah Sekarang!</h2>
            <p style="color:rgba(255,255,255,0.9);margin-bottom:2rem;position:relative;">Daftarkan diri dan mulai menikmati ribuan artikel berkualitas dari penulis terbaik kami.</p>
            <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;position:relative;">
                <a href="{{ route('register') }}" class="btn" style="background:white;color:var(--brand);font-weight:800;">🚀 Daftar Gratis</a>
                <a href="{{ route('login') }}" class="btn" style="background:rgba(255,255,255,0.15);color:white;border:2px solid rgba(255,255,255,0.4);">Masuk</a>
            </div>
        </div>
    </div>
</section>
@endguest


@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/studio-freight/lenis@1.0.19/bundled/lenis.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Initialize Lenis smooth scroll
        const lenis = new Lenis({
            lerp: 0.1,
            wheelMultiplier: 1.15,
            smoothWheel: true,
            smoothTouch: false
        });

        function raf(time) {
            lenis.raf(time);
            requestAnimationFrame(raf);
        }
        requestAnimationFrame(raf);

        // Link Lenis to GSAP ScrollTrigger
        lenis.on('scroll', () => {
            ScrollTrigger.update();
        });

        gsap.ticker.add((time) => {
            lenis.raf(time * 1000);
        });
        gsap.ticker.lagSmoothing(0);
    });
</script>
<script src="{{ asset('js/three-scene.js') }}"></script>
@endpush


