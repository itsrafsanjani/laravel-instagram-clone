<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(PostSeeder::class);

        /**
         * User::factory()->count(10)->create();
         * Post::factory()->count(10)->create();
         */
        $posts = Post::select('id')->get();

        foreach ($posts as $post) {
            $post->addMediaFromUrl('https://api.lorem.space/image?w=1080&h=1080')
                ->toMediaCollection('posts');
        }
    }
}
