<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
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
        return $this->hasMany(Like::class);
    }

    public function isLikedBy(User $user): bool
    {
        return (bool)$user->likes
            ->where('post_id', $this->id)
            ->all();
    }

    public function image()
    {
        return str_replace('/upload/', '/upload/w_400,h_400,c_fill,g_faces/', $this->image);
    }
}
