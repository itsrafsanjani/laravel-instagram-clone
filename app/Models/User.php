<?php

namespace App\Models;

use AshAllenDesign\ShortURL\Models\ShortURL;
use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Traits\HasWallet;
use BeyondCode\Comments\Contracts\Commentator;
use Famdirksen\LaravelReferral\Contracts\CanReferralContract;
use Famdirksen\LaravelReferral\Contracts\HandleReferralContract;
use Famdirksen\LaravelReferral\Traits\CanReferralTrait;
use Famdirksen\LaravelReferral\Traits\HandleReferralTrait;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Overtrue\LaravelFollow\Traits\Followable;
use Overtrue\LaravelFollow\Traits\Follower;
use Overtrue\LaravelLike\Traits\Liker;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

class User extends Authenticatable implements
    MustVerifyEmail,
    Commentator,
    HasMedia,
    CanReferralContract,
    HandleReferralContract,
    Wallet
{
    use HasFactory,
        Notifiable,
        HasEagerLimit,
        Followable,
        Follower,
        Liker,
        InteractsWithMedia,
        Loggable,
        CanReferralTrait,
        HandleReferralTrait,
        HasWallet;



    public const PAGINATE_COUNT = 20;

    protected $with = ['media'];

    protected $appends = ['avatar'];

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
        'is_admin',
        'avatar',
        'username_last_updated_at',
        'username_update_attempts',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_number_verified_at' => 'datetime',
        'otp_created_at' => 'datetime',
    ];

    /**
     * Check if a comment for a specific model needs to be approved.
     *
     * @param  mixed  $model
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

    public function comments()
    {
        return $this->hasMany(config('comments.comment_class'));
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getAvatarAttribute($value)
    {
        $imageSize = 200;

        if (request()->is('users/*')) {
            $imageSize = 400;
        }

        return optional($this->getMedia('avatars')->last())->getUrl('thumb') ?? 'https://www.gravatar.com/avatar/'.md5(strtolower(trim($this->email))).'?s='.$imageSize;
    }

    public function generateAvatar($email)
    {
        $imageSize = 200;

        if (request()->is('users/*')) {
            $imageSize = 400;
        }

        return optional($this->getMedia('avatars')->last())->getUrl('thumb') ?? 'https://www.gravatar.com/avatar/'.md5(strtolower(trim($email))).'?s='.$imageSize;
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_CROP, 400, 400)
            ->sharpen(10);
    }

    public function shortUrls()
    {
        return $this->belongsToMany(ShortURL::class, 'short_url_user', 'user_id', 'short_url_id');
    }
}
