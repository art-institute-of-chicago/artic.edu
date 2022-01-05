<?php

namespace App\Models\Vendor;

use App\Models\Behaviors\LintsAttributes;
use App\Models\Behaviors\HasMedias;
use A17\Twill\Models\Block as BaseModel;
use App\Models\SeamlessImage;

class Block extends BaseModel
{
    use LintsAttributes, HasMedias;

    const GALLERY_ITEM_TYPE_CUSTOM = 'custom';
    const GALLERY_ITEM_TYPE_ARTWORK = 'artwork';

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

    /**
     * @link https://github.com/openseadragon/openseadragon/pull/1285/files
     */
    public function getImgixTileSource($role, $crop = 'default')
    {
        $media = $this->findMedia($role, $crop);

        if ($media) {
            return 'https://' . config('twill.imgix_source_host') . '/' . $media->uuid . '?fm=json&osd=imgix';
        }
    }
}
