<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MagazineItem extends Model
{
    protected $fillable = [
        'position',
        'feature_type',
        'tag',
        'title',
        'list_description',
        'url',
    ];

    // Aside from custom, these should also be defined in config('twill.block_editor.browser_route_prefixes')
    const ITEM_TYPE_CUSTOM = 'custom';
    const ITEM_TYPE_ARTICLE = 'articles';
    const ITEM_TYPE_SELECTION = 'selections';
    const ITEM_TYPE_EXPERIENCE = 'experiences';

    public static function getClassFromType($itemType)
    {
        switch ($itemType) {
            case self::ITEM_TYPE_CUSTOM:
                return null;
            case self::ITEM_TYPE_ARTICLE:
                return Article::class;
            case self::ITEM_TYPE_SELECTION:
                return Selection::class;
            case self::ITEM_TYPE_EXPERIENCE:
                return Experience::class;
        }
    }

    public function magazineIssue()
    {
        return $this->belongsTo(MagazineIssue::class)->orderBy('position');
    }

    public function magazinable()
    {
        return $this->morphTo();
    }
}
