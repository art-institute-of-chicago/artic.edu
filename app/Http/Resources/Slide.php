<?php

namespace App\Http\Resources;

use App\Http\Resources\SlideMedia as SlideMediaResource;
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

            ];
        } else {
            return $this->commonStructure() + [

            ];
        }
    }

    protected function commonStructure()
    {
        return [
            'id' => $this->is_experience_resource ? null : $this->id,
            'type' => $this->is_experience_resource ? ($this->is_attract ? 'attract' : 'end') : null,
            'headline' => $this->is_experience_resource ? ($this->is_attract ? $this->attract_title : $this->end_credit_subhead) : null,
            'media' => $this->is_experience_resource ? (
                $this->is_attract ?
                SlideMediaResource::collection($this->attractExperienceImages)->toArray(request()) :
                SlideMediaResource::collection($this->endExperienceImages)->toArray(request())
            ) :
            null,
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
            'exhibitonId' => null,
            'isActive' => $this->is_experience_resource ? true : true,
            'experienceId' => $this->id,
            'experienceType' => 'LABEL',
            'colorCode' => $this->is_experience_resource ? $this->digitalLabel->color : null,
            'bgColorCode' => $this->is_experience_resource ? $this->digitalLabel->grouping_background_color : null,
            'vScalePercent' => 0,
        ];
    }
}
