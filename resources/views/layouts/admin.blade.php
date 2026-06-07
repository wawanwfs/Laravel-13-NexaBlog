<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Admin NexaBlog</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@400;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
    <script>
        (function() {
            const saved = localStorage.getItem('nexablog-theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            document.documentElement.setAttribute('data-theme', saved || (prefersDark ? 'dark' : 'light'));
        })();
    </script>
</head>
<body>

<!-- ── Navbar ─────────────────────────────────────────── -->
<nav class="navbar">
    <div class="navbar-inner">
        <div style="display:flex;align-items:center;gap:1rem;">
            <!-- Sidebar Toggle (mobile) -->
            <button id="sidebar-toggle" class="btn btn-secondary btn-icon" style="display:none;" aria-label="Toggle sidebar">☰</button>
            <a href="{{ route('landing') }}" class="navbar-brand" style="display:inline-flex;align-items:center;gap:0.6rem;">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height:30px;width:30px;object-fit:contain;border-radius:6px;box-shadow:0 0 10px rgba(99,102,241,0.25);">
                <span>NexaBlog</span>
            </a>

            <span class="badge badge-danger" style="background:var(--gradient-brand);color:white;font-size:0.7rem;">Admin</span>
        </div>

        <div style="display:flex;align-items:center;gap:0.5rem;">
            <a href="{{ route('landing') }}" class="btn btn-secondary btn-sm">🏠 Beranda</a>
            <button class="theme-toggle" id="theme-toggle" title="Toggle dark mode">
                <span id="theme-icon">🌙</span>
            </button>

            <!-- User Menu -->
            <div class="user-menu">
                <div class="user-menu-trigger" id="user-menu-trigger">
                    <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}">
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    <span style="font-size:0.7rem;color:var(--text-muted);">▼</span>
                </div>
                <div class="user-dropdown" id="user-dropdown">
                    <div class="user-dropdown-header">
                        <div class="name">{{ Auth::user()->name }}</div>
                        <div class="email">{{ Auth::user()->email }}</div>
                        <div class="mt-1">
                            @if(Auth::user()->isSuperAdmin())
                                <span class="badge" style="background:rgba(239,68,68,0.15);color:var(--danger);">Superadmin</span>
                            @else
                                <span class="badge badge-primary">Admin</span>
                            @endif
                        </div>
                    </div>
                    <a href="{{ route('user.profile') }}" class="dropdown-item">👤 Edit Profil</a>
                    <a href="{{ route('blog.index') }}" class="dropdown-item">📰 Lihat Blog</a>
                    <div class="divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item danger">🚪 Keluar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Toast Container -->
<div class="toast-container" id="toast-container"></div>
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

<!-- ── Admin Layout ────────────────────────────────────── -->
<div class="admin-layout">
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <!-- Dashboard -->
        <div class="sidebar-section">
            <div class="sidebar-label">Dashboard</div>
            <ul class="sidebar-nav">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <span class="nav-icon">📊</span> Overview
                    </a>
                </li>
            </ul>
        </div>

        <!-- Content -->
        <div class="sidebar-section">
            <div class="sidebar-label">Konten</div>
            <ul class="sidebar-nav">
                <li>
                    <a href="{{ route('admin.posts.index') }}" class="{{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
                        <span class="nav-icon">📝</span> Posts
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <span class="nav-icon">🏷️</span> Kategori
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.tags.index') }}" class="{{ request()->routeIs('admin.tags.*') ? 'active' : '' }}">
                        <span class="nav-icon">🔖</span> Tags
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.comments.index') }}" class="{{ request()->routeIs('admin.comments.*') ? 'active' : '' }}">
                        <span class="nav-icon">💬</span> Komentar
                    </a>
                </li>
            </ul>
        </div>

        <!-- Superadmin Only -->
        @if(Auth::user()->isSuperAdmin())
        <div class="sidebar-section">
            <div class="sidebar-label">Superadmin</div>
            <ul class="sidebar-nav">
                <li>
                    <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <span class="nav-icon">👥</span> User Management
                    </a>
                </li>
            </ul>
        </div>
        @endif

        <!-- Profil -->
        <div class="sidebar-section">
            <div class="sidebar-label">Akun</div>
            <ul class="sidebar-nav">
                <li>
                    <a href="{{ route('user.profile') }}" class="{{ request()->routeIs('user.profile') ? 'active' : '' }}">
                        <span class="nav-icon">👤</span> Profil Saya
                    </a>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                        @csrf
                        <button type="submit" style="background:none;border:none;width:100%;text-align:left;cursor:pointer;" class="dropdown-item danger" onclick="return confirm('Yakin ingin keluar?')">
                            <span class="nav-icon">🚪</span> Keluar
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="admin-content">
        <!-- Page Header -->
        @hasSection('page-header')
        <div style="margin-bottom:1.75rem;">
            @yield('page-header')
        </div>
        @endif

        @yield('content')
    </main>
</div>

<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')

<!-- Mobile: Show sidebar toggle -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggle = document.getElementById('sidebar-toggle');
        if (toggle) toggle.style.display = window.innerWidth <= 768 ? 'flex' : 'none';
        window.addEventListener('resize', function() {
            if (toggle) toggle.style.display = window.innerWidth <= 768 ? 'flex' : 'none';
        });
    });
</script>
</body>
</html>
