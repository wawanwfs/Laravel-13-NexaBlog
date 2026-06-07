@extends('layouts.admin')
@section('title', 'Edit Artikel')

@section('page-header')
<div style="display:flex;align-items:center;gap:1rem;flex-wrap:wrap;">
    <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary btn-sm">← Kembali</a>
    <h1 style="font-size:1.5rem;font-weight:900;margin:0;">✏️ Edit Artikel</h1>
    <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-secondary btn-sm" target="_blank">👁 Preview</a>
</div>
@endsection

@section('content')
<form method="POST" action="{{ route('admin.posts.update', $post) }}" enctype="multipart/form-data">
    @csrf @method('PUT')

    <div style="display:grid;grid-template-columns:1fr 300px;gap:1.5rem;align-items:start;">

        <!-- Main Content -->
        <div style="display:flex;flex-direction:column;gap:1.25rem;">
            <div class="card">
                <div class="card-body">
                    <div class="form-group" style="margin:0;">
                        <label class="form-label">Judul Artikel *</label>
                        <input type="text" name="title" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                               value="{{ old('title', $post->title) }}" style="font-size:1.1rem;font-weight:600;" required>
                        @error('title') <div class="form-error">✕ {{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><h3 style="font-family:var(--font-sans);font-size:0.9rem;font-weight:800;margin:0;">📋 Ringkasan</h3></div>
                <div class="card-body">
                    <textarea name="excerpt" class="form-control" rows="3" maxlength="500" placeholder="Tulis ringkasan singkat...">{{ old('excerpt', $post->excerpt) }}</textarea>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><h3 style="font-family:var(--font-sans);font-size:0.9rem;font-weight:800;margin:0;">📝 Konten Artikel *</h3></div>
                <div class="card-body">
                    <textarea name="content" id="content-editor" class="form-control" rows="20" required>{{ old('content', $post->content) }}</textarea>
                    @error('content') <div class="form-error">✕ {{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div style="display:flex;flex-direction:column;gap:1.25rem;position:sticky;top:88px;">

            <div class="card">
                <div class="card-header"><h3 style="font-family:var(--font-sans);font-size:0.9rem;font-weight:800;margin:0;">🚀 Publikasi</h3></div>
                <div class="card-body" style="display:flex;flex-direction:column;gap:0.75rem;">
                    <div class="form-group" style="margin:0;">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control">
                            <option value="draft" {{ old('status', $post->status) === 'draft' ? 'selected' : '' }}>📋 Draft</option>
                            <option value="published" {{ old('status', $post->status) === 'published' ? 'selected' : '' }}>✅ Published</option>
                        </select>
                    </div>
                    <label style="display:flex;align-items:center;gap:0.5rem;cursor:pointer;font-size:0.875rem;font-weight:500;">
                        <input type="checkbox" name="featured" value="1" {{ old('featured', $post->featured) ? 'checked' : '' }} style="accent-color:var(--brand);">
                        ⭐ Tandai sebagai unggulan
                    </label>
                    <div style="font-size:0.775rem;color:var(--text-muted);">
                        Dibuat: {{ $post->created_at->format('d M Y') }}<br>
                        Views: {{ number_format($post->views) }}
                    </div>
                    <div style="display:flex;gap:0.5rem;flex-direction:column;margin-top:0.25rem;">
                        <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
                        <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary" style="text-align:center;">Batal</a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><h3 style="font-family:var(--font-sans);font-size:0.9rem;font-weight:800;margin:0;">🏷️ Kategori</h3></div>
                <div class="card-body">
                    <select name="category_id" class="form-control">
                        <option value="">— Pilih Kategori —</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $post->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><h3 style="font-family:var(--font-sans);font-size:0.9rem;font-weight:800;margin:0;">🔖 Tags</h3></div>
                <div class="card-body">
                    <div style="display:flex;flex-wrap:wrap;gap:0.4rem;max-height:180px;overflow-y:auto;">
                        @php $selectedTags = old('tags', $post->tags->pluck('id')->toArray()); @endphp
                        @foreach($tags as $tag)
                        <label style="display:inline-flex;align-items:center;gap:0.3rem;padding:0.25rem 0.6rem;border-radius:var(--radius-full);border:1px solid {{ in_array($tag->id, $selectedTags) ? 'var(--brand)' : 'var(--border-color)' }};background:{{ in_array($tag->id, $selectedTags) ? 'var(--brand)' : 'transparent' }};color:{{ in_array($tag->id, $selectedTags) ? 'white' : 'var(--text-secondary)' }};font-size:0.775rem;cursor:pointer;transition:all 0.2s;" class="tag-label {{ in_array($tag->id, $selectedTags) ? 'tag-active' : '' }}">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}" style="display:none;"
                                   {{ in_array($tag->id, $selectedTags) ? 'checked' : '' }}
                                   onchange="this.closest('label').classList.toggle('tag-active', this.checked)">
                            #{{ $tag->name }}
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><h3 style="font-family:var(--font-sans);font-size:0.9rem;font-weight:800;margin:0;">🖼️ Thumbnail</h3></div>
                <div class="card-body">
                    @if($post->thumbnail)
                    <div style="border-radius:var(--radius-md);overflow:hidden;margin-bottom:0.75rem;">
                        <img id="thumb-img" src="{{ $post->thumbnail_url }}" alt="Thumbnail" style="width:100%;height:120px;object-fit:cover;">
                    </div>
                    @else
                    <div id="thumb-preview" style="display:none;border-radius:var(--radius-md);overflow:hidden;margin-bottom:0.75rem;">
                        <img id="thumb-img" src="" style="width:100%;height:120px;object-fit:cover;">
                    </div>
                    @endif
                    <input type="file" name="thumbnail" class="form-control" accept="image/*" onchange="previewThumb(this)">
                    <div class="form-hint">Kosongkan jika tidak ingin mengubah thumbnail.</div>
                </div>
            </div>
        </div>
    </div>
</form>

@push('styles')
<style>
.tag-label.tag-active { background:var(--brand) !important; border-color:var(--brand) !important; color:white !important; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
tinymce.init({
    selector: '#content-editor', height: 500, menubar: false,
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
        reader.onload = e => {
            const img = document.getElementById('thumb-img');
            const preview = document.getElementById('thumb-preview');
            img.src = e.target.result;
            if (preview) preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection
