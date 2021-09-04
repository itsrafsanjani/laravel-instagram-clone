<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    const PAGINATE_COUNT = 20;

    protected $guarded = [];

    protected $with = ['user'];

    public function getRouteKeyName()
    {
        return 'username';
    }

    public function followers()
    {
        return $this->belongsToMany(User::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->whereNotNull('email_verified_at');
    }

    public function profileImage()
    {
        $imageSize = 200;

        if (request()->is('profiles/*')) {
            $imageSize = 400;
        }

        return $this->image ?? 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($this->user->email ?? ''))) . '?s=' . $imageSize;
    }
}
