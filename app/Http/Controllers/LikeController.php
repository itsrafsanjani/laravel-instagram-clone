<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\JsonResponse;

class LikeController extends Controller
{
    public function toggle(Post $post): JsonResponse
    {
        auth()->user()->toggleLike($post);

        return response()->json([
            'data' => [
                'likers_count' => $post->likers()->count(),
            ],
            'message' => 'Success!',
        ]);
    }
}
