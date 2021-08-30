<?php

namespace App;

use BeyondCode\Comments\Traits\HasComments;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

class Post extends Model
{
    use HasFactory, HasComments, HasEagerLimit;

    const PAGINATE_COUNT = 20;

    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class)->where('status', 1);
    }

    public function isLikedBy(User $user): bool
    {
        return (bool)$user->likes
            ->where('post_id', $this->id)
            ->all();
    }

    public function image()
    {
        return $this->image;
    }
}
