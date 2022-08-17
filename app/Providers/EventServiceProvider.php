<?php

namespace App\Providers;

use App\Listeners\CreateReferralAccountForVerifiedUser;
use App\Listeners\FollowedListener;
use App\Listeners\UnfollowedListener;
use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Overtrue\LaravelFollow\Events\Followed;
use Overtrue\LaravelFollow\Events\Unfollowed;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        Verified::class => [
            CreateReferralAccountForVerifiedUser::class,
        ],
        Followed::class => [
            FollowedListener::class,
        ],
        Unfollowed::class => [
            UnfollowedListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        User::observe(UserObserver::class);

        //
    }
}
