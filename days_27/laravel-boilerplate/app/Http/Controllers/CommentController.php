<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $postId)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        Comment::create([
            'post_id' => $postId,
            'user_id' => auth()->id(),
            'name' => auth()->user()->name,
            'body' => $request->body,
        ]);

        return redirect()->route('posts.show', $postId)->with('success', 'Komentar berhasil ditambahkan.');
    }

    public function destroy($commentId)
    {
        $comment = Comment::findOrFail($commentId);
        if (Auth::user()->id !== $comment->user_id && !(Auth::user()->roles->pluck('name')->contains('administrator'))) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menghapus komentar ini.');
        }

        $comment->delete();
        return redirect()->back()->with('success', 'Komentar berhasil dihapus.');
    }
}
