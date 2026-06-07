<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index()
    {
        $pending  = Comment::with(['user', 'post'])->pending()->orderByDesc('created_at')->paginate(10, ['*'], 'pending');
        $approved = Comment::with(['user', 'post'])->approved()->orderByDesc('created_at')->paginate(10, ['*'], 'approved');
        return view('admin.comments.index', compact('pending', 'approved'));
    }

    public function approve(Comment $comment)
    {
        $comment->update(['is_approved' => true]);
        return back()->with('toast_success', 'Komentar berhasil disetujui.');
    }

    public function reject(Comment $comment)
    {
        $comment->delete();
        return back()->with('toast_success', 'Komentar berhasil dihapus.');
    }
}
