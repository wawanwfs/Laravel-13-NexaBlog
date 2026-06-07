<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $exception->getStatusCode() }} — Error | NexaBlog</title>
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
            top: -30%; left: -20%;
            width: 60%; height: 70%;
            background: var(--gradient-brand);
            opacity: 0.04;
            border-radius: 50%;
            filter: blur(80px);
        }
        .error-code {
            font-family: var(--font-serif);
            font-size: clamp(6rem, 18vw, 11rem);
            font-weight: 900;
            line-height: 1;
            background: var(--gradient-brand);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative; z-index: 1;
            animation: fadeInUp 0.6s ease both;
            letter-spacing: -0.03em;
        }
        .error-emoji {
            font-size: clamp(2.5rem, 6vw, 4rem);
            margin-bottom: 0.5rem;
            position: relative; z-index: 1;
        }
        .error-title {
            font-size: clamp(1.25rem, 3vw, 1.75rem);
            font-weight: 800;
            margin: 0.75rem 0 0.75rem;
            position: relative; z-index: 1;
            animation: fadeInUp 0.6s 0.1s ease both;
        }
        .error-subtitle {
            color: var(--text-secondary);
            max-width: 440px;
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
        @php
            $code = $exception->getStatusCode();
            $emojis = [400=>'❓', 401=>'🔐', 402=>'💳', 403=>'🚫', 404=>'🔍', 405=>'🚧', 408=>'⏱️', 419=>'🔄', 422=>'⚠️', 429=>'🚦', 500=>'💥', 502=>'🌐', 503=>'⚙️', 504=>'⏰'];
            $messages = [400=>'Permintaan Tidak Valid', 401=>'Autentikasi Diperlukan', 403=>'Akses Ditolak', 404=>'Halaman Tidak Ditemukan', 405=>'Metode Tidak Diizinkan', 408=>'Waktu Permintaan Habis', 419=>'Sesi Berakhir', 422=>'Data Tidak Valid', 429=>'Terlalu Banyak Permintaan', 500=>'Kesalahan Server', 502=>'Bad Gateway', 503=>'Layanan Tidak Tersedia', 504=>'Gateway Timeout'];
            $emoji = $emojis[$code] ?? '❗';
            $message = $messages[$code] ?? 'Terjadi Kesalahan';
        @endphp

        <div class="error-emoji">{{ $emoji }}</div>
        <div class="error-code">{{ $code }}</div>
        <h1 class="error-title">{{ $message }}</h1>
        <p class="error-subtitle">
            @if($code === 403)
                Anda tidak memiliki izin untuk mengakses halaman ini.
            @elseif($code === 401)
                Silakan login untuk melanjutkan.
            @elseif($code === 419)
                Sesi Anda telah berakhir. Silakan refresh halaman dan coba lagi.
            @elseif($code === 429)
                Anda terlalu banyak membuat permintaan. Tunggu sebentar sebelum mencoba lagi.
            @else
                Terjadi kesalahan. Silakan kembali ke beranda atau coba lagi.
            @endif
        </p>

        <div class="error-actions">
            @if($code === 401)
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg">🔐 Login Sekarang</a>
            @elseif($code === 419)
                <button onclick="window.location.reload()" class="btn btn-primary btn-lg">🔄 Refresh Halaman</button>
            @endif
            <a href="{{ route('landing') }}" class="btn btn-outline btn-lg">🏠 Ke Beranda</a>
            @if($code !== 401)
            <button onclick="window.history.back()" class="btn btn-secondary btn-lg">← Kembali</button>
            @endif
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
