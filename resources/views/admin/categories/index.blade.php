@extends('layouts.admin')
@section('title', 'Kelola Kategori')

@section('page-header')
<div style="display:flex;align-items:center;justify-content:space-between;">
    <div>
        <h1 style="font-size:1.5rem;font-weight:900;margin:0;">🏷️ Kelola Kategori</h1>
        <p style="color:var(--text-muted);font-size:0.875rem;margin:0.25rem 0 0;">{{ $categories->total() }} kategori terdaftar</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">✚ Tambah Kategori</a>
</div>
@endsection

@section('content')
<div class="card">
    <div class="table-wrapper" style="border:none;border-radius:0;">
        <table class="table">
            <thead>
                <tr>
                    <th>Kategori</th>
                    <th>Deskripsi</th>
                    <th>Total Posts</th>
                    <th>Published</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:0.75rem;">
                            <div style="width:12px;height:12px;border-radius:50%;background:{{ $category->color }};flex-shrink:0;box-shadow:0 0 0 3px {{ $category->color }}30;"></div>
                            <div>
                                <div style="font-weight:700;">{{ $category->name }}</div>
                                <div style="font-size:0.75rem;color:var(--text-muted);">{{ $category->slug }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="color:var(--text-secondary);font-size:0.875rem;max-width:250px;">{{ Str::limit($category->description, 80) ?: '—' }}</td>
                    <td><span class="badge badge-gray">{{ $category->posts_count }}</span></td>
                    <td><span class="badge badge-success">{{ $category->published_posts_count }}</span></td>
                    <td>
                        <div style="display:flex;gap:0.375rem;">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-secondary btn-sm">✏️ Edit</a>
                            <a href="{{ route('blog.category', $category->slug) }}" class="btn btn-secondary btn-sm" target="_blank">👁</a>
                            @if($category->posts_count === 0)
                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" id="del-cat-{{ $category->id }}" style="margin:0;">
                                @csrf @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('del-cat-{{ $category->id }}', '{{ $category->name }}')">🗑</button>
                            </form>
                            @else
                            <span class="btn btn-secondary btn-sm" style="opacity:0.4;cursor:not-allowed;" title="Tidak bisa dihapus, masih ada {{ $category->posts_count }} post">🗑</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;padding:3rem;color:var(--text-muted);">
                        <span style="font-size:2.5rem;">🏷️</span>
                        <p style="margin-top:0.5rem;">Belum ada kategori. <a href="{{ route('admin.categories.create') }}" style="color:var(--brand);">Buat sekarang →</a></p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($categories->hasPages())
    <div class="card-footer">
        <div class="pagination" style="margin-top:0;">
            @foreach($categories->getUrlRange(1, $categories->lastPage()) as $page => $url)
            @if($page == $categories->currentPage())
            <span class="page-btn active">{{ $page }}</span>
            @else
            <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
            @endif
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
