<?php

namespace App\Http\Resources;

use App\Http\Resources\SlideMedia as SlideMediaResource;
use App\Http\Resources\SlideModal as SlideModalResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Slide extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected $media;
    protected $modal;

    public function toArray($request)
    {
        return $this->getSlideAttributes() + $this->commonStructure();
    }

    protected function getSlideAttributes()
    {
        switch ($this->module_type) {
            case 'attract':
                return $this->getAttractAttributes();
                break;
            case 'split':
                return $this->getSplitAttributes();
                break;
            case 'interstitial':
                return $this->getInterstitalAttributes();
                break;
            case 'tooltip':
                return $this->getTooltipAttributes();
                break;
            case 'fullwidthmedia':
                return $this->getFullWidthMediaAttributes();
                break;
            case 'compare':
                return $this->getCompareAttributes();
                break;
            case 'end':
                return $this->getEndAttributes();
                break;
        }
    }

    protected function getAttractAttributes()
    {
        $this->media = $this->attractExperienceImages;
        
        if ($this->asset_type === 'seamless' && $this->media_type === 'type_image') {
            $this->media = $this->seamlessImage;
        }

        return [
            'subhead' => $this->attract_subhead,
            '__option_subhead' => !empty($this->attract_subhead),
        ];
    }

    protected function getSplitAttributes()
    {
        $this->media = $this->primaryExperienceImage;
        $primaryExperienceImage = $this->primaryExperienceImage->first();
        $secondaryExperienceImage = $this->secondaryExperienceImage->first();
        $primaryExperienceModal = $this->primaryExperienceModal->first();
        $secondaryExperienceModal = $this->secondaryExperienceModal->first();
        $this->modal = collect([$primaryExperienceModal, $secondaryExperienceModal])->filter(function ($modal) {
            return $modal;
        })->values();
        $secondary_image_enabled = in_array(['id' => 'secondary_image'], $this->split_attributes ?? []);
        return [
            'primaryCopy' => $this->split_primary_copy,
            '__option_flip' => $this->image_side === 'right',
            '__option_primary_modal' => $primaryExperienceModal ? true : false,
            '__option_secondary_image' => $secondary_image_enabled,
            '__option_secondary_modal' => $secondaryExperienceModal ? true : false,
            '__option_inset' => in_array(['id' => 'inset'], $this->split_attributes ?? []),
            '__option_headline' => in_array(['id' => 'headline'], $this->split_attributes ?? []),
            '__option_caption' => !empty($this->caption),
            'src' => $this->asset_type === 'standard' && $this->split_standard_media_type === 'type_video' ? parseYoutubeUrl($this->split_youtube_url) : '',
            'primaryimglink' => $primaryExperienceImage ? [
                'type' => 'imagelink',
                'src' => (new SlideMediaResource($primaryExperienceImage))->toArray(request()),
                'modalReference' => $primaryExperienceModal ? (string) $primaryExperienceModal->id : '',
                'caption' => $primaryExperienceImage->caption ?? $primaryExperienceImage->imageCaption('experience_image'),
            ] : ['modalReference' => ''],
            'imglink' => ($secondary_image_enabled && $secondaryExperienceImage) ? [
                'type' => 'imagelink',
                'src' => (new SlideMediaResource($secondaryExperienceImage))->toArray(request()),
                'modalReference' => $secondaryExperienceModal ? (string) $secondaryExperienceModal->id : '',
                'caption' => $secondaryExperienceImage->caption ?? $secondaryExperienceImage->imageCaption('experience_image'),
            ] : ['modalReference' => ''],
        ];
    }

    protected function getInterstitalAttributes()
    {
        $this->media = $this->experienceImage;
        return [
            'title' => $this->section_title,
            'copy' => $this->body_copy,
            '__option_body_copy' => !empty($this->body_copy),
            '__option_section_title' => !empty($this->section_title),
            '__option_background_image' => count($this->experienceImage) > 0,
            '__option_headline' => !empty($this->interstitial_headline),
        ];
    }

    protected function getTooltipAttributes()
    {
        $this->media = $this->tooltipExperienceImage;
        return [
            'title' => $this->object_title,
            '__option_object_title' => !empty($this->object_title),
            'hotspots' => $this->mapHotspots($this->tooltip_hotspots),
        ];
    }

    protected function getFullWidthMediaAttributes()
    {
        $this->media = $this->experienceImage;
        $this->modal = $this->experienceModal;

        if ($this->asset_type === 'standard' && $this->fullwidthmedia_standard_media_type === 'type_video') {
            $src = [parseYoutubeUrl($this->youtube_url)];
        }
        elseif ($this->asset_type === 'standard' && $this->fullwidthmedia_standard_media_type === 'type_image') {
            $src = $this->media->map(function ($image) {
                return $image->image('experience_image');
            })->toArray();
        }
        else {
            $src = '';
        }
        
        return [
            'src' => $src,
            'caption' => $this->media->first() ? $this->media->first()->caption : '',
            '__option_open_modal' => $this->modal->count() > 0,
            '__option_autoplay' => $this->video_play_settings && in_array(['id' => 'autoplay'], $this->video_play_settings),
            '__option_inset' => $this->fullwidth_inset,
            '__option_zoomable' => $this->modal->count() > 0 && $this->modal->first()->zoomable,
            '__option_caption' => !empty($this->caption),
            '__option_loop' => $this->video_play_settings && in_array(['id' => 'loop'], $this->video_play_settings),
            '__option_controls' => $this->video_play_settings && in_array(['id' => 'control_dark'], $this->video_play_settings),
            '__option_reverse' => false,
            '__option_infinite' => true,
        ];
    }

    protected function getCompareAttributes()
    {
        $this->media = $this->experienceImage;
        $compareImage1 = $this->compareExperienceImage1->first();
        $compareImage2 = $this->compareExperienceImage2->first();
        $compareModal1 = $this->compareExperienceModal->first();
        $compareModal2 = $this->compareExperienceModal->count() > 1 ? $this->compareExperienceModal->get(1) : null;
        if ($this->asset_type === 'seamless') {
            $caption1 = $this->caption;
        } else {
            $caption1 = $compareImage1 ? ($compareImage1->caption ?? $compareImage1->imageCaption('experience_image')) : null;
        }
        $caption2 = $compareImage2 ? ($compareImage2->caption ?? $compareImage2->imageCaption('experience_image')) : null;
        return [
            'object1Src' => $compareImage1 ? (new SlideMediaResource($compareImage1))->toArray(request()) : [],
            'object1Caption' => $caption1,
            'object2Src' => $compareImage2 ? (new SlideMediaResource($compareImage2))->toArray(request()) : [],
            'object2Caption' => $caption2,
            'modalReference1' => $compareModal1 ? (string) $compareModal1->id : '',
            'modalReference2' => $compareModal2 ? (string) $compareModal2->id : '',
            '__option_captions' => $caption1 || $caption2,
            'copy' => $this->compare_title,
            'modal1' => $compareModal1 ? (new SlideMediaResource($compareModal1))->toArray(request()) : null,
            'modal2' => $compareModal2 ? (new SlideMediaResource($compareModal2))->toArray(request()) : null,
        ];
    }

    protected function getEndAttributes()
    {
        $this->media = $this->endBackgroundExperienceImages;
        return [
            'button' => 'Start Over',
            '__option_credits' => true,
            'modals' => [
                [
                    'id' => null,
                    'subhead' => $this->end_credit_subhead,
                    'copy' => $this->end_credit_copy,
                    '__option_subhead' => !empty($this->end_credit_subhead),
                    '__option_copy' => !empty($this->end_credit_subhead),
                    '__option_media' => count($this->endExperienceImages) > 0,
                ],
            ],
            '__option_background_image' => count($this->endBackgroundExperienceImages) > 0,
        ];
    }

    protected function commonStructure()
    {
        if ($this->asset_type === 'standard') {
            if ($this->module_type === 'split') {
                $mediaType = $this->split_standard_media_type === 'type_image' ? 'image' : 'video';
            }
            elseif ($this->module_type === 'fullwidthmedia') {
                $mediaType = $this->fullwidthmedia_standard_media_type === 'type_image' ? 'image' : 'video';
            }
            else {
                $mediaType = 'image';
            }
        } else {
            $mediaType = $this->media_type === 'type_image' ? 'image' : 'sequence';
        }

        $seamlessAsset = [
            'assetID' => $this->seamless_asset ? (string) $this->seamless_asset['assetId'] : '0',
            'x' => $this->seamless_asset ? $this->seamless_asset['x'] : 0,
            'y' => $this->seamless_asset ? $this->seamless_asset['y'] : 0,
            'scale' => $this->seamless_asset ? $this->seamless_asset['scale'] / 100 : 1,
            'frame' => $this->seamless_asset ? $this->seamless_asset['frame'] - 1 : 0,
            'altText' => $this->seamless_alt_text
        ];

        if ($this->asset_type === 'seamless') {
            if ($this->media_type === 'type_image' && $this->seamlessExperienceImage->count() > 0) {
                $seamlessAsset = [
                    'assetID' => $this->seamless_image_asset ? (string) $this->seamless_image_asset['assetId'] : '0',
                    'x' => $this->seamless_image_asset ? $this->seamless_image_asset['x'] : 0,
                    'y' => $this->seamless_image_asset ? $this->seamless_image_asset['y'] : 0,
                    'scale' => $this->seamless_image_asset ? $this->seamless_image_asset['scale'] / 100 : 1,
                    'frame' => $this->seamless_image_asset ? $this->seamless_image_asset['frame'] - 1 : 0,
                    'altText' => $this->seamless_alt_text,
                    'src' => $this->seamlessExperienceImage->map(function($image) {
                        return $image->image('experience_image');
                    })->toArray()
                ];
            } else {
                $seamlessAsset = [
                    'assetID' => $this->seamless_asset ? (string) $this->seamless_asset['assetId'] : '0',
                    'x' => $this->seamless_asset ? $this->seamless_asset['x'] : 0,
                    'y' => $this->seamless_asset ? $this->seamless_asset['y'] : 0,
                    'scale' => $this->seamless_asset ? $this->seamless_asset['scale'] / 100 : 1,
                    'frame' => $this->seamless_asset ? $this->seamless_asset['frame'] - 1 : 0,
                    'altText' => $this->seamless_alt_text
                ];
            }
        } else {
            $seamlessAsset = null;
        }

        if ($this->module_type === 'interstitial') {
            $headline =  $this->interstitial_headline;
        } elseif ($this->module_type === 'attract') {
            $headline = $this->attract_title;
        } else {
            $headline = $this->headline;
        }

        $rst = [
            'id' => $this->id,
            'type' => $this->module_type,
            'headline' => $headline,
            'media' => $this->getMedia(),
            'seamlessAsset' => $seamlessAsset,
            'assetType' => $this->asset_type,
            '__mediaType' => $mediaType,
            'moduleTitle' => $this->title,
            'exhibitonId' => $this->experience->digitalLabel->id,
            'isActive' => $this->published,
            'experienceId' => $this->experience->id,
            'experienceType' => 'LABEL',
            'colorCode' => $this->experience->digitalLabel->color,
            'bgColorCode' => $this->experience->digitalLabel->grouping_background_color,
            'vScalePercent' => 0,
        ];

        if (in_array($this->module_type, ['split', 'fullwidthmedia'])) {
            $rst += [
                '__mediaType__options' => [
                    'video', 'image',
                ],
                'modals' => SlideModalResource::collection($this->modal)->toArray(request()),
            ];
        }

        return $rst;
    }

    protected function getMedia()
    {
        switch ($this->module_type) {
            case 'tooltip':
                return $this->media->first() ? (new SlideMediaResource($this->media->first()))->toArray(request()) : [];
                break;
            case 'interstitial':
                return $this->media->first() ? (new SlideMediaResource($this->media->first()))->toArray(request()) : [];
                break;
            default:
                return SlideMediaResource::collection($this->media)->toArray(request());
        }
    }

    protected function mapHotspots($hotspots)
    {
        if (!$hotspots) {
            return [];
        }
        return array_map(function ($hotspot) {
            return [
                'x' => $hotspot['x'],
                'y' => $hotspot['y'],
                'content' => isset($hotspot['description']) ? $hotspot['description'] : '',
            ];
        }, $hotspots);
    }
}
