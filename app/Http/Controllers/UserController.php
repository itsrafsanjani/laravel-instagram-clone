<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Sightengine\SightengineClient;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('media');

        if ($request->has('q')) {
            $query->where('username', 'like', '%' . $request->q . '%')
                ->orWhere('name', 'like', '%' . $request->q . '%');
        }

        return view('users.index', [
            'users' => $query->paginate(User::PAGINATE_COUNT),
            'query' => $request->q
        ]);
    }

    public function show(User $user)
    {
        auth()->user()->attachFollowStatus($user);

        $user->loadCount(['posts', 'followers', 'followings']);

        $user->load('posts.media');

        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return view('users.edit', compact('user'));
    }

    public function update(User $user, UpdateUserRequest $request)
    {
        $this->authorize('update', $user);

        if (! empty($request->password)) {
            $request->merge(['password' => bcrypt($request->password)]);
        }

        $user->update($request->validated() + [
                $request->password
            ]);

        if (! empty($request->avatar)) {
            $user->addMediaFromRequest('avatar')->toMediaCollection('avatars');
        }

        return redirect()->route('users.show', $user)->with([
            'status' => 'success',
            'message' => 'Profile updated successfully!'
        ]);
    }

    public function followings(User $user)
    {
        $users = $user->followings()->paginate(User::PAGINATE_COUNT);

        return view('users.followings', compact('users'));
    }

    public function followers(User $user)
    {
        $users = $user->followers()->paginate(User::PAGINATE_COUNT);

        return view('users.followers', compact('users'));
    }
}
