<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount(['posts', 'publishedPosts'])->orderBy('name')->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:100', 'unique:categories'],
            'description' => ['nullable', 'string', 'max:500'],
            'color'       => ['nullable', 'string', 'regex:/^#[0-9a-fA-F]{6}$/'],
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['color'] = $data['color'] ?? '#6366f1';

        Category::create($data);

        return redirect()->route('admin.categories.index')
            ->with('toast_success', "Kategori \"{$data['name']}\" berhasil dibuat!");
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:100', 'unique:categories,name,' . $category->id],
            'description' => ['nullable', 'string', 'max:500'],
            'color'       => ['nullable', 'string', 'regex:/^#[0-9a-fA-F]{6}$/'],
        ]);

        $data['slug'] = Str::slug($data['name']);
        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('toast_success', "Kategori \"{$category->name}\" berhasil diperbarui!");
    }

    public function destroy(Category $category)
    {
        $name = $category->name;
        $category->delete();
        return redirect()->route('admin.categories.index')
            ->with('toast_success', "Kategori \"{$name}\" berhasil dihapus.");
    }

    public function show(Category $category)
    {
        return redirect()->route('admin.categories.index');
    }
}
