<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Playlist extends AbstractModel
{
    use HasFactory;

    protected $fillable = [
        'published',
        'title',
        'youtube_id',
    ];

    protected $casts = [
        'published' => 'boolean',
    ];

    public $attributes = [
        'published' => false,
    ];

    public function videos()
    {
        return $this->belongsToMany(Video::class)
            ->withTimestamps()
            ->withPivot('position')
            ->orderByPivot('position');
    }
}
