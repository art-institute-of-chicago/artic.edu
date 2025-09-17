<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasRelated;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Playlist extends AbstractModel
{
    use HasFactory;
    use HasRelated;

    protected $fillable = [
        'published',
        'title',
        'youtube_id',
        'thumbnail_url',
    ];

    protected $casts = [
        'published' => 'boolean',
    ];

    public $attributes = [
        'published' => false,
    ];

    public $appends = [
        'source_url',
    ];

    public function videos()
    {
        return $this->belongsToMany(Video::class)
            ->withTimestamps()
            ->withPivot('position')
            ->orderByPivot('position');
    }

    public function sourceUrl(): Attribute
    {
        return Attribute::make(
            get: fn ($_, array $attributes) => "https://youtube.com/playlist?list={$attributes['youtube_id']}",
        );
    }
}
