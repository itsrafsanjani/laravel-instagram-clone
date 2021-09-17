<?php

namespace App\Models;

use BeyondCode\Comments\Traits\HasComments;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JordanMiguel\LaravelPopular\Traits\Visitable;
use Overtrue\LaravelLike\Traits\Likeable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

class Post extends Model implements HasMedia
{
    use HasFactory, HasComments, HasEagerLimit, Visitable, Likeable, InteractsWithMedia;

    const PAGINATE_COUNT = 18;
    const POPULAR_BY_DAY = 3;

    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function image()
    {
        return $this->image;
    }
}
