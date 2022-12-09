<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Artesaos\SEOTools\Facades\SEOTools;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class UserController extends Controller
{
    /**
     * @param  Request  $request
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $query = User::with('media');

        if ($request->has('q')) {
            $query->where('username', 'like', '%'.$request->q.'%')
                ->orWhere('name', 'like', '%'.$request->q.'%');
        }

        return view('users.index', [
            'users' => $query->paginate(User::PAGINATE_COUNT),
            'query' => $request->q,
        ]);
    }

    /**
     * @param  User  $user
     * @return Application|Factory|View
     */
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

    /**
     * @param  User  $user
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return view('users.edit', compact('user'));
    }

    /**
     * @param $user
     * @param $request
     * @return array|string[]
     */
    public function usernameUpdateConditions($user, $request)
    {
        $info = [
            'status' => 'error',
        ];

        // Check if username update attempts is less than 2
        if ($user->username_update_attempts < 2) {
            $user->update($request->validated());

            // Check if username was changed
            if ($user->wasChanged('username')) {
                $user->increment('username_update_attempts');
                $user->username_last_updated_at = now();
                $user->save();

                $info = [
                    'status' => 'success',
                ];
            }
        } else {
            // Check if it has been more than 14 days since the last username update
            if (Carbon::parse($user->username_last_updated_at)->addDays(14) < now()) {
                $user->update($request->validated());

                // Check if username was changed
                if ($user->wasChanged('username')) {
                    $user->username_update_attempts = 0;
                    $user->username_last_updated_at = now();
                    $user->save();

                    $info = [
                        'status' => 'success',
                    ];
                }
            } else {
                // Update user's other fields, but not the username
                $user->update($request->safe()->except('username'));
            }
        }

        return $info;
    }

    /**
     * @param  User  $user
     * @param  UpdateUserRequest  $request
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function update(User $user, UpdateUserRequest $request)
    {
        $this->authorize('update', $user);

        $info = $this->usernameUpdateConditions($user, $request);

        $message = 'Profile updated successfully!';
        if ($info['status'] == 'error') {
            $message = 'Profile updated but username update limit exceeded in last 14 days!';
        }

        if (! empty($request->avatar)) {
            $user->addMediaFromRequest('avatar')->toMediaCollection('avatars');
        }

        return redirect()->route('users.show', $user)->with([
            'status' => 'success',
            'message' => $message,
        ]);
    }
}
