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

    /**
     * Aside from custom, these should also be defined in config('twill.block_editor.browser_route_prefixes')
     */
    const ITEM_TYPE_CUSTOM = 'custom';
    const ITEM_TYPE_ARTICLE = 'articles';
    const ITEM_TYPE_HIGHLIGHT = 'highlights';
    const ITEM_TYPE_EXPERIENCE = 'experiences';

    public static function getClassFromType($itemType)
    {
        switch ($itemType) {
            case self::ITEM_TYPE_CUSTOM:
                return null;
            case self::ITEM_TYPE_ARTICLE:
                return Article::class;
            case self::ITEM_TYPE_HIGHLIGHT:
                return Highlight::class;
            case self::ITEM_TYPE_EXPERIENCE:
                return Experience::class;
        }
    }

    public static function findByType($itemType, $ids)
    {
        $itemClass = self::getClassFromType($itemType);

        if (!$itemClass) {
            return null;
        }

        switch ($itemType) {
            case self::ITEM_TYPE_EXPERIENCE:
                return $itemClass::query()->webPublished()->find($ids)->first();
            default:
                return $itemClass::query()->published()->find($ids)->first();
        }
    }

    public function magazineIssue()
    {
        return $this->belongsTo(MagazineIssue::class);
    }

    public function magazinable()
    {
        return $this->morphTo();
    }
}
