<?php

namespace Database\Seeders;

use App\ProfileUser;
use Illuminate\Database\Seeder;

class ProfileUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProfileUser::create([
            'profile_id' => 1,
            'user_id' => 2
        ]);

        ProfileUser::create([
            'profile_id' => 2,
            'user_id' => 1
        ]);
    }
}
