<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasFiles;
use App\Models\Behaviors\HasApiRelations;
use App\Models\Behaviors\HasBlocks;
use App\Models\Behaviors\HasMedias;
use App\Models\Behaviors\HasMediasEloquent;

class HomeFeature extends AbstractModel
{
    use HasMedias, HasBlocks, HasApiRelations, HasMediasEloquent, HasFiles;

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

    // fill this in if you use the HasMedias traits
    public $mediasParams = [
        'hero' => [
            'default' => [
                [
                    'name' => 'landscape',
                    'ratio' => 16 / 9,
                ],
            ],
        ],
    ];
    public $filesParams = ['video']; // a list of file roles

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

    public function selections()
    {
        return $this->belongsToMany(\App\Models\Selection::class, 'home_feature_selection', 'home_feature_id', 'selection_id')->withPivot('position')->orderBy('position');
    }

    public function item()
    {
        $item = $this->events()->first();
        $item = $item ?? $this->apiModels('exhibitions', 'Exhibition')->first();
        $item = $item ?? $this->articles()->first();
        $item = $item ?? $this->selections()->first();

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
        $item->videoFront   = $this->videoFront($item->featureImage);

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

    public function videoFront($image = null)
    {
        if (!$image) {
            $image = $this->featureImage;
        }
        if (($videoUrl = $this->file('video')) != null) {
            $video = [
                'src' => $videoUrl,
                'poster' => ($image ? $image['src'] : '')
            ];

            return $video;
        }
    }

}
