<?php

namespace App\Http\Resources;

use App\Http\Resources\SlideMedia as SlideMediaResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Helpers\UrlHelpers;

class SlideModal extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        switch ($this->modal_type) {
            case 'image':
                return [
                    '__mediaType' => 'image',
                    '__option_caption' => !empty($this->image_sequence_caption) || !empty($this->imageCaption('experience_image')),
                    '__option_zoomable' => $this->zoomable,
                    'id' => (string) $this->id,
                    'src' => $this->modal_type === 'image' ? SlideMediaResource::collection($this->experienceImage)->toArray(request()) : [UrlHelpers::parseVideoUrl($this->video_url)],
                    'caption' => $this->image_sequence_caption ?? $this->imageCaption('experience_image'),
                ];

                break;
            case 'video':
                return [
                    '__mediaType' => 'video',
                    '__option_autoplay' => $this->video_play_settings && in_array('autoplay', $this->video_play_settings),
                    '__option_controls' => $this->video_play_settings && in_array('control', $this->video_play_settings),
                    '__option_inset' => $this->video_play_settings && in_array('inset', $this->video_play_settings),
                    '__option_caption' => !empty($this->image_sequence_caption) || !empty($this->imageCaption('experience_image')),
                    '__option_loop' => $this->video_play_settings && in_array('loop', $this->video_play_settings),
                    '__option_zoomable' => $this->zoomable,
                    'id' => (string) $this->id,
                    'src' => $this->modal_type === 'image' ? SlideMediaResource::collection($this->experienceImage)->toArray(request()) : [UrlHelpers::parseVideoUrl($this->video_url)],
                    'caption' => $this->image_sequence_caption ?? $this->imageCaption('experience_image'),
                ];

                break;
            case 'image_sequence':
                return [
                    '__mediaType' => 'image_sequence',
                    '__option_reverse' => $this->image_sequence_playback && in_array('reverse', $this->image_sequence_playback),
                    '__option_infinite' => $this->image_sequence_playback && in_array('infinite', $this->image_sequence_playback),
                    '__option_caption' => !empty($this->image_sequence_caption) || !empty($this->imageCaption('experience_image')),
                    'id' => (string) $this->id,
                    'assetId' => $this->fileObject('image_sequence_file') ? $this->fileObject('image_sequence_file')->id : '0',
                    'caption' => $this->image_sequence_caption ?? $this->imageCaption('experience_image'),
                ];

                break;
            case '3d_model':
                $model3d = $this->model3d;

                if ($model3d) {
                    return [
                        'id' => (string) $this->id,
                        '__mediaType' => '3d_model',
                        'model_id' => $model3d->model_id,
                        'camera_position' => (array) $model3d->camera_position,
                        'camera_target' => $model3d->camera_target,
                        'annotation_list' => json_decode($model3d->annotation_list, true),
                        'caption' => $this->image_sequence_caption ?? ''
                    ];
                }

                break;
        }
        return [];
    }
}
