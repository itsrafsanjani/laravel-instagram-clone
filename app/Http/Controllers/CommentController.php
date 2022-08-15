<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'comment' => ['required', 'max:2200'],
        ]);

        $post = Post::where('slug', $request->post_slug)->firstOrFail();

        $comment = $post->commentAsUser(auth()->user(), $request->comment);

        return view('comments._single-comment', compact('comment', 'post'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Comment  $comment
     * @return JsonResponse
     */
    public function destroy(Comment $comment): JsonResponse
    {
        $comment->delete();

        return response()->json([
            'message' => 'Comment deleted successfully!',
            'type' => 'success',
        ]);
    }
}
