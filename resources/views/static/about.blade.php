@extends('layouts.app')
@section('title', 'Tentang Kami')

@section('content')
<div style="padding: 3rem 0; position: relative; overflow: hidden;">
    <div class="container">
        <!-- Story / Header Section -->
        <div class="animate-on-scroll" style="text-align: center; margin-bottom: 4rem; padding: 4rem 2rem; background: var(--gradient-card); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border-radius: var(--radius-2xl); border: 1px solid var(--border-color); box-shadow: var(--shadow-xl); position: relative; overflow: hidden;">
            <!-- Ambient interior glow -->
            <div style="position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(99,102,241,0.06) 0%, transparent 60%); pointer-events: none;"></div>
            
            <span class="badge badge-primary" style="margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 0.15em; font-size: 0.75rem; padding: 0.4rem 1rem;">NexaBlog Story</span>
            <h1 style="font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 900; line-height: 1.1; margin-bottom: 1.5rem; font-family: var(--font-serif);">
                Membentuk Masa Depan<br><span style="background: var(--gradient-brand); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Dunia Literasi Digital</span>
            </h1>
            <p style="color: var(--text-secondary); max-width: 680px; margin: 0 auto; line-height: 1.8; font-size: 1.1rem;">
                NexaBlog lahir sebagai visi untuk menghadirkan platform publikasi yang tidak hanya informatif, tetapi juga menghibur dan menginspirasi pembaca melalui antarmuka modern kelas atas. Kami percaya setiap ide layak mendapatkan panggung terbaik.
            </p>
        </div>

        <!-- Vision, Mission & Values Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 2rem; margin-bottom: 4rem;">
            <!-- Vision -->
            <div class="card animate-on-scroll delay-1" style="height: 100%; display: flex; flex-direction: column; justify-content: space-between;">
                <div class="card-header" style="border: none; padding-bottom: 0;">
                    <div style="width: 48px; height: 48px; border-radius: var(--radius-lg); background: rgba(99,102,241,0.1); border: 1px solid var(--brand); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 1.25rem;">
                        👁️‍🗨️
                    </div>
                    <h2 style="font-family: var(--font-sans); font-size: 1.25rem; font-weight: 800; margin: 0;">Visi Kami</h2>
                </div>
                <div class="card-body" style="padding-top: 1rem;">
                    <p style="color: var(--text-secondary); line-height: 1.7; margin: 0;">
                        Menjadi ekosistem media digital terkemuka yang memberdayakan kreator, menumbuhkan budaya membaca, dan menyebarkan wawasan transformatif secara global melalui inovasi teknologi dan keunggulan editorial.
                    </p>
                </div>
            </div>

            <!-- Mission -->
            <div class="card animate-on-scroll delay-2" style="height: 100%; display: flex; flex-direction: column; justify-content: space-between;">
                <div class="card-header" style="border: none; padding-bottom: 0;">
                    <div style="width: 48px; height: 48px; border-radius: var(--radius-lg); background: rgba(16,185,129,0.1); border: 1px solid var(--success); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 1.25rem;">
                        🚀
                    </div>
                    <h2 style="font-family: var(--font-sans); font-size: 1.25rem; font-weight: 800; margin: 0;">Misi Kami</h2>
                </div>
                <div class="card-body" style="padding-top: 1rem;">
                    <ul style="color: var(--text-secondary); line-height: 1.7; padding-left: 1.2rem; margin: 0;">
                        <li style="margin-bottom: 0.5rem;">Menyediakan tulisan kurasi berkualitas tinggi di berbagai bidang keahlian.</li>
                        <li style="margin-bottom: 0.5rem;">Mengembangkan platform interaktif dengan antarmuka yang cepat dan ramah pengguna.</li>
                        <li>Membina kolaborasi yang inklusif antara penulis, pembaca, dan pakar industri.</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Team Section -->
        <div class="animate-on-scroll" style="margin-bottom: 3rem;">
            <div style="text-align: center; margin-bottom: 3rem;">
                <span class="badge badge-success" style="margin-bottom: 0.75rem; font-size: 0.75rem;">Nexa Team</span>
                <h2 style="font-size: 2rem; font-weight: 800; margin: 0;">Kenali Tim Kreatif Kami</h2>
                <p style="color: var(--text-muted); font-size: 0.95rem; margin-top: 0.5rem;">Orang-orang berbakat di balik layar yang menghidupkan NexaBlog.</p>
            </div>

            <!-- Team Members Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
                <!-- Member 1 -->
                <div class="card text-center animate-on-scroll delay-1" style="overflow: hidden; display: flex; flex-direction: column; align-items: center; padding: 2.5rem 1.5rem;">
                    <div style="position: relative; margin-bottom: 1.5rem;">
                        <div style="width: 100px; height: 100px; border-radius: 50%; background: var(--gradient-brand); padding: 3px;">
                            <div style="width: 100%; height: 100%; border-radius: 50%; background: var(--bg-card); display: flex; align-items: center; justify-content: center; font-size: 2.5rem; font-weight: 800; color: var(--brand);">
                                WF
                            </div>
                        </div>
                    </div>
                    <h3 style="font-family: var(--font-sans); font-size: 1.15rem; font-weight: 800; margin-bottom: 0.25rem;">Wahyu Fajar</h3>
                    <span class="badge badge-primary" style="font-size: 0.725rem; margin-bottom: 1rem;">Co-Founder & CEO</span>
                    <p style="color: var(--text-secondary); font-size: 0.85rem; line-height: 1.6; margin: 0 0 1.5rem;">
                        Mengarahkan arah strategis NexaBlog untuk terus berinovasi di ranah publishing modern.
                    </p>
                    <div style="display: flex; gap: 0.75rem; justify-content: center;">
                        <a href="#" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;" onmouseover="this.style.color='var(--brand)'" onmouseout="this.style.color='var(--text-muted)'">LinkedIn</a>
                        <span style="color: var(--border-color);">|</span>
                        <a href="#" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;" onmouseover="this.style.color='var(--brand)'" onmouseout="this.style.color='var(--text-muted)'">GitHub</a>
                    </div>
                </div>

                <!-- Member 2 -->
                <div class="card text-center animate-on-scroll delay-2" style="overflow: hidden; display: flex; flex-direction: column; align-items: center; padding: 2.5rem 1.5rem;">
                    <div style="position: relative; margin-bottom: 1.5rem;">
                        <div style="width: 100px; height: 100px; border-radius: 50%; background: linear-gradient(135deg, #10b981, #3b82f6); padding: 3px;">
                            <div style="width: 100%; height: 100%; border-radius: 50%; background: var(--bg-card); display: flex; align-items: center; justify-content: center; font-size: 2.5rem; font-weight: 800; color: #10b981;">
                                AD
                            </div>
                        </div>
                    </div>
                    <h3 style="font-family: var(--font-sans); font-size: 1.15rem; font-weight: 800; margin-bottom: 0.25rem;">Amanda Dewina</h3>
                    <span class="badge badge-success" style="font-size: 0.725rem; margin-bottom: 1rem; background: rgba(16,185,129,0.1); color: var(--success);">Chief Editor</span>
                    <p style="color: var(--text-secondary); font-size: 0.85rem; line-height: 1.6; margin: 0 0 1.5rem;">
                        Mengurasi dan memastikan keaslian serta kualitas standar penulisan konten di NexaBlog.
                    </p>
                    <div style="display: flex; gap: 0.75rem; justify-content: center;">
                        <a href="#" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;" onmouseover="this.style.color='var(--success)'" onmouseout="this.style.color='var(--text-muted)'">LinkedIn</a>
                        <span style="color: var(--border-color);">|</span>
                        <a href="#" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;" onmouseover="this.style.color='var(--success)'" onmouseout="this.style.color='var(--text-muted)'">Twitter</a>
                    </div>
                </div>

                <!-- Member 3 -->
                <div class="card text-center animate-on-scroll delay-3" style="overflow: hidden; display: flex; flex-direction: column; align-items: center; padding: 2.5rem 1.5rem;">
                    <div style="position: relative; margin-bottom: 1.5rem;">
                        <div style="width: 100px; height: 100px; border-radius: 50%; background: linear-gradient(135deg, #f59e0b, #ef4444); padding: 3px;">
                            <div style="width: 100%; height: 100%; border-radius: 50%; background: var(--bg-card); display: flex; align-items: center; justify-content: center; font-size: 2.5rem; font-weight: 800; color: #f59e0b;">
                                RF
                            </div>
                        </div>
                    </div>
                    <h3 style="font-family: var(--font-sans); font-size: 1.15rem; font-weight: 800; margin-bottom: 0.25rem;">Rian Fauzi</h3>
                    <span class="badge badge-warning" style="font-size: 0.725rem; margin-bottom: 1rem; background: rgba(245,158,11,0.1); color: var(--warning);">Lead UI/UX Designer</span>
                    <p style="color: var(--text-secondary); font-size: 0.85rem; line-height: 1.6; margin: 0 0 1.5rem;">
                        Merancang dan memoles elemen antarmuka (UI/UX) agar terasa mewah dan futuristik.
                    </p>
                    <div style="display: flex; gap: 0.75rem; justify-content: center;">
                        <a href="#" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;" onmouseover="this.style.color='var(--warning)'" onmouseout="this.style.color='var(--text-muted)'">Dribbble</a>
                        <span style="color: var(--border-color);">|</span>
                        <a href="#" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;" onmouseover="this.style.color='var(--warning)'" onmouseout="this.style.color='var(--text-muted)'">Behance</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
