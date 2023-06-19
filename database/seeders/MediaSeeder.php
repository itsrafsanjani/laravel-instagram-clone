<?php

namespace Database\Seeders;

use App\Models\Media;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $medias = [
            [
                'file_name' => 'Big Buck Bunny.jpg',
                'mime_type' => 'image/jpeg',
                'disk' => 'public',
                'size' => 500 * 1024,
            ],
            [
                'file_name' => 'Teach Yourself C++.pdf',
                'mime_type' => 'application/pdf',
                'disk' => 'public',
                'size' => 20 * 1024 * 1024,
            ],
            [
                'file_name' => 'Big Buck Bunny.mp4',
                'mime_type' => 'video/mp4',
                'disk' => 'public',
                'size' => 100 * 1024 * 1024,
            ],
            [
                'file_name' => 'Big Buck Bunny.mp3',
                'mime_type' => 'audio/mpeg',
                'disk' => 'public',
                'size' => 10 * 1024 * 1024,
            ],
        ];

        foreach ($medias as $media) {
            Media::create($media);
        }
    }
}
