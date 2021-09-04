<?php

namespace Database\Seeders;

use App\Like;
use App\Post;
use App\Models\Profile;
use App\Models\ProfileUser;
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
        $this->call(UserSeeder::class);
        $this->call(PostSeeder::class);
        $this->call(ProfileUserSeeder::class);
        User::factory()->count(10)->create();
        Post::factory()->count(10)->create();

        echo "ProfileUser Pivot Data Seeding.. \n";

        $users = User::count();
        $profiles = Profile::count();

        for ($i = 1; $i <= $profiles; $i++) {
            for ($j = 1; $j <= $users; $j++) {
                if ($i != $j) {
                    ProfileUser::updateOrCreate([
                        'profile_id' => $i,
                        'user_id' => $j
                    ]);
                }
            }
        }

        echo "Like Data Seeding.. \n";

        $posts = Post::count();

        for ($i = 1; $i <= $posts; $i++) {
            for ($j = 1; $j <= $users; $j++) {
                Like::updateOrCreate([
                    'post_id' => $i,
                    'user_id' => $j,
                    'status' => 1
                ]);
            }
        }
    }
}
