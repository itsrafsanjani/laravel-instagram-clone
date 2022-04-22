<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::create([
            'user_id' => 1,
            'slug' => Str::random(12),
            'caption' => 'Rafsan: My first upload..',
        ]);

        Post::create([
            'user_id' => 1,
            'slug' => Str::random(12),
            'caption' => 'Rafsan: My second upload..',
        ]);

        Post::create([
            'user_id' => 2,
            'slug' => Str::random(12),
            'caption' => 'Alia: My first upload..',
        ]);

        Post::create([
            'user_id' => 2,
            'slug' => Str::random(12),
            'caption' => 'Alia: My second upload..',
        ]);

        Post::create([
            'user_id' => 3,
            'slug' => Str::random(12),
            'caption' => 'Admin: My first upload..',
        ]);

        Post::create([
            'user_id' => 3,
            'slug' => Str::random(12),
            'caption' => 'Admin: My second upload..',
        ]);

        Post::create([
            'user_id' => 4,
            'slug' => Str::random(12),
            'caption' => 'User: My first upload..',
        ]);

        Post::create([
            'user_id' => 4,
            'slug' => Str::random(12),
            'caption' => 'User: My second upload..',
        ]);
    }
}
