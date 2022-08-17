<?php

namespace App\Listeners;

use App\Constants\ReferralConstants;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateReferralAccountForVerifiedUser
{
    /**
     * Handle the event.
     *
     * @param  Verified  $event
     * @return void
     */
    public function handle(Verified $event)
    {
        $event->user->makeReferralAccount(ReferralConstants::ACCOUNT_NAME);
    }
}
