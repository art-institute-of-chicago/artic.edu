<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasTranslation;
use A17\Twill\Models\Behaviors\HasFiles;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Caption extends AbstractModel
{
    use HasFactory;
    use HasFiles;
    use HasTranslation;

    protected $fillable = [
        'kind',
        'language',
        'name',
        'published',
        'updated_at',
        'video_id',
        'youtube_id',
    ];

    protected $appends = [
        'title',
    ];

    public $translatedAttributes = [
        'name',
    ];

    public $filesParams = [
        'override',
    ];

    public function title(): Attribute
    {
        return Attribute::make(
            get: function ($_, array $attributes) {
                $kind = match ($attributes['kind']) {
                    'asr' => 'Automated Speech Recognition',
                    'standard' => 'Standard Caption Track'
                };
                return implode(' - ', array_filter([$kind, $attributes['name']]));
            }
        );
    }

    public function video(): BelongsTo
    {
        return $this->belongsTo(Video::class);
    }
}
