<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;

class FollowController extends Controller
{
    public function toggle(User $user): JsonResponse
    {
        auth()->user()->toggleFollow($user);

        return response()->json([
            'message' => 'Success!',
            'data' => [
                'followers_count' => $user->followers()->count(),
            ]
        ]);
    }
}
