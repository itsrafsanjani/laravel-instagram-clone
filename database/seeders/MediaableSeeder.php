<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Media;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MediaableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $articles = Article::all();

        $medias = Media::all();

        foreach ($articles as $article) {
            foreach ($medias as $media) {
                $article->medias()->attach($media->id);
            }
        }
    }
}
