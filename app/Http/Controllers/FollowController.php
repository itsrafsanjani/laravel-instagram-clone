<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class FollowController extends Controller
{
    /**
     * @param  User  $user
     * @return JsonResponse
     */
    public function toggle(User $user): JsonResponse
    {
        auth()->user()->toggleFollow($user);

        return response()->json([
            'message' => 'Success!',
            'data' => [
                'followers_count' => $user->followers()->count(),
            ],
        ]);
    }

    /**
     * @param  User  $user
     * @return Application|Factory|View
     */
    public function followings(User $user)
    {
        $users = $user->followings()->paginate(User::PAGINATE_COUNT);

        return view('users.followings', compact('users'));
    }

    /**
     * @param  User  $user
     * @return Application|Factory|View
     */
    public function followers(User $user)
    {
        $users = $user->followers()->paginate(User::PAGINATE_COUNT);

        return view('users.followers', compact('users'));
    }
}
