<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;

class VideoCategory extends AbstractModel
{
    protected $fillable = [
        'name',
    ];

    protected $appends = [
        'title',
    ];

    public function title(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->name,
            set: fn ($value) => $this->attributes['name'] = $value,
        );
    }

    public function videos()
    {
        return $this->belongsToMany(Video::class, 'video_video_category', 'video_category_id', 'video_id');
    }
}
