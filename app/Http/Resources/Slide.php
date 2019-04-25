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
        return [
            'subhead' => $this->attract_subhead,
            '__option_subhead' => !empty($this->attract_subhead),
        ];
    }

    protected function getSplitAttributes()
    {
        $this->media = $this->primaryExperienceImage;
        $this->modal = $this->primaryExperienceModal;

        return [
            'primaryCopy' => $this->split_primary_copy,
            '__option_flip' => $this->image_side === 'right',
            '__option_secondary_image' => in_array(['id' => 'secondary_image'], $this->split_attributes),
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
        return [

        ];
    }

    protected function getCompareAttributes()
    {
        $this->media = $this->experienceImage;
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
                    'media' => SlideMediaResource::collection($this->endExperienceImages)->toArray(request()),
                ],
            ],
            '__option_background_image' => count($this->endBackgroundExperienceImages) > 0,
        ];
    }

    protected function commonStructure()
    {
        $rst = [
            'id' => $this->id,
            'type' => $this->module_type,
            'headline' => $this->headline,
            'media' => SlideMediaResource::collection($this->media)->toArray(request()),
            'seamlessAsset' => [
                'assetId' => $this->seamless_asset ? $this->seamless_asset['assetId'] : "0",
                'x' => $this->seamless_asset ? $this->seamless_asset['x'] : 0,
                'y' => $this->seamless_asset ? $this->seamless_asset['y'] : 0,
                'scale' => $this->seamless_asset ? $this->seamless_asset['scale'] : 1,
                'frame' => $this->seamless_asset ? $this->seamless_asset['frame'] : 0,
            ],
            'assetType' => $this->asset_type,
            '__mediaType' => null,
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
                    'image', 'video',
                ],
                '__option_inset' => $this->module_type === 'split' ?
                $this->split_attributes && in_array(['id' => 'inset'], $this->split_attributes) :
                ($this->module_type === 'fullwidthmedia' ? $this->fullwidth_inset : false),
                'modals' => SlideModalResource::collection($this->modal)->toArray(request()),
            ];
        }

        if (in_array($this->module_type, ['split', 'interstitial'])) {
            $rst += [
                '__option_headline' => !empty($this->headline),
            ];
        }

        return $rst;
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
