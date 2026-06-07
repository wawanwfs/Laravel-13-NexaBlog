<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['user', 'category'])
            ->published()
            ->orderByDesc('published_at');

        // Filter by category
        if ($request->category) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        // Filter by tag
        if ($request->tag) {
            $query->whereHas('tags', fn($q) => $q->where('slug', $request->tag));
        }

        // Search
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $posts      = $query->paginate(9)->withQueryString();
        $categories = Category::withCount(['publishedPosts'])->get();
        $tags       = Tag::withCount('posts')->orderByDesc('posts_count')->take(20)->get();

        $selectedCategory = $request->category;
        $selectedTag      = $request->tag;
        $searchQuery      = $request->search;

        return view('blog.index', compact('posts', 'categories', 'tags', 'selectedCategory', 'selectedTag', 'searchQuery'));
    }

    public function show(string $slug)
    {
        $post = Post::with(['user', 'category', 'tags', 'approvedComments.user'])
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        $post->incrementViews();

        $relatedPosts = Post::with(['user', 'category'])
            ->published()
            ->where('id', '!=', $post->id)
            ->where(function ($q) use ($post) {
                if ($post->category_id) {
                    $q->where('category_id', $post->category_id);
                }
            })
            ->orderByDesc('published_at')
            ->take(3)
            ->get();

        return view('blog.show', compact('post', 'relatedPosts'));
    }

    public function category(string $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $posts = Post::with(['user', 'category'])
            ->published()
            ->where('category_id', $category->id)
            ->orderByDesc('published_at')
            ->paginate(9);

        $categories = Category::withCount(['publishedPosts'])->get();

        return view('blog.category', compact('posts', 'category', 'categories'));
    }

    public function storeComment(Request $request, Post $post)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('toast_info', 'Silakan login untuk memberikan komentar.');
        }

        $request->validate([
            'content' => ['required', 'string', 'min:5', 'max:1000'],
        ]);

        Comment::create([
            'post_id'     => $post->id,
            'user_id'     => Auth::id(),
            'content'     => $request->content,
            'is_approved' => false,
        ]);

        return back()->with('toast_success', 'Komentar berhasil dikirim dan menunggu moderasi.');
    }
}
