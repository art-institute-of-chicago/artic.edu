<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\Sortable;
use App\Http\Resources\SlideAsset as SlideAssetResource;
use App\Http\Resources\Slide as SlideResource;
use App\Models\Behaviors\HasAuthors;
use App\Models\Behaviors\HasBlocks;
use App\Models\Behaviors\HasMedias;
use App\Models\Behaviors\HasUnlisted;
use App\Helpers\ImageHelpers;

class Experience extends AbstractModel implements Sortable
{
    use HasBlocks, HasSlug, HasMedias, HasFiles, HasRevisions, HasPosition, Transformable, HasUnlisted, HasAuthors;

    protected $presenter = 'App\Presenters\Admin\ExperiencePresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\ExperiencePresenter';

    protected $fillable = [
        'published',
        'title',
        'subtitle',
        'listing_description',
        'position',
        'interactive_feature_id',
        'archived',
        'kiosk_only',
        'show_on_articles',
        'is_unlisted',
        'is_in_magazine',
        'author_display'
    ];

    public $slugAttributes = [
        'title',
    ];

    public $checkboxes = [
        'published',
        'is_unlisted',
        'is_in_magazine',
    ];

    public function getListDescriptionAttribute()
    {
        return $this->listing_description;
    }

    public function getContentBundleAttribute()
    {
        return SlideResource::collection($this->slides()->published()->orderBy('position')->get())->toArray(request());
    }

    public function getAssetLibraryAttribute()
    {
        $slides = $this->slides()->published()->orderBy('position')->get()->filter(function ($slide) {
            if ($slide->asset_type !== 'seamless') {
                return false;
            }

            if ($slide->media_type === 'type_image' && $slide->seamlessExperienceImage()->count() === 0) {
                return false;
            }

            if ($slide->media_type === 'seamless') {
                $seamless_file = $slide->fileObject('sequence_file');

                return $seamless_file && SeamlessImage::where('zip_file_id', $seamless_file->id)->get()->count() > 0;
            }

            return true;
        });

        $assets = SlideAssetResource::collection($slides)->toArray(request());

        // Include all experience modal's image sequence
        $experienceModals = ExperienceModal::whereIn('modalble_id', $this->slides()->pluck('id'))->where('modal_type', 'image_sequence')->get();
        foreach ($experienceModals as $experienceModal) {
            if ($experienceModal->fileObject('image_sequence_file')) {
                $images = SeamlessImage::where('zip_file_id', $experienceModal->fileObject('image_sequence_file')->id)->get();
                $asset = [
                    'type' => 'sequence',
                    'id' => $experienceModal->fileObject('image_sequence_file')->id,
                    'width' => $images->first() ? $images->first()->width : 0,
                    'height' => $images->first() ? $images->first()->height : 0,
                    'src' => $images->map(function ($image) {
                        return [
                            'src' => 'https://' . config('twill.imgix_source_host') . '/seq/' . $image->file_name,
                            'frame' => $image->frame,
                        ];
                    })->toArray(),
                ];
                array_push($assets, $asset);
            }
        }

        return $assets;
    }

    public function imageFront()
    {
        if ($this->hasImage('thumbnail')) {
            $imageObject = $this->imageObject('thumbnail');
        } else {
            $attract_slide = $this->slides()->where('module_type', 'attract')->first();
            $attract_image = $attract_slide ? $attract_slide->attractExperienceImages()->first() : null;
            $imageObject = $attract_image ? $attract_image->imageObject('experience_image', 'default') : '';
        }

        if ($imageObject) {
            $cropParams = [
                'crop_x' => $imageObject->pivot->crop_x,
                'crop_y' => $imageObject->pivot->crop_y,
                'crop_w' => $imageObject->pivot->crop_w,
                'crop_h' => $imageObject->pivot->crop_h
            ];

            return ImageHelpers::aic_convertFromImage($imageObject, $cropParams);
        }
    }

    public function defaultCmsImage($params = [])
    {
        if ($this->hasImage('thumbnail')) {
            return $this->image('thumbnail');
        }
            $attract_slide = $this->slides()->where('module_type', 'attract')->first();
            $attract_image = $attract_slide ? $attract_slide->attractExperienceImages()->first() : null;

            return $attract_image ? $attract_image->cmsImage('experience_image', 'default', $params) : '';

    }

