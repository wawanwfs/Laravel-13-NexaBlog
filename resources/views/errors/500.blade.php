<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 — Server Error | NexaBlog</title>
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
            top: -40%; right: -20%;
            width: 70%; height: 80%;
            background: radial-gradient(circle, rgba(239,68,68,0.15), transparent);
            border-radius: 50%;
            filter: blur(80px);
            animation: float1 8s ease-in-out infinite alternate;
        }
        .error-page::after {
            content: '';
            position: absolute;
            bottom: -30%; left: -20%;
            width: 60%; height: 70%;
            background: var(--gradient-brand);
            opacity: 0.05;
            border-radius: 50%;
            filter: blur(80px);
            animation: float2 10s ease-in-out infinite alternate;
        }
        @keyframes float1 { from { transform: scale(1); } to { transform: scale(1.2) rotate(10deg); } }
        @keyframes float2 { from { transform: scale(1); } to { transform: scale(1.15) rotate(-12deg); } }

        .error-code {
            font-family: var(--font-serif);
            font-size: clamp(6rem, 18vw, 11rem);
            font-weight: 900;
            line-height: 1;
            background: linear-gradient(135deg, #ef4444, #f97316);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative; z-index: 1;
            animation: fadeInUp 0.6s ease both;
            letter-spacing: -0.03em;
        }
        .error-emoji {
            font-size: clamp(3rem, 8vw, 5rem);
            margin-bottom: 0.5rem;
            position: relative; z-index: 1;
            animation: shake 0.5s ease 0.4s both;
        }
        @keyframes shake {
            0%,100% { transform: rotate(0); }
            20% { transform: rotate(-8deg); }
            40% { transform: rotate(8deg); }
            60% { transform: rotate(-4deg); }
            80% { transform: rotate(4deg); }
        }
        .error-title {
            font-size: clamp(1.5rem, 4vw, 2rem);
            font-weight: 800;
            color: var(--text-primary);
            margin: 0.75rem 0 1rem;
            position: relative; z-index: 1;
            animation: fadeInUp 0.6s 0.1s ease both;
        }
        .error-subtitle {
            font-size: 1.05rem;
            color: var(--text-secondary);
            max-width: 480px;
            line-height: 1.7;
            margin-bottom: 2rem;
            position: relative; z-index: 1;
            animation: fadeInUp 0.6s 0.2s ease both;
        }
        .error-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: center;
            position: relative; z-index: 1;
            animation: fadeInUp 0.6s 0.3s ease both;
        }
        .error-code-box {
            margin-top: 2rem;
            padding: 1rem 1.5rem;
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            font-family: var(--font-mono);
            font-size: 0.8rem;
            color: var(--text-muted);
            position: relative; z-index: 1;
            animation: fadeInUp 0.6s 0.4s ease both;
            max-width: 480px;
            text-align: left;
        }
    </style>
</head>
<body>
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
        <div class="error-emoji">⚠️</div>
        <div class="error-code">500</div>
        <h1 class="error-title">Ups! Terjadi Kesalahan Server</h1>
        <p class="error-subtitle">
            Server kami mengalami masalah sementara dan tidak dapat memproses permintaan Anda.<br>
            Tim kami sudah diberitahu. Silakan coba lagi dalam beberapa menit.
        </p>

        <div class="error-actions">
            <a href="{{ route('landing') }}" class="btn btn-primary btn-lg">
                🏠 Kembali ke Beranda
            </a>
            <button onclick="window.location.reload()" class="btn btn-outline btn-lg">
                🔄 Coba Lagi
            </button>
        </div>

        <div class="error-code-box">
            <div style="color:var(--danger);font-weight:700;margin-bottom:0.25rem;">Error 500 — Internal Server Error</div>
            <div>{{ now()->format('d M Y, H:i:s') }} WIB</div>
            <div style="margin-top:0.25rem;color:var(--text-muted);">Jika masalah berlanjut, hubungi administrator sistem.</div>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
