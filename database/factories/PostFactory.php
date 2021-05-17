<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random()->id,
        'slug' => Str::random(12),
        'caption' => 'My first upload..',
        'image' => '/storage/uploads/image.jpg'
    ];
});
