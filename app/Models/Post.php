<?php

namespace App\Models;

use BeyondCode\Comments\Traits\HasComments;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JordanMiguel\LaravelPopular\Traits\Visitable;
use Overtrue\LaravelLike\Traits\Likeable;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Post extends Model implements HasMedia
{
    use HasFactory, HasComments, Visitable, Likeable, InteractsWithMedia, Loggable;

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
            ->fit(Fit::Crop, 400, 400)
            ->sharpen(10);

        $this->addMediaConversion('square')
            ->fit(Fit::Fill, 1080, 1080)
            ->background('ffffff');

        $this->addMediaConversion('meta-image')
            ->fit(Fit::Crop, 1200, 675)
            ->sharpen(10);
    }
}
