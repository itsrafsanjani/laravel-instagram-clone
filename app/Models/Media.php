<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use HasFactory;

    protected $table = 'medias';

    protected $appends = [
        'url',
    ];

    protected $fillable = [
        'file_name',
        'mime_type',
        'disk',
        'size',
        'path',
    ];

    protected $casts = [
        'size' => 'integer',
    ];

    public function getUrlAttribute()
    {
        return Storage::disk($this->disk)->url($this->path);
    }

    /**
     * Get all of the articles that are assigned this media.
     */
    public function articles()
    {
        return $this->morphedByMany(Article::class, 'mediaable');
    }
}
