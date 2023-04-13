<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasFiles;
use App\Models\Behaviors\HasApiRelations;
use App\Models\Behaviors\HasBlocks;
use App\Models\Behaviors\HasMedias;
use App\Models\Behaviors\HasMediasEloquent;

class HomeFeature extends AbstractModel
{
    use HasMedias;
    use HasBlocks;
    use HasApiRelations;
    use HasMediasEloquent;
    use HasFiles;

    protected $fillable = [
        'title',
        'published',
        'publish_start_date',
        'publish_end_date',
        'tag',
        'call_to_action',
        'url',
    ];

    protected $presenter = 'App\Presenters\Admin\HomeFeaturePresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\HomeFeaturePresenter';

    protected $dispatchesEvents = [
        'saved' => \App\Events\UpdateHomeFeature::class,
        'deleted' => \App\Events\UpdateHomeFeature::class,
    ];

    /**
     * Required by the HasMedias traits
     */
    public $mediasParams = [
        'hero' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 16 / 9,
                ],
            ],
        ],
        'mobile_hero' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 1,
                ],
            ]
        ]
    ];
    /**
     * A list of file roles
     */
    public $filesParams = ['video'];

    public $checkboxes = ['published'];

    public function events()
    {
        return $this->belongsToMany(\App\Models\Event::class, 'event_home_feature', 'home_feature_id', 'event_id')->withPivot('position')->orderBy('position');
    }

    public function articles()
    {
        return $this->belongsToMany(\App\Models\Article::class, 'article_home_feature', 'home_feature_id', 'article_id')->withPivot('position')->orderBy('position');
    }

    public function artworks()
    {
        return $this->apiElements()->where('relation', 'artworks');
    }

    public function exhibitions()
    {
        return $this->apiElements()->where('relation', 'exhibitions');
    }

    public function highlights()
    {
        return $this->belongsToMany(\App\Models\Highlight::class, 'highlight_home_feature', 'home_feature_id', 'highlight_id')->withPivot('position')->orderBy('position');
    }

    public function item()
    {
        $item = $this->events()->first();
        $item = $item ?? $this->apiModels('exhibitions', 'Exhibition')->first();
        $item = $item ?? $this->articles()->first();
        $item = $item ?? $this->highlights()->first();

        return $item;
    }

    public function enclosedItem()
    {
        $item = $this->item();

        // Return nothing if there's no selected element.
        // This usually happens when you select an exhibition and this one gets removed from the API.
        if (!$item) {
            return null;
        }

        // Assign image and video to the actual item. Fallback to the element image if no image has been selected.
        $item->featureImage = $this->featureImage ?? $item->imageFront('hero');
        $item->featureImageMobile = $this->featureImageMobile ?? $item->imageFront('mobile_hero');
        $item->videoFront = $this->videoFront($item->featureImage);

        // Generalize the article tag
        if ($item->type == 'article') {
            $item->subtype = 'Article';
        }

        return $item;
    }

    public function getFeatureImageAttribute()
    {
        return $this->imageFront('hero');
    }

    public function getFeatureImageMobileAttribute()
    {
        return $this->imageFront('mobile_hero');
    }

    public function getVideoFrontAttribute()
    {
        return $this->videoFront();
    }

    public function videoFront($image = null)
    {
        if (!$image) {
            $image = $this->featureImage;
        }

//        if (($videoUrl = $this->file('video')) != null) {
//            $video = [
//                'src' => $videoUrl,
//                'poster' => ($image ? $image['src'] : '')
//            ];
//
//            return $video;
//        }
    }
}
