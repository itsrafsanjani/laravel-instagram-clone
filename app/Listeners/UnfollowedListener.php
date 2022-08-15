<?php

namespace App\Listeners;

use App\Models\User;
use Overtrue\LaravelFollow\Events\Unfollowed;

class UnfollowedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Unfollowed  $event
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Unfollowed $event)
    {
        // $user = User::findOrFail($event->followingId);
        //
        // $user->notifications()
        //     ->where('type', 'App\Notifications\FollowedNotification')
        //     ->where('data->follower->id', $event->followerId)->delete();
    }
}
