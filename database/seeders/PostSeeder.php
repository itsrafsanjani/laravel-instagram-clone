<?php

namespace Database\Seeders;

use App\Post;
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
            'image' => '/storage/uploads/image.jpg'
        ]);

        Post::create([
            'user_id' => 2,
            'slug' => Str::random(12),
            'caption' => 'Alia: My first upload..',
            'image' => '/storage/uploads/image.jpg'
        ]);
    }
}
