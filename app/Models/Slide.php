<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\HasTranslation;
use A17\Twill\Models\Behaviors\Sortable;
use A17\Twill\Models\Model;
use App\Http\Resources\SlideAsset as SlideAssetResource;
use App\Http\Resources\Slide as SlideResource;
use App\Models\SeamlessImage;

class Slide extends Model implements Sortable
{
    use HasBlocks, HasSlug, HasMedias, HasFiles, HasRevisions, HasPosition;

    protected $fillable = [
        'published',
        'title',
        'description',
        'experience_id',
        'asset_type',
        'module_type',
        'fullwidthmedia_standard_media_type',
        'split_standard_media_type',
        'split_video_play_settings',
        'video_play_settings',
        'split_video_url',
        'video_url',
        'media_type',
        'media_title',
        'position',
        'split_attributes',
        'headline',
        'image_side',
        'caption',
        'interstitial_headline',
        'body_copy',
        'split_primary_copy',
        'section_title',
        'object_title',
        'compare_title',
        'tooltip_hotspots',
        'fullwidth_inset',
        'seamless_asset',
        'seamless_image_asset',
        'attract_title',
        'attract_subhead',
        'end_headline',
        'end_copy',
        'end_credit_subhead',
        'end_credit_copy',
        'seamless_alt_text',
    ];

    protected $casts = [
        'split_attributes' => 'array',
        'tooltip_hotspots' => 'array',
        'seamless_asset' => 'array',
        'seamless_image_asset' => 'array',
        'video_play_settings' => 'array',
        'split_video_play_settings' => 'array'
    ];

    protected function getCanDeleteAttribute()
    {
        return $this->module_type != 'attract' && $this->module_type != 'end';
    }

    public $slugAttributes = [
        'title',
    ];

    public $checkboxes = [
        'published',
    ];

    public $filesParams = ['sequence_file'];

    public function getSplitAttributesAttribute()
    {
        if ($this->attributes['split_attributes']) {
            return array_map(function ($option) {
                return ['id' => $option];
            }, json_decode($this->attributes['split_attributes']));
        }
    }

    public function getVideoPlaySettingsAttribute()
    {
        if ($this->attributes['video_play_settings']) {
            return array_map(function ($option) {
                return ['id' => $option];
            }, json_decode($this->attributes['video_play_settings']));
        };
    }

    public function getSplitVideoPlaySettingsAttribute()
    {
        if ($this->attributes['split_video_play_settings']) {
            return array_map(function ($option) {
                return ['id' => $option];
            }, json_decode($this->attributes['split_video_play_settings']));
        };
    }

    public function experience()
    {
        return $this->belongsTo('App\Models\Experience');
    }

    public function experienceImage()
    {
        return $this->morphMany('App\Models\ExperienceImage', 'imagable')->where('imagable_repeater_name', 'experience_image');
    }

    public function seamlessExperienceImage()
    {
        return $this->morphMany('App\Models\ExperienceImage', 'imagable')->where('imagable_repeater_name', 'seamless_experience_image');
    }

    public function interstitialExperienceImage()
    {
        return $this->morphMany('App\Models\ExperienceImage', 'imagable')->where('imagable_repeater_name', 'interstitial_experience_image');
    }

    public function fullwidthmediaExperienceImage()
    {
        return $this->morphMany('App\Models\ExperienceImage', 'imagable')->where('imagable_repeater_name', 'fullwidthmedia_experience_image');
    }

    public function tooltipExperienceImage()
    {
        return $this->morphMany('App\Models\ExperienceImage', 'imagable')->where('imagable_repeater_name', 'tooltip_experience_image');
    }

    public function primaryExperienceImage()
    {
        return $this->morphMany('App\Models\ExperienceImage', 'imagable')->where('imagable_repeater_name', 'slide_primary_experience_image');
    }

    public function secondaryExperienceImage()
    {
        return $this->morphMany('App\Models\ExperienceImage', 'imagable')->where('imagable_repeater_name', 'slide_secondary_experience_image');
    }

    public function attractExperienceImages()
    {
        return $this->morphMany('App\Models\ExperienceImage', 'imagable')->where('imagable_repeater_name', 'attract_experience_image');
    }

    public function endExperienceImages()
    {
        return $this->morphMany('App\Models\ExperienceImage', 'imagable')->where('imagable_repeater_name', 'end_experience_image');
    }

    public function endBackgroundExperienceImages()
    {
        return $this->morphMany('App\Models\ExperienceImage', 'imagable')->where('imagable_repeater_name', 'end_bg_experience_image');
    }

    public function ExperienceModal()
    {
        return $this->morphMany('App\Models\ExperienceModal', 'modalble')->where('modalble_repeater_name', 'experience_modal');
    }

    public function primaryExperienceModal()
    {
        return $this->morphMany('App\Models\ExperienceModal', 'modalble')->where('modalble_repeater_name', 'primary_experience_modal');
    }

    public function secondaryExperienceModal()
    {
        return $this->morphMany('App\Models\ExperienceModal', 'modalble')->where('modalble_repeater_name', 'secondary_experience_modal');
    }

    public function compareExperienceImage1()
    {
        return $this->morphMany('App\Models\ExperienceImage', 'imagable')->where('imagable_repeater_name', 'compare_experience_image_1');
    }

    public function compareExperienceImage2()
    {
        return $this->morphMany('App\Models\ExperienceImage', 'imagable')->where('imagable_repeater_name', 'compare_experience_image_2');
    }

    public function compareExperienceModal()
    {
        return $this->morphMany('App\Models\ExperienceImage', 'imagable')->where('imagable_repeater_name', 'compare_experience_modal');
    }

    public function getContentBundleAttribute()
    {
        return SlideResource::collection(collect([$this]))->toArray(request());
    }

    public function getAssetLibraryAttribute()
    {
        return $this->experience->assetLibrary;
    }
}
