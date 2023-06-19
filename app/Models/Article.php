<?php

namespace App\Models;

use BeyondCode\Comments\Traits\HasComments;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JordanMiguel\LaravelPopular\Traits\Visitable;
use Overtrue\LaravelLike\Traits\Likeable;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

class Article extends Model
{
    use HasFactory, HasComments, HasEagerLimit, Visitable, Likeable, Loggable;

    protected $table = 'posts';

    protected $fillable = [
        'user_id',
        'slug',
        'caption',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the medias for the post.
     */
    public function medias()
    {
        return $this->morphToMany(Media::class, 'mediaable');
    }
}
