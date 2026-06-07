<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Masuk') — NexaBlog</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@400;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script>
        (function() {
            const saved = localStorage.getItem('nexablog-theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            document.documentElement.setAttribute('data-theme', saved || (prefersDark ? 'dark' : 'light'));
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

<!-- Theme Toggle (floating) -->

<button class="theme-toggle" id="theme-toggle" style="position:fixed;top:1.25rem;right:1.25rem;z-index:100;" title="Toggle dark mode">
    <span id="theme-icon">🌙</span>
</button>

<!-- Back to home -->
<a href="{{ route('landing') }}" style="position:fixed;top:1.25rem;left:1.25rem;z-index:100;display:flex;align-items:center;gap:0.4rem;font-size:0.85rem;font-weight:600;color:var(--text-secondary);text-decoration:none;padding:0.5rem 0.875rem;border-radius:var(--radius-md);background:var(--bg-card);border:1px solid var(--border-color);transition:all 0.2s;" onmouseover="this.style.color='var(--brand)';this.style.borderColor='var(--brand)'" onmouseout="this.style.color='var(--text-secondary)';this.style.borderColor='var(--border-color)'">
    ← Kembali ke Beranda
</a>

<!-- Auth Page -->
<div class="auth-page">
    @yield('content')
</div>

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
