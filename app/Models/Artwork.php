<?php

namespace App\Models;

use A17\Twill\Models\Model;
use App\Models\Behaviors\HasApiModel;
use App\Models\Behaviors\HasApiRelations;

class Artwork extends Model
{
    use HasApiModel, HasApiRelations;

    protected $selectedFeaturedRelated = null;

    protected $apiModel = 'App\Models\Api\Artwork';

    protected $fillable = [
        'datahub_id',
        'meta_title',
        'meta_description',
    ];

    public function getFullTitleAttribute()
    {
        return $this->title;
    }

    public function sidebarExhibitions()
    {
        return $this->apiElements()->where('relation', 'sidebarExhibitions');
    }

    public function sidebarEvent()
    {
        return $this->belongsToMany('App\Models\Event', 'artwork_event')->withPivot('position')->orderBy('position');
    }

    public function sidebarArticle()
    {
        return $this->belongsToMany('App\Models\Article', 'article_artwork')->withPivot('position')->orderBy('position');
    }

    public function videos()
    {
        return $this->belongsToMany('App\Models\Video')->withPivot('position')->orderBy('position');
    }

    public function getFeaturedRelatedAttribute()
    {
        // Select a random element from those relationships below and return one per request
        if ($this->selectedFeaturedRelated) {
            return $this->selectedFeaturedRelated;
        }

        $types = collect(['sidebarArticle', 'videos', 'sidebarExhibitions', 'sidebarEvent'])->shuffle();
        foreach ($types as $type) {
            if ($item = $this->$type()->first()) {
                switch ($type) {
                    case 'sidebarArticle':
                        $type = 'article';
                        break;
                    case 'videos':
                        $type = 'medias';
                        break;
                    case 'sidebarEvent':
                        $type = 'event';
                        break;
                    case 'sidebarExhibitions':
                        $item = $this->apiModels('sidebarExhibitions', 'Exhibition')->first();
                        $type = 'exhibition';
                        break;
                }

                $this->selectedFeaturedRelated = [
                    'type' => str_singular($type),
                    'items' => [$item],
                ];
                return $this->selectedFeaturedRelated;
            }
        }
    }

}
