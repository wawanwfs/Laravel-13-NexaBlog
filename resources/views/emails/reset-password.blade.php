<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Password - NexaBlog</title>
    <style>
        body { font-family: 'Inter', sans-serif; background: #f1f5f9; margin: 0; padding: 40px 0; }
        .wrapper { max-width: 560px; margin: 0 auto; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #6366f1, #ec4899); padding: 40px; text-align: center; }
        .header h1 { color: white; font-size: 24px; margin: 0; font-weight: 800; }
        .header p { color: rgba(255,255,255,0.85); margin: 8px 0 0; font-size: 14px; }
        .body { padding: 40px; }
        .body p { color: #475569; font-size: 15px; line-height: 1.7; }
        .btn { display: block; text-align: center; background: linear-gradient(135deg, #6366f1, #ec4899); color: white; text-decoration: none; padding: 14px 32px; border-radius: 10px; font-weight: 700; font-size: 15px; margin: 28px 0; }
        .url { background: #f1f5f9; padding: 12px; border-radius: 8px; font-size: 12px; color: #64748b; word-break: break-all; }
        .footer { text-align: center; padding: 24px; background: #f8fafc; color: #94a3b8; font-size: 12px; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <h1>🔐 Reset Password</h1>
            <p>NexaBlog — Platform Blog Terbaik</p>
        </div>
        <div class="body">
            <p>Halo,</p>
            <p>Kami menerima permintaan reset password untuk akun Anda <strong>{{ $email }}</strong>. Klik tombol di bawah untuk membuat password baru.</p>
            <a href="{{ $resetUrl }}" class="btn">Reset Password Saya</a>
            <p>Link ini akan kadaluarsa dalam <strong>60 menit</strong>. Jika Anda tidak meminta reset password, abaikan email ini.</p>
            <p style="font-size:13px;color:#94a3b8;">Atau salin URL berikut ke browser Anda:</p>
            <div class="url">{{ $resetUrl }}</div>
        </div>
        <div class="footer">
            © {{ date('Y') }} NexaBlog. Semua hak dilindungi.
        </div>
    </div>
</body>
</html>
