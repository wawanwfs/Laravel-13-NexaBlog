@extends('layouts.app')
@section('title', 'Syarat & Ketentuan')

@section('content')
<div style="padding: 3rem 0;">
    <div class="container-sm">
        <!-- Header -->
        <div class="animate-on-scroll" style="text-align: center; margin-bottom: 3rem;">
            <span class="badge badge-primary" style="margin-bottom: 0.75rem; font-size: 0.75rem; text-transform: uppercase;">Agreement</span>
            <h1 style="font-size: 2.25rem; font-weight: 800; margin: 0;">Syarat & Ketentuan</h1>
            <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 0.5rem;">Terakhir Diperbarui: {{ date('d F Y') }}</p>
        </div>

        <!-- Document Content -->
        <div class="card animate-on-scroll delay-1" style="padding: 3rem 2.5rem; background: var(--gradient-card); border-radius: var(--radius-xl); border: 1px solid var(--border-color); box-shadow: var(--shadow-xl); line-height: 1.8;">
            <p style="font-size: 1.05rem; color: var(--text-secondary); margin-bottom: 2rem;">
                Selamat datang di NexaBlog! Syarat dan ketentuan ini menguraikan aturan dan ketentuan penggunaan situs web NexaBlog, yang terletak di {{ request()->getHost() }}.
            </p>

            <h2 style="font-family: var(--font-sans); font-size: 1.25rem; font-weight: 800; color: var(--text-primary); margin: 2rem 0 1rem;">
                1. Ketentuan Penerimaan
            </h2>
            <p style="color: var(--text-secondary); margin-bottom: 1.25rem;">
                Dengan mengakses situs web ini, kami menganggap Anda menerima syarat dan ketentuan ini. Jangan melanjutkan penggunaan NexaBlog jika Anda tidak menyetujui semua syarat dan ketentuan yang dinyatakan di halaman ini.
            </p>

            <h2 style="font-family: var(--font-sans); font-size: 1.25rem; font-weight: 800; color: var(--text-primary); margin: 2rem 0 1rem;">
                2. Hak Kekayaan Intelektual
            </h2>
            <p style="color: var(--text-secondary); margin-bottom: 1.25rem;">
                Kecuali dinyatakan lain, NexaBlog dan/atau pemberi lisensinya memiliki hak kekayaan intelektual atas semua materi di NexaBlog. Semua hak kekayaan intelektual dilindungi undang-undang. Anda dapat mengakses ini dari NexaBlog untuk penggunaan pribadi Anda sendiri yang tunduk pada batasan yang diatur dalam syarat dan ketentuan ini.
            </p>
            <p style="color: var(--text-secondary); margin-bottom: 1.25rem;">
                Anda tidak diperbolehkan untuk:
            </p>
            <ul style="color: var(--text-secondary); padding-left: 1.5rem; margin-bottom: 1.5rem;">
                <li style="margin-bottom: 0.5rem;">Menerbitkan ulang materi dari NexaBlog tanpa izin tertulis.</li>
                <li style="margin-bottom: 0.5rem;">Menjual, menyewakan, atau mensublisensikan materi dari NexaBlog.</li>
                <li style="margin-bottom: 0.5rem;">Mereproduksi, menggandakan, atau menyalin materi dari NexaBlog.</li>
                <li>Mendistribusikan ulang konten dari NexaBlog.</li>
            </ul>

            <h2 style="font-family: var(--font-sans); font-size: 1.25rem; font-weight: 800; color: var(--text-primary); margin: 2rem 0 1rem;">
                3. Konten Pengguna (Komentar & Artikel)
            </h2>
            <p style="color: var(--text-secondary); margin-bottom: 1.25rem;">
                Beberapa bagian dari situs web ini menawarkan kesempatan bagi pengguna untuk memposting opini dan bertukar informasi. NexaBlog tidak menyaring, mengedit, mempublikasikan, atau meninjau Komentar sebelum kehadirannya di situs web. Komentar mencerminkan pandangan orang yang mempostingnya dan bukan pandangan NexaBlog.
            </p>
            <p style="color: var(--text-secondary); margin-bottom: 1.25rem;">
                NexaBlog berhak memantau semua komentar dan menghapus komentar yang dianggap tidak pantas, menyinggung, atau melanggar Syarat dan Ketentuan ini.
            </p>

            <h2 style="font-family: var(--font-sans); font-size: 1.25rem; font-weight: 800; color: var(--text-primary); margin: 2rem 0 1rem;">
                4. Batasan Tanggung Jawab
            </h2>
            <p style="color: var(--text-secondary); margin-bottom: 1.25rem;">
                Dalam batas maksimal yang diizinkan oleh hukum, NexaBlog tidak akan bertanggung jawab atas kehilangan atau kerusakan dalam bentuk apa pun yang timbul dari penggunaan situs web ini. Informasi yang kami sediakan di situs web ini bersifat gratis, dan Anda mengakui bahwa tanggung jawab penggunaan berada di tangan Anda sendiri.
            </p>

            <h2 style="font-family: var(--font-sans); font-size: 1.25rem; font-weight: 800; color: var(--text-primary); margin: 2rem 0 1rem;">
                5. Perubahan Ketentuan
            </h2>
            <p style="color: var(--text-secondary); margin-bottom: 0;">
                Kami berhak merevisi syarat dan ketentuan ini kapan saja. Dengan menggunakan situs web ini secara terus-menerus, Anda diharapkan untuk meninjau syarat dan ketentuan ini secara berkala.
            </p>
        </div>
    </div>
</div>
@endsection
