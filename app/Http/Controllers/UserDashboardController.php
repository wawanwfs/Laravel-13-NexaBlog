<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $recentPosts = Post::with('category')
            ->published()
            ->orderByDesc('published_at')
            ->take(5)
            ->get();

        $stats = [
            'comments' => $user->comments()->count(),
        ];

        return view('user.dashboard', compact('user', 'recentPosts', 'stats'));
    }
}
