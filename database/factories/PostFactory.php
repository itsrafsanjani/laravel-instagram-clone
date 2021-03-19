<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'user_id' => random_int(1,10),
        'slug' => Str::random(12),
        'caption' => 'My first upload..',
        'image' => '/storage/uploads/QdpAZYcRxRFe06OvlEQKsSVD4DfL1hvf7AAzFxjA.jpg'
    ];
});
