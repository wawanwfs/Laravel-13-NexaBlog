<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::withCount('posts')->orderBy('name')->paginate(20);
        return view('admin.tags.index', compact('tags'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:50', 'unique:tags'],
        ]);
        $data['slug'] = Str::slug($data['name']);
        Tag::create($data);
        return back()->with('toast_success', "Tag \"{$data['name']}\" berhasil ditambahkan!");
    }

    public function destroy(Tag $tag)
    {
        $name = $tag->name;
        $tag->delete();
        return back()->with('toast_success', "Tag \"{$name}\" berhasil dihapus.");
    }

    public function create() { return redirect()->route('admin.tags.index'); }
    public function show(Tag $tag) { return redirect()->route('admin.tags.index'); }
    public function edit(Tag $tag) { return redirect()->route('admin.tags.index'); }
    public function update(Request $request, Tag $tag) { return redirect()->route('admin.tags.index'); }
}
