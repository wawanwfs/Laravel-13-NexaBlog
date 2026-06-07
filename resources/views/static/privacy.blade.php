@extends('layouts.app')
@section('title', 'Kebijakan Privasi')

@section('content')
<div style="padding: 3rem 0;">
    <div class="container-sm">
        <!-- Header -->
        <div class="animate-on-scroll" style="text-align: center; margin-bottom: 3rem;">
            <span class="badge badge-primary" style="margin-bottom: 0.75rem; font-size: 0.75rem; text-transform: uppercase;">Legal Policy</span>
            <h1 style="font-size: 2.25rem; font-weight: 800; margin: 0;">Kebijakan Privasi</h1>
            <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 0.5rem;">Terakhir Diperbarui: {{ date('d F Y') }}</p>
        </div>

        <!-- Document Content -->
        <div class="card animate-on-scroll delay-1" style="padding: 3rem 2.5rem; background: var(--gradient-card); border-radius: var(--radius-xl); border: 1px solid var(--border-color); box-shadow: var(--shadow-xl); line-height: 1.8;">
            <p style="font-size: 1.05rem; color: var(--text-secondary); margin-bottom: 2rem;">
                Di NexaBlog, dapat diakses dari {{ request()->getHost() }}, salah satu prioritas utama kami adalah privasi pengunjung kami. Dokumen Kebijakan Privasi ini berisi jenis informasi yang dikumpulkan dan dicatat oleh NexaBlog dan bagaimana kami menggunakannya.
            </p>

            <h2 style="font-family: var(--font-sans); font-size: 1.25rem; font-weight: 800; color: var(--text-primary); margin: 2rem 0 1rem;">
                1. Informasi Yang Kami Kumpulkan
            </h2>
            <p style="color: var(--text-secondary); margin-bottom: 1.25rem;">
                Informasi pribadi yang diminta untuk Anda berikan, dan alasan mengapa Anda diminta untuk memberikannya, akan dijelaskan kepada Anda pada saat kami meminta Anda memberikan informasi pribadi tersebut.
            </p>
            <ul style="color: var(--text-secondary); padding-left: 1.5rem; margin-bottom: 1.5rem;">
                <li style="margin-bottom: 0.5rem;"><strong>Informasi Akun:</strong> Ketika Anda mendaftar Akun, kami dapat meminta informasi kontak Anda, termasuk item seperti nama, nama perusahaan, alamat, alamat email, dan nomor telepon.</li>
                <li style="margin-bottom: 0.5rem;"><strong>Aktivitas Konten:</strong> Ketika Anda menulis komentar, artikel, atau berinteraksi dalam platform, data tersebut akan terekam untuk menyempurnakan fitur moderasi.</li>
            </ul>

            <h2 style="font-family: var(--font-sans); font-size: 1.25rem; font-weight: 800; color: var(--text-primary); margin: 2rem 0 1rem;">
                2. Bagaimana Kami Menggunakan Informasi Anda
            </h2>
            <p style="color: var(--text-secondary); margin-bottom: 1.25rem;">
                Kami menggunakan informasi yang kami kumpulkan dengan berbagai cara, termasuk untuk:
            </p>
            <ul style="color: var(--text-secondary); padding-left: 1.5rem; margin-bottom: 1.5rem;">
                <li style="margin-bottom: 0.5rem;">Menyediakan, mengoperasikan, dan memelihara situs web kami.</li>
                <li style="margin-bottom: 0.5rem;">Meningkatkan, mempersonalisasi, dan memperluas situs web kami.</li>
                <li style="margin-bottom: 0.5rem;">Memahami dan menganalisis bagaimana Anda menggunakan situs web kami.</li>
                <li style="margin-bottom: 0.5rem;">Mengembangkan produk, layanan, fitur, dan fungsionalitas baru.</li>
            </ul>

            <h2 style="font-family: var(--font-sans); font-size: 1.25rem; font-weight: 800; color: var(--text-primary); margin: 2rem 0 1rem;">
                3. Keamanan Data Anda
            </h2>
            <p style="color: var(--text-secondary); margin-bottom: 1.25rem;">
                Keamanan data Anda sangat penting bagi kami, tetapi ingatlah bahwa tidak ada metode transmisi melalui Internet, atau metode penyimpanan elektronik yang 100% aman. Kami berusaha menggunakan cara yang dapat diterima secara komersial untuk melindungi data pribadi Anda, tetapi kami tidak dapat menjamin keamanan mutlaknya.
            </p>

            <h2 style="font-family: var(--font-sans); font-size: 1.25rem; font-weight: 800; color: var(--text-primary); margin: 2rem 0 1rem;">
                4. Cookies dan Web Beacons
            </h2>
            <p style="color: var(--text-secondary); margin-bottom: 1.25rem;">
                Seperti situs web lainnya, NexaBlog menggunakan 'cookies'. Cookies digunakan untuk menyimpan informasi termasuk preferensi pengunjung, dan halaman-halaman di situs web yang diakses atau dikunjungi pengunjung. Informasi tersebut digunakan untuk mengoptimalkan pengalaman pengguna dengan menyesuaikan konten halaman web kami berdasarkan jenis browser pengunjung dan/atau informasi lainnya.
            </p>

            <h2 style="font-family: var(--font-sans); font-size: 1.25rem; font-weight: 800; color: var(--text-primary); margin: 2rem 0 1rem;">
                5. Persetujuan
            </h2>
            <p style="color: var(--text-secondary); margin-bottom: 0;">
                Dengan menggunakan situs web kami, Anda dengan ini menyetujui Kebijakan Privasi kami dan menyetujui ketentuan-ketentuannya.
            </p>
        </div>
    </div>
</div>
@endsection
