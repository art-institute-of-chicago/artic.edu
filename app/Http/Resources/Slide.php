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

    public function __construct($resource, $is_attract = false)
    {
        parent::__construct($resource);
        $this->is_experience_resource = get_class($this->resource) === 'App\Models\Experience';
        $this->is_attract = $this->is_experience_resource && $is_attract;
        $this->is_end = $this->is_experience_resource && !$is_attract;
    }
    public function toArray($request)
    {
        return $this->commonStructure() + $this->getSlideAttributes();
    }

    protected function getSlideAttributes()
    {
        $attributes = [];
        if ($this->is_attract) {
            return [
                'subhead' => $this->attract_subhead,
                '__option_subhead' => !empty($this->attract_subhead),
            ];
        } elseif ($this->is_end) {
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
        } elseif ($this->module_type === 'split') {
            return [
                'primaryCopy' => $this->split_primary_copy,
            ];
        } elseif ($this->module_type === 'interstitial') {
            return [
                'title' => $this->section_title,
                'copy' => $this->body_copy,
                '__option_headline' => !empty($this->headline),
                '__option_body_copy' => !empty($this->body_copy),
                '__option_section_title' => !empty($this->section_title),
                '__option_background_image' => count($this->experienceImage) > 0,
            ];
        } elseif ($this->module_type === 'fullwidthmedia') {
            return [

            ];
        } elseif ($this->module_type === 'tooltip') {
            return [
                'title' => $this->object_title,
                '__option_object_title' => !empty($this->object_title),
                'hotspots' => $this->mapHotspots($this->tooltip_hotspots),
            ];
        } else {
            return [

            ];
        }
    }

    protected function commonStructure()
    {
        $rst = [
            'id' => $this->is_experience_resource ? null : $this->id,
            'type' => $this->is_experience_resource ? ($this->is_attract ? 'attract' : 'end') : $this->module_type,
            'headline' => $this->is_experience_resource ? ($this->is_attract ? $this->attract_title : $this->end_credit_subhead) : $this->headline,
            'media' => $this->getMedia(),
            'seamlessAsset' => [
                'assetId' => '0',
                'x' => 0,
                'y' => 0,
                'scale' => 1,
                'frame' => 0,
            ],
            'assetType' => $this->is_experience_resource ? 'seamless' : $this->asset_type,
            '__mediaType' => null,
            'moduleTitle' => $this->is_experience_resource ? null : $this->title,
            'exhibitonId' => $this->is_experience_resource ? $this->digitalLabel->id : $this->experience->digitalLabel->id,
            'isActive' => $this->is_experience_resource ? true : true,
            'experienceId' => $this->id,
            'experienceType' => 'LABEL',
            'colorCode' => $this->is_experience_resource ? $this->digitalLabel->color : null,
            'bgColorCode' => $this->is_experience_resource ? $this->digitalLabel->grouping_background_color : null,
            'vScalePercent' => 0,
        ];

        if (!$this->is_experience_resource && in_array($this->module_type, ['split', 'fullwidthmedia'])) {
            $rst += [
                '__mediaType__options' => [
                    'image', 'video',
                ],
                '__option_inset' => $this->module_type === 'split' ?
                in_array(['id' => 'inset'], $this->split_attributes) :
                ($this->module_type === 'fullwidthmedia' ? $this->fullwidth_inset : false),
                'modals' => $this->getModal(),
            ];
        }

        return $rst;
    }

    protected function getModal()
    {
        if ($this->is_experience_resource) {

        } elseif ($this->module_type === 'split') {
            $modals = $this->primaryExperienceModal;
        }
        return SlideModalResource::collection($modals)->toArray(request());
    }

    protected function getMedia()
    {
        if ($this->is_attract) {
            $images = $this->attractExperienceImages;
        } elseif ($this->is_end) {
            $images = $this->endBackgroundExperienceImages;
        } elseif ($this->module_type === 'split') {
            $images = $this->primaryExperienceImage;
        } elseif ($this->module_type === 'interstitial') {
            $images = $this->experienceImage;
        } elseif ($this->module_type === 'tooltip') {
            $images = $this->tooltipExperienceImage;
        } else {
            return null;
        }
        return SlideMediaResource::collection($images)->toArray(request());
    }

    protected function mapHotspots($hotspots)
    {
        return array_map(function ($hotspot) {
            return [
                'x' => $hotspot['x'],
                'y' => $hotspot['y'],
                'content' => isset($hotspot['description']) ? $hotspot['description'] : '',
            ];
        }, $hotspots);
    }
}
