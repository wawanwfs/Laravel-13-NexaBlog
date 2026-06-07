@extends('layouts.admin')
@section('title', 'Edit Kategori')

@section('page-header')
<div style="display:flex;align-items:center;gap:1rem;">
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary btn-sm">← Kembali</a>
    <h1 style="font-size:1.5rem;font-weight:900;margin:0;">✏️ Edit Kategori</h1>
</div>
@endsection

@section('content')
<div class="container-sm" style="max-width:560px;padding:0;">
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.categories.update', $category) }}">
                @csrf @method('PUT')

                <div class="form-group">
                    <label class="form-label">Nama Kategori *</label>
                    <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                           value="{{ old('name', $category->name) }}" required autofocus>
                    @error('name') <div class="form-error">✕ {{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Warna Label</label>
                    <div style="display:flex;align-items:center;gap:0.75rem;">
                        <input type="color" name="color" id="colorPicker" value="{{ old('color', $category->color) }}"
                               style="width:48px;height:40px;border-radius:var(--radius-md);border:2px solid var(--border-color);cursor:pointer;padding:2px;">
                        <input type="text" id="colorText" value="{{ old('color', $category->color) }}"
                               class="form-control" style="width:120px;font-family:var(--font-mono);font-size:0.875rem;"
                               onchange="document.getElementById('colorPicker').value=this.value;updatePreview();">
                        <div style="display:flex;gap:0.375rem;">
                            @foreach(['#6366f1','#ec4899','#f59e0b','#10b981','#3b82f6','#ef4444','#8b5cf6','#06b6d4'] as $c)
                            <div onclick="setColor('{{ $c }}')" style="width:28px;height:28px;border-radius:50%;background:{{ $c }};cursor:pointer;transition:transform 0.15s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'"></div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div style="padding:1rem;background:var(--bg-secondary);border-radius:var(--radius-md);border:1px solid var(--border-color);margin-bottom:1.5rem;">
                    <div style="font-size:0.8rem;font-weight:700;color:var(--text-muted);margin-bottom:0.5rem;text-transform:uppercase;">Preview:</div>
                    <span id="badge-preview" class="badge" style="background:{{ $category->color }};color:white;font-size:0.875rem;padding:0.35rem 0.875rem;">
                        {{ $category->name }}
                    </span>
                </div>

                <div style="display:flex;gap:0.75rem;">
                    <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
const colorPicker = document.getElementById('colorPicker');
const colorText = document.getElementById('colorText');
const badgePreview = document.getElementById('badge-preview');
const nameInput = document.querySelector('input[name="name"]');

colorPicker.addEventListener('input', function() { colorText.value = this.value; updatePreview(); });
nameInput.addEventListener('input', function() { badgePreview.textContent = this.value || '{{ $category->name }}'; });
function setColor(c) { colorPicker.value = c; colorText.value = c; updatePreview(); }
function updatePreview() { badgePreview.style.background = colorPicker.value; }
</script>
@endsection
