@extends('layouts.admin')
@section('title', 'Tulis Artikel Baru')

@section('page-header')
<div style="display:flex;align-items:center;gap:1rem;">
    <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary btn-sm">← Kembali</a>
    <h1 style="font-size:1.5rem;font-weight:900;margin:0;">✚ Tulis Artikel Baru</h1>
</div>
@endsection

@section('content')
<form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data">
    @csrf

    <div style="display:grid;grid-template-columns:1fr 300px;gap:1.5rem;align-items:start;">

        <!-- Main Content -->
        <div style="display:flex;flex-direction:column;gap:1.25rem;">

            <!-- Title -->
            <div class="card">
                <div class="card-body">
                    <div class="form-group" style="margin:0;">
                        <label class="form-label">Judul Artikel *</label>
                        <input type="text" name="title" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                               value="{{ old('title') }}" placeholder="Masukkan judul yang menarik..." style="font-size:1.1rem;font-weight:600;" required>
                        @error('title') <div class="form-error">✕ {{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <!-- Excerpt -->
            <div class="card">
                <div class="card-header"><h3 style="font-family:var(--font-sans);font-size:0.9rem;font-weight:800;margin:0;">📋 Ringkasan</h3></div>
                <div class="card-body">
                    <div class="form-group" style="margin:0;">
                        <textarea name="excerpt" class="form-control" rows="3" placeholder="Tulis ringkasan singkat artikel (maks. 500 karakter)..." maxlength="500">{{ old('excerpt') }}</textarea>
                        <div class="form-hint">Ditampilkan di halaman daftar dan preview artikel. Maks. 500 karakter.</div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="card">
                <div class="card-header"><h3 style="font-family:var(--font-sans);font-size:0.9rem;font-weight:800;margin:0;">📝 Konten Artikel *</h3></div>
                <div class="card-body">
                    <div class="form-group" style="margin:0;">
                        <textarea name="content" id="content-editor" class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}" rows="20"
                                  placeholder="Tulis konten artikel di sini... (HTML didukung)" required>{{ old('content') }}</textarea>
                        @error('content') <div class="form-error">✕ {{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Settings -->
        <div style="display:flex;flex-direction:column;gap:1.25rem;position:sticky;top:88px;">

            <!-- Publish -->
            <div class="card">
                <div class="card-header"><h3 style="font-family:var(--font-sans);font-size:0.9rem;font-weight:800;margin:0;">🚀 Publikasi</h3></div>
                <div class="card-body" style="display:flex;flex-direction:column;gap:0.75rem;">
                    <div class="form-group" style="margin:0;">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control">
                            <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>📋 Draft</option>
                            <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>✅ Published</option>
                        </select>
                    </div>
                    <label style="display:flex;align-items:center;gap:0.5rem;cursor:pointer;font-size:0.875rem;font-weight:500;">
                        <input type="checkbox" name="featured" value="1" {{ old('featured') ? 'checked' : '' }} style="accent-color:var(--brand);">
                        ⭐ Tandai sebagai unggulan
                    </label>
                    <div style="display:flex;gap:0.5rem;flex-direction:column;margin-top:0.5rem;">
                        <button type="submit" class="btn btn-primary">💾 Simpan Artikel</button>
                        <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary" style="text-align:center;">Batal</a>
                    </div>
                </div>
            </div>

            <!-- Category -->
            <div class="card">
                <div class="card-header"><h3 style="font-family:var(--font-sans);font-size:0.9rem;font-weight:800;margin:0;">🏷️ Kategori</h3></div>
                <div class="card-body">
                    <select name="category_id" class="form-control">
                        <option value="">— Pilih Kategori —</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Tags -->
            <div class="card">
                <div class="card-header"><h3 style="font-family:var(--font-sans);font-size:0.9rem;font-weight:800;margin:0;">🔖 Tags</h3></div>
                <div class="card-body">
                    <div style="display:flex;flex-wrap:wrap;gap:0.4rem;max-height:200px;overflow-y:auto;">
                        @foreach($tags as $tag)
                        <label style="display:inline-flex;align-items:center;gap:0.3rem;padding:0.25rem 0.6rem;border-radius:var(--radius-full);border:1px solid var(--border-color);font-size:0.775rem;cursor:pointer;transition:all 0.2s;" class="tag-label">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}" style="display:none;"
                                   {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}
                                   onchange="this.closest('label').classList.toggle('tag-active', this.checked)">
                            #{{ $tag->name }}
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Thumbnail -->
            <div class="card">
                <div class="card-header"><h3 style="font-family:var(--font-sans);font-size:0.9rem;font-weight:800;margin:0;">🖼️ Thumbnail</h3></div>
                <div class="card-body">
                    <div id="thumb-preview" style="border-radius:var(--radius-md);overflow:hidden;margin-bottom:0.75rem;display:none;">
                        <img id="thumb-img" src="" alt="Preview" style="width:100%;height:140px;object-fit:cover;">
                    </div>
                    <input type="file" name="thumbnail" class="form-control" accept="image/*" onchange="previewThumb(this)">
                    <div class="form-hint">Format: JPG, PNG. Maks 3MB.</div>
                </div>
            </div>
        </div>
    </div>
</form>

@push('styles')
<style>
.tag-label.tag-active, .tag-label:has(input:checked) {
    background: var(--brand);
    border-color: var(--brand);
    color: white;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
tinymce.init({
    selector: '#content-editor',
    height: 500,
    menubar: false,
    skin: document.documentElement.getAttribute('data-theme') === 'dark' ? 'oxide-dark' : 'oxide',
    content_css: document.documentElement.getAttribute('data-theme') === 'dark' ? 'dark' : 'default',
    plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table wordcount',
    toolbar: 'undo redo | blocks | bold italic underline strikethrough | link image | bullist numlist | alignleft aligncenter alignright | removeformat | code fullscreen',
    content_style: 'body { font-family: Inter, sans-serif; font-size: 16px; line-height: 1.7; }',
    branding: false,
});

function previewThumb(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('thumb-img').src = e.target.result;
            document.getElementById('thumb-preview').style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection
