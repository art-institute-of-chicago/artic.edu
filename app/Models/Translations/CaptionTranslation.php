<?php

namespace App\Models\Translations;

use A17\Twill\Models\Model;
use App\Libraries\Caption\Parser as CaptionParser;
use App\Models\Caption;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CaptionTranslation extends Model
{
    protected $baseModuleModel = Caption::class;

    public function transcript(): Attribute
    {
        return Attribute::make(
            get: function ($_, array $attributes) {
                $file = $attributes['file'];
                return $file ? CaptionParser::parseFile($file)->getTranscript($this->caption->video) : '';
            },
        );
    }

    public function caption(): BelongsTo
    {
        return $this->belongsTo(Caption::class);
    }
}
