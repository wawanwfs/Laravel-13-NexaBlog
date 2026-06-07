<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>503 — Maintenance | NexaBlog</title>
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
        body { min-height: 100vh; display: flex; align-items: center; justify-content: center; background: var(--bg-primary); }
        .error-page { text-align: center; padding: 2rem; max-width: 560px; }
        .gear { font-size: 5rem; animation: spin 3s linear infinite; display: block; margin-bottom: 1rem; }
        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        .error-code {
            font-family: var(--font-serif);
            font-size: clamp(5rem, 15vw, 9rem);
            font-weight: 900;
            background: linear-gradient(135deg, #f59e0b, #f97316);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1;
            animation: fadeInUp 0.6s ease both;
            letter-spacing: -0.03em;
        }
        .error-title {
            font-size: 1.75rem;
            font-weight: 800;
            margin: 0.75rem 0 1rem;
            animation: fadeInUp 0.6s 0.1s ease both;
        }
        .error-subtitle {
            color: var(--text-secondary);
            line-height: 1.7;
            margin-bottom: 2rem;
            animation: fadeInUp 0.6s 0.2s ease both;
        }
        .countdown-bar {
            height: 4px;
            background: var(--bg-tertiary);
            border-radius: var(--radius-full);
            overflow: hidden;
            margin: 1.5rem 0;
        }
        .countdown-bar-inner {
            height: 100%;
            background: linear-gradient(135deg, #f59e0b, #f97316);
            border-radius: var(--radius-full);
            animation: countdown 30s linear forwards;
        }
        @keyframes countdown { from { width: 100%; } to { width: 0%; } }
    </style>
</head>
<body>
    <div class="error-page">
        <span class="gear">⚙️</span>
        <div class="error-code">503</div>
        <h1 class="error-title">Sedang Maintenance</h1>
        <p class="error-subtitle">
            NexaBlog sedang dalam proses pemeliharaan untuk memberikan pengalaman yang lebih baik.<br>
            Kami akan kembali online sebentar lagi.
        </p>

        <div class="countdown-bar">
            <div class="countdown-bar-inner"></div>
        </div>

        <p style="font-size:0.875rem;color:var(--text-muted);">
            Halaman ini akan otomatis refresh dalam <span id="countdown" style="font-weight:700;color:var(--warning);">30</span> detik.
        </p>

        <div style="margin-top:2rem;">
            <a href="{{ route('landing') }}" class="btn btn-primary">🔄 Coba Sekarang</a>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        let count = 30;
        const el = document.getElementById('countdown');
        const timer = setInterval(() => {
            count--;
            el.textContent = count;
            if (count <= 0) {
                clearInterval(timer);
                window.location.reload();
            }
        }, 1000);
    </script>
</body>
</html>
