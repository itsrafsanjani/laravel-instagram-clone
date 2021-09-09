<?php

namespace App\Models;

use BeyondCode\Comments\Contracts\Commentator;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Overtrue\LaravelFollow\Followable;
use Overtrue\LaravelLike\Traits\Liker;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

class User extends \TCG\Voyager\Models\User implements MustVerifyEmail, Commentator
{
    use HasFactory, Notifiable, HasEagerLimit, Followable, Liker;

    const PAGINATE_COUNT = 20;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'email',
        'phone_number',
        'phone_number_verified_at',
        'otp',
        'otp_created_at',
        'website',
        'bio',
        'gender',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_number_verified_at' => 'datetime',
        'otp_created_at' => 'datetime'
    ];

    /**
     * Check if a comment for a specific model needs to be approved.
     * @param mixed $model
     * @return bool
     */
    public function needsCommentApproval($model): bool
    {
        return false;
    }

    public function getRouteKeyName()
    {
        return 'username';
    }

    public function posts()
    {
        return $this->hasMany(Post::class)->orderBy('created_at', 'DESC');
    }

    public function likes()
    {
        return $this->hasMany(Like::class)->where('status', 1);
    }

    public function comments()
    {
        return $this->hasMany(config('comments.comment_class'));
    }

    public function getAvatarAttribute($value)
    {
        $imageSize = 200;

        if (request()->is('users/*')) {
            $imageSize = 400;
        }

        return $this->image ?? 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($this->user->email ?? ''))) . '?s=' . $imageSize;
    }
}
