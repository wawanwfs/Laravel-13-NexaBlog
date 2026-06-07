<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;

class LandingController extends Controller
{
    public function index()
    {
        $latestPosts = Post::with(['user', 'category'])
            ->published()
            ->orderByDesc('published_at')
            ->take(6)
            ->get();

        $featuredPosts = Post::with(['user', 'category'])
            ->published()
            ->featured()
            ->orderByDesc('published_at')
            ->take(3)
            ->get();

        $categories = Category::withCount(['publishedPosts'])
            ->orderByDesc('published_posts_count')
            ->take(6)
            ->get();

        $stats = [
            'posts'   => Post::published()->count(),
            'authors' => User::whereHas('posts', fn($q) => $q->published())->count(),
            'categories' => Category::has('publishedPosts')->count(),
            'readers' => User::where('role', 'user')->count() + 1000, // cosmetic
        ];

        return view('landing.index', compact('latestPosts', 'featuredPosts', 'categories', 'stats'));
    }

    public function about()
    {
        return view('static.about');
    }

    public function privacy()
    {
        return view('static.privacy');
    }

    public function terms()
    {
        return view('static.terms');
    }

    public function contact()
    {
        return view('static.contact');
    }

    public function sendContact(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
        ]);

        return back()->with('toast_success', 'Pesan Anda berhasil dikirim! Kami akan menghubungi Anda segera.');
    }
}
