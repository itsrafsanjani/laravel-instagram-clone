<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\FollowedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Overtrue\LaravelFollow\Events\Followed;

class FollowedListener
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
     * @param Followed $event
     * @return int
     */
    public function handle(Followed $event)
    {
        $user = User::findOrFail($event->followingId);

        $user->notify(new FollowedNotification($event->followingId, $event->followerId));
    }
}
