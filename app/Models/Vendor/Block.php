<?php

namespace App\Models\Vendor;

use A17\Twill\Models\Block as BaseModel;
use App\Models\Behaviors\HasMedias;
use App\Models\Behaviors\LintsAttributes;
use App\Models\SeamlessImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;

class Block extends BaseModel
{
    use LintsAttributes;
    use HasMedias;
    use HasFactory;

    public const GALLERY_ITEM_TYPE_CUSTOM = 'custom';
    public const GALLERY_ITEM_TYPE_CUSTOM_WITH_LINK = 'custom_with_link';
    public const GALLERY_ITEM_TYPE_ARTWORK = 'artwork';

    public function setAttribute($key, $value)
    {
        return parent::setAttribute($key, $this->lintValue($value));
    }

    public function getAssetLibraryAttribute()
    {
        // Include image sequence
        if ($this->fileObject('image_sequence_file')) {
            $images = SeamlessImage::where('zip_file_id', $this->fileObject('image_sequence_file')->id)->get();
            $asset = [
                'type' => 'sequence',
                'id' => $this->fileObject('image_sequence_file')->id,
                'width' => $images->first() ? $images->first()->width : 0,
                'height' => $images->first() ? $images->first()->height : 0,
                'src' => $images->map(function ($image) {
                    return [
                        'src' => 'https://' . config('twill.imgix_source_host') . '/seq/' . $image->file_name,
                        'frame' => $image->frame,
                    ];
                })->toArray(),
            ];

            return $asset;
        }

        return null;
    }

    public function getMorphClass()
    {
        return 'blocks';
    }

    /**
     * Retrieve the repeaters of the given type from the children of the block.
     */
    public function repeater(string $type): Collection
    {
        return $this->children()->where('type', $type)->get()->map(fn ($item) => (object) $item->content);
    }

    public function canRender(): bool
    {
        if ($this->type == 'video_grid') {
            $display = $this->input('display');

            if ($display == 'category') {
                $category = $this->getRelated('videoCategories')->first();
                if (!$category) {
                    return false;
                }
                return $category->videos()
                        ->published()
                        ->exists();
            } elseif ($display == 'playlist') {
                $playlist = $this->getRelated('playlist')->first();
                if (!$playlist) {
                    return false;
                }
                return $playlist->published
                    && $playlist->videos()
                        ->published()
                        ->exists();
            }
        }
        return true;
    }
}
