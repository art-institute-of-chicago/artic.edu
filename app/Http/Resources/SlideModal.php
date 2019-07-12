<?php

namespace App\Http\Resources;

use App\Http\Resources\SlideMedia as SlideMediaResource;
use Illuminate\Http\Resources\Json\JsonResource;

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
        switch($this->modal_type) {
            case 'image':
                return [
                    '__mediaType' => 'image',
                    '__option_caption' => !empty($this->image_sequence_caption) || !empty($this->imageCaption('experience_image')),
                    'id' => (string) $this->id,
                    'src' => $this->modal_type === 'image' ? SlideMediaResource::collection($this->experienceImage)->toArray(request()) : [parseYoutubeUrl($this->youtube_url)],
                    'caption' => $this->image_sequence_caption ?? $this->imageCaption('experience_image'),
                ];
                break;
            case 'video':
                return [
                    '__mediaType' => 'video',
                    '__option_autoplay' => $this->video_play_settings && in_array('autoplay', $this->video_play_settings),
                    '__option_controls' => $this->video_play_settings && in_array('controls_dark', $this->video_play_settings),
                    '__option_controls_light' => $this->video_play_settings && in_array('controls_light', $this->video_play_settings),
                    '__option_inset' => $this->video_play_settings && in_array('inset', $this->video_play_settings),
                    '__option_caption' => !empty($this->image_sequence_caption) || !empty($this->imageCaption('experience_image')),
                    '__option_loop' => $this->video_play_settings && in_array('loop', $this->video_play_settings),
                    '__option_zoomable' => $this->zoomable,
                    'id' => (string) $this->id,
                    'src' => $this->modal_type === 'image' ? SlideMediaResource::collection($this->experienceImage)->toArray(request()) : [parseYoutubeUrl($this->youtube_url)],
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
        }
    }
}
