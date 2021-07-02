<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $user = User::where('username', $request->username)->first();

        $response = auth()->user()->following()->toggle($user);

        if (count($response['attached']) > 0) {
            $response['buttonText'] = 'Unfollow';
        } else {
            $response['buttonText'] = 'Follow';
        }

        return response()->json([
            'data' => $response,
            'message' => 'Success!'
        ]);
    }
}