    public function slides()
    {
        return $this->hasMany('App\Models\Slide', 'experience_id');
    }

    public function interactiveFeature()
    {
        return $this->belongsTo('App\Models\InteractiveFeature');
    }

    public function getTypeAttribute()
    {
        return 'experience';
    }

    public function getKioskOnlyAttribute($value)
    {
        if (config('aic.is_preview_mode')) {
            return false;
        }

        return $value;
    }

    /**
     * WEB-1296: Show preview links for published, but kiosk-only items, too.
     */
    public function getIsPublishedAttribute()
    {
        return self::webPublished()->find($this->id) !== null;
    }

    public function getTrackingTitleAttribute()
    {
        return $this->title;
    }

    /**
     * By default, `withoutTrashed` is applied to `Expereince` and also `IF` through `whereHas`.
     *
     * @TODO Consider moving this to just override `published`?
     */
    public function scopeWebPublished($query)
    {
        if (config('aic.is_preview_mode')) {
            return $query;
        }

        return $query
            ->published()
            ->unarchived()
            ->where('kiosk_only', false)
            ->whereHas('interactiveFeature', function ($subquery) {
                $subquery
                    ->published()
                    ->unarchived();
            });
    }

    public function scopeArticlePublished($query)
    {
        return $query->where('show_on_articles', '=', true);
    }

    public function scopeArchived($query)
    {
        return $query->where('archived', true);
    }

    public function scopeUnarchived($query)
    {
        if (config('aic.is_preview_mode')) {
            return $query;
        }

        return $query->where('archived', false);
    }

    public function scopeOrderByInteractiveFeature($query, $sort_method = 'ASC')
    {
        return $query
            ->leftJoin('interactiveFeatures', 'experience.interactive_feature_id', '=', 'interactive_features.id')
            ->select('interactiveFeatures.*', 'experiences.id', 'experiences.title')
            ->orderBy('interactiveFeatures.title', $sort_method);
    }

    public function getUrl()
    {
        return route('interactiveFeatures.show', $this->slug);
    }

    public function getAdminEditUrlAttribute()
    {
        return route('admin.collection.interactive_features.experiences.edit', $this->id);
    }

    public $mediasParams = [
        'thumbnail' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 16 / 9,
                ],
            ],
        ]
    ];

    protected function transformMappingInternal()
    {
        return [
            [
                'name' => 'title',
                'doc' => 'Title',
                'type' => 'string',
                'value' => function () {
                    return $this->title;
                },
            ],
            [
                'name' => 'sub_title',
                'doc' => 'Sub-title',
                'type' => 'string',
                'value' => function () {
                    return $this->sub_title;
                },
            ],
            [
                'name' => 'listing_description',
                'doc' => 'Listing description',
                'type' => 'string',
                'value' => function () {
                    return $this->listing_description;
                },
            ],
            [
                'name' => 'position',
                'doc' => 'Position',
                'type' => 'number',
                'value' => function () {
                    return $this->position;
                },
            ],
            [
                'name' => 'interactive_feature_id',
                'doc' => 'Interactive feature ID',
                'type' => 'number',
                'value' => function () {
                    return $this->interactive_feature_id;
                },
            ],
            [
                'name' => 'archived',
                'doc' => 'Archived',
                'type' => 'boolean',
                'value' => function () {
                    return $this->archived;
                },
            ],
            [
                'name' => 'kiosk_only',
                'doc' => 'Kiosk-only',
                'type' => 'boolean',
                'value' => function () {
                    return $this->kiosk_only;
                },
            ],
            [
                'name' => 'published',
                'doc' => 'Published',
                'type' => 'boolean',
                'value' => function () {
                    return $this->published;
                },
            ],
            [
                'name' => 'is_unlisted',
                'doc' => 'Whether the press release is unlisted',
                'type' => 'boolean',
                'value' => function () {
                    return $this->is_unlisted;
                }
            ],
        ];
    }
}
