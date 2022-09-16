<?php

namespace App\Models;

use BeyondCode\Comments\Traits\HasComments;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JordanMiguel\LaravelPopular\Traits\Visitable;
use Overtrue\LaravelLike\Traits\Likeable;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

class Post extends Model implements HasMedia
{
    use HasFactory, HasComments, HasEagerLimit, Visitable, Likeable, InteractsWithMedia, Loggable;

    public const PAGINATE_COUNT = 18;

    public const POPULAR_BY_DAY = 3;

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

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_CROP, 400, 400)
            ->sharpen(10);

        $this->addMediaConversion('square')
            ->fit(Manipulations::FIT_FILL, 1080, 1080)
            ->background('ffffff');

        $this->addMediaConversion('meta-image')
            ->fit(Manipulations::FIT_CROP, 1200, 675)
            ->sharpen(10);
    }
}
