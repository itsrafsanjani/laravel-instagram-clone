<?php

namespace App\Http\Controllers;

use App\Profile;
use App\User;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    public function index()
    {
        $profiles = Profile::with('user', 'followers')->paginate(10);
        return view('profiles.index', compact('profiles'));
    }

    public function show(User $user)
    {
        $follows = (auth()->user()) ? auth()->user()->following->contains($user->id) : false;

        $postCount = $user->posts->count();

        $followersCount = $user->profile->followers->count();

        $followingCount = $user->following->count();

        return view('profiles.show', compact('user', 'follows', 'postCount', 'followersCount', 'followingCount'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user->profile);

        return view('profiles.edit', compact('user'));
    }

    public function update(User $user)
    {
        $this->authorize('update', $user->profile);

        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'url' => 'url',
            'image' => '',
        ]);

        if (request('image')) {
            $imagePath = request('image')->store('profile', 'public');

            $image = Image::make(public_path("/storage/{$imagePath}"))->fit(1080, 1080, function ($constraint) {
                $constraint->upsize();
            });

            $oldProfileImage = public_path($user->profile->image);

            $image->save();

            $imageArray = ['image' => '/storage/' . $imagePath];

            if (file_exists($oldProfileImage)) {
                @unlink($oldProfileImage);
            }
        }

        auth()->user()->profile->update(array_merge(
            $data,
            $imageArray ?? []
        ));

        return redirect()->route('profiles.show', $user);
    }
}
