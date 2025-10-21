<?php

namespace App\Models\Translations;

use A17\Twill\Models\Model;
use App\Libraries\Caption\Parser as CaptionParser;
use App\Models\Caption;
use Illuminate\Database\Eloquent\Casts\Attribute;

class CaptionTranslation extends Model
{
    protected $baseModuleModel = Caption::class;

    public function transcript(): Attribute
    {
        return Attribute::make(
            get: function ($_, array $attributes) {
                $file = $attributes['file'];
                return $file ? CaptionParser::parseFile($file)->getTranscript() : '';
            },
        );
    }
}
