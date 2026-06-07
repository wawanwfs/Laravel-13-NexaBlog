<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 — Halaman Tidak Ditemukan | NexaBlog</title>
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
    <style>
        .error-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
            padding: 2rem;
            background: var(--bg-primary);
            position: relative;
            overflow: hidden;
        }

        .error-page::before {
            content: '';
            position: absolute;
            top: -40%;
            left: -20%;
            width: 70%;
            height: 80%;
            background: var(--gradient-brand);
            opacity: 0.05;
            border-radius: 50%;
            filter: blur(100px);
            animation: float1 8s ease-in-out infinite alternate;
        }

        .error-page::after {
            content: '';
            position: absolute;
            bottom: -40%;
            right: -20%;
            width: 70%;
            height: 80%;
            background: var(--gradient-brand);
            opacity: 0.05;
            border-radius: 50%;
            filter: blur(100px);
            animation: float2 10s ease-in-out infinite alternate;
        }

        @keyframes float1 { from { transform: scale(1) rotate(0deg); } to { transform: scale(1.2) rotate(20deg); } }
        @keyframes float2 { from { transform: scale(1) rotate(0deg); } to { transform: scale(1.15) rotate(-15deg); } }

        .error-code {
            font-family: var(--font-serif);
            font-size: clamp(6rem, 20vw, 12rem);
            font-weight: 900;
            line-height: 1;
            background: var(--gradient-brand);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
            z-index: 1;
            animation: fadeInUp 0.6s ease both;
            letter-spacing: -0.03em;
        }

        .error-emoji {
            font-size: clamp(3rem, 8vw, 5rem);
            margin-bottom: 0.5rem;
            animation: bounce 2s infinite;
            position: relative;
            z-index: 1;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
        }

        .error-title {
            font-size: clamp(1.5rem, 4vw, 2rem);
            font-weight: 800;
            color: var(--text-primary);
            margin: 0.75rem 0 1rem;
            position: relative;
            z-index: 1;
            animation: fadeInUp 0.6s 0.1s ease both;
        }

        .error-subtitle {
            font-size: 1.05rem;
            color: var(--text-secondary);
            max-width: 480px;
            line-height: 1.7;
            margin-bottom: 2rem;
            position: relative;
            z-index: 1;
            animation: fadeInUp 0.6s 0.2s ease both;
        }

        .error-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: center;
            position: relative;
            z-index: 1;
            animation: fadeInUp 0.6s 0.3s ease both;
        }

        .error-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-xl);
            padding: 2.5rem;
            max-width: 520px;
            width: 100%;
            position: relative;
            z-index: 1;
            box-shadow: var(--shadow-xl);
            animation: fadeInUp 0.6s ease both;
        }

        .suggestions {
            margin-top: 2.5rem;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: center;
            position: relative;
            z-index: 1;
            animation: fadeInUp 0.6s 0.4s ease both;
        }

        .suggestion-link {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-full);
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .suggestion-link:hover {
            background: var(--brand-bg);
            border-color: var(--brand);
            color: var(--brand);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <!-- Navbar minimal -->
    <nav class="navbar">
        <div class="navbar-inner">
            <a href="{{ route('landing') }}" class="navbar-brand">NexaBlog</a>
            <div class="navbar-actions">
                <button class="theme-toggle" id="theme-toggle" title="Toggle dark mode">
                    <span id="theme-icon">🌙</span>
                </button>
            </div>
        </div>
    </nav>

    <div class="error-page" style="padding-top: 68px;">
        <div class="error-emoji">🔍</div>
        <div class="error-code">404</div>
        <h1 class="error-title">Halaman Tidak Ditemukan</h1>
        <p class="error-subtitle">
            Maaf, halaman yang Anda cari tidak ada atau telah dipindahkan.<br>
            Mungkin URL yang Anda masukkan salah, atau halaman ini sudah dihapus.
        </p>

        <div class="error-actions">
            <a href="{{ route('landing') }}" class="btn btn-primary btn-lg">
                🏠 Kembali ke Beranda
            </a>
            <a href="{{ route('blog.index') }}" class="btn btn-outline btn-lg">
                📚 Jelajahi Blog
            </a>
        </div>

        <div class="suggestions">
            <a href="{{ route('blog.index') }}" class="suggestion-link">📝 Semua Artikel</a>
            @foreach(\App\Models\Category::take(4)->get() as $cat)
            <a href="{{ route('blog.category', $cat->slug) }}" class="suggestion-link">🏷️ {{ $cat->name }}</a>
            @endforeach
            @guest
            <a href="{{ route('login') }}" class="suggestion-link">🔐 Login</a>
            @else
            <a href="{{ route('user.dashboard') }}" class="suggestion-link">📊 Dashboard</a>
            @endguest
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
