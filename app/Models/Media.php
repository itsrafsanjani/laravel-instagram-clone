<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $table = 'medias';

    protected $fillable = [
        'file_name',
        'mime_type',
        'disk',
        'size',
    ];

    protected $casts = [
        'size' => 'integer',
    ];

    /**
     * Get all of the articles that are assigned this media.
     */
    public function articles()
    {
        return $this->morphedByMany(Article::class, 'mediaable');
    }
}
