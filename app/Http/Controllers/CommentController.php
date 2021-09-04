<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'comment' => 'required'
        ]);

        $post = Post::where('slug', $request->post_slug)->firstOrFail();

        $comment = $post->commentAsUser(auth()->user(), $request->comment);

        return response()->json([
            'data' => $comment,
            'message' => 'Comment added successfully!',
            'type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Comment $comment
     * @return JsonResponse
     */
    public function destroy(Comment $comment): JsonResponse
    {
        $comment->delete();

        return response()->json([
            'message' => 'Comment deleted successfully!',
            'type' => 'success'
        ]);
    }
}
