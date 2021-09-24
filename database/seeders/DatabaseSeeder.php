<?php

namespace Database\Seeders;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
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
        $this->call(VoyagerDatabaseSeeder::class);
        User::factory()->count(10)->create();
        Post::factory()->count(10)->create();

        $posts = Post::select('id')->get();

        foreach ($posts as $post) {
            $post->addMediaFromUrl('https://via.placeholder.com/1080x1080')
                ->toMediaCollection('posts');
        }
    }
}
