<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentAPIController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'comment_text' => 'required|string',
            'content_id' => 'required|exists:contents,id',
            'rating' => 'nullable|integer|min:1|max:5'
        ]);
        $currentUser = Auth::user();
        $comment = Comment::updateOrCreate(
            [
                'user_id' => $currentUser->id,
                'content_id' => $validatedData['content_id'] // Cari berdasarkan user & content
            ],
            [
                'comment_text' => $validatedData['comment_text'],
                'rating' => $validatedData['rating'] ?? 0 // Default ke 0 jika null
            ]
        );
        return response()->json([
            'message' => 'Success',
            'data' => $comment
        ]);
    }
}
