<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name')) — NexaBlog</title>
    <meta name="description" content="@yield('meta_description', 'NexaBlog - Platform blog modern dengan konten berkualitas tinggi.')">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@400;700;800&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @stack('styles')

    <!-- Dark mode init (before body render to avoid flash) -->
    <script>
        (function() {
            const saved = localStorage.getItem('nexablog-theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const theme = saved || (prefersDark ? 'dark' : 'light');
            document.documentElement.setAttribute('data-theme', theme);
        })();
    </script>
</head>
<body>

<!-- ── Noise Overlay ── -->
<div class="noise-overlay"></div>

<!-- ── Custom Cursor ── -->
<div class="custom-cursor-trail" id="custom-cursor-trail"></div>
<div class="custom-cursor" id="custom-cursor"></div>

<!-- ── Ambient Glow Blobs ── -->
<div class="bg-glow bg-glow-1"></div>
<div class="bg-glow bg-glow-2"></div>


<!-- ── Navbar ─────────────────────────────────────────── -->
<nav class="navbar">

    <div class="scroll-progress-bar" id="scroll-progress-bar"></div>
    <div class="navbar-inner">
        <!-- Brand -->
        <a href="{{ route('landing') }}" class="navbar-brand" style="display:inline-flex;align-items:center;gap:0.6rem;">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height:30px;width:30px;object-fit:contain;border-radius:6px;box-shadow:0 0 10px rgba(99,102,241,0.25);">
            <span>NexaBlog</span>
        </a>



        <!-- Nav Links -->
        <ul class="navbar-nav" id="navbar-nav">
            <li><a href="{{ route('landing') }}">Beranda</a></li>
            <li><a href="{{ route('blog.index') }}">Blog</a></li>
            @foreach(\App\Models\Category::take(4)->get() as $cat)
            <li><a href="{{ route('blog.category', $cat->slug) }}">{{ $cat->name }}</a></li>
            @endforeach
        </ul>

        <!-- Actions -->
        <div class="navbar-actions">
            <!-- Dark Mode Toggle -->
            <button class="theme-toggle" id="theme-toggle" title="Toggle dark mode">
                <span id="theme-icon">🌙</span>
            </button>

            @guest
                <a href="{{ route('login') }}" class="btn btn-secondary btn-sm">Masuk</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Daftar</a>
            @else
                <!-- User Menu -->
                <div class="user-menu">
                    <div class="user-menu-trigger" id="user-menu-trigger">
                        <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}">
                        <span class="user-name">{{ Auth::user()->name }}</span>
                        <span style="font-size:0.7rem; color:var(--text-muted);">▼</span>
                    </div>
                    <div class="user-dropdown" id="user-dropdown">
                        <div class="user-dropdown-header">
                            <div class="name">{{ Auth::user()->name }}</div>
                            <div class="email">{{ Auth::user()->email }}</div>
                            <div class="mt-1">
                                @if(Auth::user()->isSuperAdmin())
                                    <span class="badge badge-danger" style="background:rgba(239,68,68,0.15);color:var(--danger);">Superadmin</span>
                                @elseif(Auth::user()->isAdmin())
                                    <span class="badge badge-primary">Admin</span>
                                @else
                                    <span class="badge badge-gray">User</span>
                                @endif
                            </div>
                        </div>
                        <a href="{{ route('user.dashboard') }}" class="dropdown-item">📊 Dashboard</a>
                        <a href="{{ route('user.profile') }}" class="dropdown-item">👤 Edit Profil</a>
                        @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="dropdown-item">⚙️ Admin Panel</a>
                        @endif
                        <div class="divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item danger">🚪 Keluar</button>
                        </form>
                    </div>
                </div>
            @endguest

            <!-- Mobile Hamburger -->
            <button class="hamburger" id="mobile-menu-toggle" aria-label="Menu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
</nav>

<!-- ── Toast Container ─────────────────────────────────── -->
<div class="toast-container" id="toast-container"></div>

<!-- ── Flash Toasts (server-side) ─────────────────────── -->
<script>
    window.__toasts = [
        @if(session('toast_success'))
            { type: 'success', message: '{{ addslashes(session('toast_success')) }}' },
        @endif
        @if(session('toast_error'))
            { type: 'error', message: '{{ addslashes(session('toast_error')) }}' },
        @endif
        @if(session('toast_warning'))
            { type: 'warning', message: '{{ addslashes(session('toast_warning')) }}' },
        @endif
        @if(session('toast_info'))
            { type: 'info', message: '{{ addslashes(session('toast_info')) }}' },
        @endif
    ];
</script>

<!-- ── Main Content ────────────────────────────────────── -->
<main style="padding-top: 68px;">
    @yield('content')
</main>

<!-- ── Footer ──────────────────────────────────────────── -->
<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <a href="{{ route('landing') }}" class="navbar-brand">NexaBlog</a>
                <p>Platform blog modern untuk berbagi ide, cerita, dan pengetahuan. Bergabunglah dengan komunitas penulis kami.</p>
            </div>
            <div class="footer-col">
                <h4>Navigasi</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('landing') }}">Beranda</a></li>
                    <li><a href="{{ route('blog.index') }}">Blog</a></li>
                    @guest
                    <li><a href="{{ route('login') }}">Masuk</a></li>
                    <li><a href="{{ route('register') }}">Daftar</a></li>
                    @endguest
                </ul>
            </div>
            <div class="footer-col">
                <h4>Kategori</h4>
                <ul class="footer-links">
                    @foreach(\App\Models\Category::take(5)->get() as $cat)
                    <li><a href="{{ route('blog.category', $cat->slug) }}">{{ $cat->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="footer-col">
                <h4>Tentang</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('about') }}">Tentang Kami</a></li>
                    <li><a href="{{ route('privacy') }}">Kebijakan Privasi</a></li>
                    <li><a href="{{ route('terms') }}">Syarat & Ketentuan</a></li>
                    <li><a href="{{ route('contact') }}">Kontak</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <span>© {{ date('Y') }} NexaBlog. Semua hak dilindungi.</span>
            <span>Dibuat dengan ❤️ menggunakan Laravel {{ app()->version() }}</span>
        </div>
    </div>
</footer>

<!-- Scroll to top -->
<button id="scroll-top" style="position:fixed;bottom:2rem;right:1.5rem;width:44px;height:44px;border-radius:50%;background:var(--gradient-brand);color:white;border:none;cursor:pointer;font-size:1.2rem;z-index:500;opacity:0;pointer-events:none;transition:opacity 0.3s;box-shadow:var(--shadow-brand);" title="Kembali ke atas">↑</button>

<!-- JS -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/scroll-animations.js') }}"></script>
@stack('scripts')
</body>
</html>
