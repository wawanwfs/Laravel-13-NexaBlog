<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['user', 'category'])->orderByDesc('created_at');

        if ($request->search) {
            $query->where('title', 'like', "%{$request->search}%");
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        $posts      = $query->paginate(15)->withQueryString();
        $categories = Category::all();

        return view('admin.posts.index', compact('posts', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $tags       = Tag::orderBy('name')->get();
        return view('admin.posts.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'excerpt'     => ['nullable', 'string', 'max:500'],
            'content'     => ['required', 'string'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'status'      => ['required', 'in:draft,published'],
            'featured'    => ['boolean'],
            'thumbnail'   => ['nullable', 'image', 'max:3072'],
            'tags'        => ['nullable', 'array'],
            'tags.*'      => ['exists:tags,id'],
        ]);

        $data['user_id'] = Auth::id();
        $data['slug']    = Str::slug($data['title']);
        $data['featured'] = $request->boolean('featured');

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        if ($data['status'] === 'published') {
            $data['published_at'] = now();
        }

        $post = Post::create($data);
        $post->tags()->sync($request->tags ?? []);

        return redirect()->route('admin.posts.index')
            ->with('toast_success', "Post \"{$post->title}\" berhasil dibuat!");
    }

    public function edit(Post $post)
    {
        $categories = Category::orderBy('name')->get();
        $tags       = Tag::orderBy('name')->get();
        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'excerpt'     => ['nullable', 'string', 'max:500'],
            'content'     => ['required', 'string'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'status'      => ['required', 'in:draft,published'],
            'featured'    => ['boolean'],
            'thumbnail'   => ['nullable', 'image', 'max:3072'],
            'tags'        => ['nullable', 'array'],
            'tags.*'      => ['exists:tags,id'],
        ]);

        $data['featured'] = $request->boolean('featured');

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        if ($data['status'] === 'published' && !$post->published_at) {
            $data['published_at'] = now();
        }

        $post->update($data);
        $post->tags()->sync($request->tags ?? []);

        return redirect()->route('admin.posts.index')
            ->with('toast_success', "Post \"{$post->title}\" berhasil diperbarui!");
    }

    public function destroy(Post $post)
    {
        $title = $post->title;
        $post->delete();
        return redirect()->route('admin.posts.index')
            ->with('toast_success', "Post \"{$title}\" berhasil dihapus.");
    }

    public function show(Post $post)
    {
        return redirect()->route('blog.show', $post->slug);
    }
}
