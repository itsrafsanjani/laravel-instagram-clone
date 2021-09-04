<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;

class FollowController extends Controller
{
    public function toggle($username): JsonResponse
    {
        $user = User::where('username', $username)
            ->with(['profile' => function ($query) {
                $query->withCount('followers');
            }])
            ->withCount('following')->withCount('following')->first();

        $response = auth()->user()->following()->toggle($user);

        if (count($response['attached']) > 0) {
            $response['buttonText'] = 'Unfollow';
        } else {
            $response['buttonText'] = 'Follow';
        }

        return response()->json([
            'data' => $response,
            'following_count' => $user->following_count,
            'followers_count' => $user->profile->followers_count,
            'message' => 'Success!'
        ]);
    }
}
