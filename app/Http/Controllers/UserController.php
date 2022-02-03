<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Artesaos\SEOTools\Facades\SEOTools;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        SEOTools::setTitle($user->username);
        SEOTools::setDescription($user->name);
        SEOTools::setCanonical(route('users.show', $user));
        SEOTools::opengraph()->setUrl(route('users.show', $user));
        SEOTools::opengraph()->addProperty('type', 'website');
        SEOTools::opengraph()->addImage($user->avatar);
        SEOTools::twitter()->setSite($user->name);
        SEOTools::twitter()->setType('summary_large_image');
        SEOTools::jsonLd()->addImage($user->avatar);

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

    public function usernameUpdateConditions($user, $request)
    {
        $info = [];
        if ($user->username_update_attempts < 2) {
            $user->update($request->validated() + [
                    $request->password
                ]);
            if ($user->wasChanged('username')) {
                $user->increment('username_update_attempts');
                $user->username_last_updated_at = now();
                $user->save();

                $info = [
                    'status' => 'success',
                ];
            }
        } else if (Carbon::parse($user->username_last_updated_at)->addDays(14) < now()) {
            $user->update($request->validated() + [
                    $request->password
                ]);
            if ($user->wasChanged('username')) {
                $user->username_update_attempts = 0;
                $user->username_last_updated_at = now();
                $user->save();

                $info = [
                    'status' => 'success',
                ];
            }
        } else if (Carbon::parse($user->username_last_updated_at)->addDays(14) > now()) {
            $user->update($request->safe()->except('username') + [
                    $request->password
                ]);
            $info = [
                'status' => 'error',
            ];
        }

        return $info;
    }

    public function update(User $user, UpdateUserRequest $request)
    {
        $this->authorize('update', $user);

        if (!empty($request->password)) {
            $request->merge(['password' => bcrypt($request->password)]);
        }

        // TODO: Clear Logic
        $info = $this->usernameUpdateConditions($user, $request);

        $message = 'Profile updated successfully!';
        if ($info['status'] == 'error') {
            $message = 'Profile updated but username update limit exceeded in last 14 days!';
        }

        if (!empty($request->avatar)) {
            $user->addMediaFromRequest('avatar')->toMediaCollection('avatars');
        }

        return redirect()->route('users.show', $user)->with([
            'status' => 'success',
            'message' => $message
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
