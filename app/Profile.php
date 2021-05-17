<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $guarded = [];

    protected $with = ['user'];

    public function getRouteKeyName()
    {
        return 'username';
    }

    public function profileImage()
    {
        $imageSize = 200;

        if (request()->is('profiles/*')) {
            $imageSize = 400;
        }

        $imagePath = $this->image ?? 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($this->user->email))) . '?s=' . $imageSize;

        return $imagePath;
    }

    public function followers()
    {
        return $this->belongsToMany(User::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
