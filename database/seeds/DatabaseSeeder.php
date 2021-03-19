<?php

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
//         $this->call(UserSeeder::class);
//         $this->call(PostSeeder::class);
        factory(\App\User::class, 10)->create();
        factory(\App\Post::class, 10)->create();
    }
}
