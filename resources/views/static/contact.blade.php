@extends('layouts.app')
@section('title', 'Hubungi Kami')

@section('content')
<div style="padding: 3rem 0;">
    <div class="container">
        <!-- Header -->
        <div class="animate-on-scroll" style="text-align: center; margin-bottom: 4rem;">
            <span class="badge badge-primary" style="margin-bottom: 0.75rem; font-size: 0.75rem; text-transform: uppercase;">Get In Touch</span>
            <h1 style="font-size: 2.25rem; font-weight: 800; margin: 0; font-family: var(--font-serif);">Hubungi Kami</h1>
            <p style="color: var(--text-muted); font-size: 0.95rem; margin-top: 0.5rem; max-width: 480px; margin-left: auto; margin-right: auto;">
                Punya pertanyaan, feedback, atau ingin berkolaborasi? Kirimkan pesan Anda melalui formulir di bawah ini.
            </p>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 3rem; align-items: start;" class="contact-grid">
            
            <!-- Contact Info -->
            <div style="display: flex; flex-direction: column; gap: 2rem;">
                <!-- Info Card -->
                <div class="card animate-on-scroll delay-1" style="background: var(--gradient-card); border-radius: var(--radius-xl); border: 1px solid var(--border-color); box-shadow: var(--shadow-xl); padding: 2.5rem;">
                    <h2 style="font-family: var(--font-sans); font-size: 1.25rem; font-weight: 800; margin: 0 0 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                        ✉️ Informasi Kontak
                    </h2>
                    
                    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                        <!-- Item 1 -->
                        <div style="display: flex; gap: 1rem; align-items: flex-start;">
                            <div style="width: 40px; height: 40px; border-radius: var(--radius-md); background: rgba(99,102,241,0.1); border: 1px solid var(--brand); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0;">
                                📍
                            </div>
                            <div>
                                <h3 style="font-family: var(--font-sans); font-size: 0.9rem; font-weight: 700; margin: 0 0 0.25rem;">Kantor Pusat</h3>
                                <p style="color: var(--text-secondary); font-size: 0.85rem; margin: 0; line-height: 1.5;">
                                    Sudirman Central Business District (SCBD), Lantai 42, Jakarta Selatan, Indonesia
                                </p>
                            </div>
                        </div>

                        <!-- Item 2 -->
                        <div style="display: flex; gap: 1rem; align-items: flex-start;">
                            <div style="width: 40px; height: 40px; border-radius: var(--radius-md); background: rgba(16,185,129,0.1); border: 1px solid var(--success); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0;">
                                📧
                            </div>
                            <div>
                                <h3 style="font-family: var(--font-sans); font-size: 0.9rem; font-weight: 700; margin: 0 0 0.25rem;">Email Support</h3>
                                <p style="color: var(--text-secondary); font-size: 0.85rem; margin: 0;">
                                    support@nexablog.com
                                </p>
                            </div>
                        </div>

                        <!-- Item 3 -->
                        <div style="display: flex; gap: 1rem; align-items: flex-start;">
                            <div style="width: 40px; height: 40px; border-radius: var(--radius-md); background: rgba(245,158,11,0.1); border: 1px solid var(--warning); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0;">
                                📞
                            </div>
                            <div>
                                <h3 style="font-family: var(--font-sans); font-size: 0.9rem; font-weight: 700; margin: 0 0 0.25rem;">Telepon</h3>
                                <p style="color: var(--text-secondary); font-size: 0.85rem; margin: 0;">
                                    +62 (21) 500-NEXA
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Map Widget / Virtual Mockup -->
                <div class="card animate-on-scroll delay-2" style="background: var(--gradient-card); border-radius: var(--radius-xl); border: 1px solid var(--border-color); box-shadow: var(--shadow-xl); padding: 1.5rem; height: 200px; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; text-align: center;">
                    <div style="position: absolute; width: 100%; height: 100%; background: linear-gradient(135deg, rgba(99,102,241,0.08) 0%, rgba(16,185,129,0.08) 100%); z-index: 0;"></div>
                    <div style="position: relative; z-index: 1;">
                        <span style="font-size: 2.5rem;">🗺️</span>
                        <h3 style="font-family: var(--font-sans); font-size: 1rem; font-weight: 700; margin: 0.5rem 0 0.25rem;">Interactive Map</h3>
                        <p style="color: var(--text-muted); font-size: 0.775rem; margin: 0;">Terintegrasi dengan sistem koordinat Jakarta Pusat.</p>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <div class="card animate-on-scroll delay-1" style="background: var(--gradient-card); border-radius: var(--radius-xl); border: 1px solid var(--border-color); box-shadow: var(--shadow-xl); padding: 2.5rem;">
                <h2 style="font-family: var(--font-sans); font-size: 1.25rem; font-weight: 800; margin: 0 0 1.5rem;">
                    📬 Kirimkan Pesan
                </h2>

                <form method="POST" action="{{ route('contact.send') }}">
                    @csrf
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Nama Anda" required>
                            @error('name') <div class="form-error">✕ {{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Alamat Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="nama@email.com" required>
                            @error('email') <div class="form-error">✕ {{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Subjek</label>
                        <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" value="{{ old('subject') }}" placeholder="Subjek pesan" required>
                        @error('subject') <div class="form-error">✕ {{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Pesan Anda</label>
                        <textarea name="message" class="form-control @error('message') is-invalid @enderror" rows="5" placeholder="Tuliskan pesan Anda di sini..." required>{{ old('message') }}</textarea>
                        @error('message') <div class="form-error">✕ {{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-full" style="justify-content: center; margin-top: 1rem;">
                        ✉️ Kirim Pesan Sekarang
                    </button>
                </form>
            </div>
            
        </div>
    </div>
</div>

@push('styles')
<style>
@media (max-width: 768px) {
    .contact-grid {
        grid-template-columns: 1fr !important;
        gap: 2rem !important;
    }
}
</style>
@endpush
@endsection
