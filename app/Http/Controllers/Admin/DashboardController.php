<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'posts'      => Post::count(),
            'published'  => Post::published()->count(),
            'drafts'     => Post::where('status', 'draft')->count(),
            'users'      => User::count(),
            'categories' => Category::count(),
            'comments'   => Comment::count(),
            'pending'    => Comment::pending()->count(),
            'views'      => Post::sum('views'),
        ];

        $recentPosts = Post::with(['user', 'category'])
            ->orderByDesc('created_at')
            ->take(8)
            ->get();

        $pendingComments = Comment::with(['user', 'post'])
            ->pending()
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        $topPosts = Post::with('category')
            ->published()
            ->orderByDesc('views')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentPosts', 'pendingComments', 'topPosts'));
    }
}
