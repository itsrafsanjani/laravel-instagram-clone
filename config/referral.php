<?php

return [
    // If you want to overwrite the previous referrals with the latest.
    'overwrite_previous_referral' => true,

    // The length of the referral code that users can share
    'code_length' => 5,

    // Referral cookie name
    'cookie_name' => 'referral', //note, when you change this, all previous referrals will be invalid

    // Clear the cookie when the referral is handled.
    'clear_cookie_on_referral' => false,

    // Cookie duration
    'cookie_duration' => Famdirksen\LaravelReferral\Duration\CookieDurationForever::class,
    //'cookie_duration' => Famdirksen\LaravelReferral\Duration\CookieDurationYear::class,
    //'cookie_duration' => Famdirksen\LaravelReferral\Duration\CookieDurationMonth::class,
    
    // The domains to set the cookie
    'cookie_domains' => [],
];
