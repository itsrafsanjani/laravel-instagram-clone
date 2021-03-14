<?php

use App\Post;
use Illuminate\Database\Seeder;

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
            'caption' => 'Rafsan: My first upload..',
            'image' => '/storage/uploads/QdpAZYcRxRFe06OvlEQKsSVD4DfL1hvf7AAzFxjA.jpg'
        ]);

        Post::create([
            'user_id' => 2,
            'caption' => 'Alia: My first upload..',
            'image' => '/storage/uploads/QdpAZYcRxRFe06OvlEQKsSVD4DfL1hvf7AAzFxjA.jpg'
        ]);
    }
}
