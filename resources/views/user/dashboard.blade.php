@extends('layouts.app')
@section('title', 'Dashboard Saya')

@section('content')
<div style="padding:3rem 0;">
    <div class="container">
        <!-- Welcome Banner -->
        <div class="animate-on-scroll" style="background:var(--gradient-brand);border-radius:var(--radius-xl);padding:2.5rem;color:white;margin-bottom:2rem;position:relative;overflow:hidden;box-shadow:var(--shadow-brand);">
            <div style="position:absolute;right:-20px;top:-20px;width:150px;height:150px;background:rgba(255,255,255,0.1);border-radius:50%;"></div>
            <div style="position:absolute;right:60px;bottom:-40px;width:100px;height:100px;background:rgba(255,255,255,0.08);border-radius:50%;"></div>
            <div style="position:relative;z-index:1;">
                <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1rem;">
                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" style="width:60px;height:60px;border-radius:50%;border:3px solid rgba(255,255,255,0.4);object-fit:cover;">
                    <div>
                        <h1 style="color:white;font-size:1.5rem;margin:0;">Halo, {{ $user->name }}! 👋</h1>
                        <p style="color:rgba(255,255,255,0.8);margin:0;font-size:0.875rem;">Selamat datang di dashboard Anda</p>
                    </div>
                </div>
                <div style="display:flex;gap:0.75rem;flex-wrap:wrap;">
                    <a href="{{ route('blog.index') }}" class="btn" style="background:rgba(255,255,255,0.15);color:white;border:1px solid rgba(255,255,255,0.3);">📚 Jelajahi Blog</a>
                    <a href="{{ route('user.profile') }}" class="btn" style="background:white;color:var(--brand);">👤 Edit Profil</a>
                </div>
            </div>
        </div>

        <!-- Stats Row -->
        <div class="stat-cards animate-on-scroll delay-1" style="margin-bottom:2rem;">
            <div class="stat-card">
                <div class="icon" style="background:rgba(99,102,241,0.12);color:var(--brand);">💬</div>
                <div class="value">{{ $stats['comments'] }}</div>
                <div class="name">Komentar Dikirim</div>
            </div>
            <div class="stat-card">
                <div class="icon" style="background:rgba(16,185,129,0.12);color:var(--success);">📖</div>
                <div class="value">{{ \App\Models\Post::published()->count() }}</div>
                <div class="name">Artikel Tersedia</div>
            </div>
            <div class="stat-card">
                <div class="icon" style="background:rgba(245,158,11,0.12);color:var(--warning);">🏷️</div>
                <div class="value">{{ \App\Models\Category::count() }}</div>
                <div class="name">Kategori</div>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 320px;gap:2rem;">
            <!-- Recent Posts -->
            <div>
                <h2 class="animate-on-scroll" style="font-family:var(--font-sans);font-size:1.15rem;font-weight:800;margin-bottom:1.25rem;">📰 Artikel Terbaru</h2>
                <div style="display:flex;flex-direction:column;gap:1rem;">
                    @foreach($recentPosts as $i => $post)
                    <a href="{{ route('blog.show', $post->slug) }}" style="text-decoration:none;">
                        <div class="card animate-on-scroll delay-{{ $i }}" style="flex-direction:row;padding:1.25rem;gap:1rem;display:flex;align-items:center;cursor:pointer;">
                            @if($post->category)
                            <span class="badge" style="background:{{ $post->category->color }};color:white;flex-shrink:0;font-size:0.7rem;">{{ $post->category->name }}</span>
                            @endif
                            <div style="flex:1;min-width:0;">
                                <div style="font-weight:700;font-size:0.9rem;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $post->title }}</div>
                                <div style="font-size:0.775rem;color:var(--text-muted);margin-top:0.2rem;">{{ $post->published_at?->diffForHumans() }} · ⏱ {{ $post->reading_time }} mnt</div>
                            </div>
                            <span style="color:var(--brand);font-size:1.2rem;flex-shrink:0;">→</span>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h2 class="animate-on-scroll" style="font-family:var(--font-sans);font-size:1.15rem;font-weight:800;margin-bottom:1.25rem;">⚡ Akses Cepat</h2>
                <div style="display:flex;flex-direction:column;gap:0.75rem;">
                    <a href="{{ route('blog.index') }}" class="card animate-on-scroll delay-1" style="padding:1.25rem;display:flex;align-items:center;gap:0.875rem;text-decoration:none;cursor:pointer;">
                        <span style="font-size:1.5rem;">📚</span>
                        <div>
                            <div style="font-weight:700;color:var(--text-primary);font-size:0.9rem;">Jelajahi Blog</div>
                            <div style="font-size:0.775rem;color:var(--text-muted);">Temukan artikel menarik</div>
                        </div>
                    </a>
                    <a href="{{ route('user.profile') }}" class="card animate-on-scroll delay-2" style="padding:1.25rem;display:flex;align-items:center;gap:0.875rem;text-decoration:none;cursor:pointer;">
                        <span style="font-size:1.5rem;">👤</span>
                        <div>
                            <div style="font-weight:700;color:var(--text-primary);font-size:0.9rem;">Edit Profil</div>
                            <div style="font-size:0.775rem;color:var(--text-muted);">Perbarui informasi akun</div>
                        </div>
                    </a>
                </div>

                <!-- Profile Card -->
                <div class="card animate-on-scroll delay-3" style="margin-top:1.5rem;">
                    <div class="card-body" style="text-align:center;">
                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" style="width:72px;height:72px;border-radius:50%;margin-bottom:0.75rem;border:3px solid var(--brand);object-fit:cover;">
                        <div style="font-weight:800;font-size:1rem;">{{ $user->name }}</div>
                        <div style="font-size:0.775rem;color:var(--text-muted);margin-bottom:0.75rem;">{{ $user->email }}</div>
                        @if($user->bio)
                        <p style="font-size:0.8rem;color:var(--text-secondary);line-height:1.5;margin-bottom:0.75rem;">{{ $user->bio }}</p>
                        @endif
                        <span class="badge badge-gray">{{ ucfirst($user->role) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
