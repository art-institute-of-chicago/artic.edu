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
        if ($this->is_attract) {
            return $this->commonStructure() + [
                'subhead' => $this->attract_subhead,
                '__option_subhead' => !empty($this->attract_subhead),
            ];
        } elseif ($this->is_end) {
            return $this->commonStructure() + [
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
        } else {
            return $this->commonStructure() + [

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
            'copy' => $this->is_experience_resource ? ($this->is_end ? $this->end_credit_copy : '') : $this->body_copy,
            'seamlessAsset' => [
                'assetId' => '0',
                'x' => 0,
                'y' => 0,
                'scale' => 1,
                'frame' => 0,
            ],
            'assetType' => 'seamless',
            '__mediaType' => null,
            'moduleTitle' => $this->is_experience_resource ? null : null,
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
                'modal' => $this->getModal(),
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
        } else {
            return null;
        }
        return SlideMediaResource::collection($images)->toArray(request());
    }
}
