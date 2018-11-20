<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Model;
use App\Models\Behaviors\HasApiModel;
use App\Models\Behaviors\HasApiRelations;
use App\Models\Behaviors\HasMediasEloquent;
use App\Models\Page;
use Carbon\Carbon;

class DigitalLabel extends Model
{
    use HasRevisions, HasSlug, HasMedias, HasMediasEloquent, HasBlocks, HasApiModel, HasApiRelations, Transformable;

    protected $apiModel = 'App\Models\Api\DigitalLabel';

    protected $dispatchesEvents = [
        'saved' => \App\Events\UpdateDigitalLabel::class,
        'deleted' => \App\Events\UpdateDigitalLabel::class,
    ];
    
    protected $fillable = [
        'published',
        'title',
        'datahub_id'
    ];

    public $slugAttributes = [
        'title',
    ];

    public $checkboxes = ['published'];

    public function getUrlWithoutSlugAttribute()
    {
        return route('digitalLabels.show', $this->datahub_id);
    }

    // protected function transformMappingInternal()
    // {
    //     return [
    //         [
    //             "name" => 'is_featured',
    //             'doc' => 'Is this exhibition in the primary or secondary feature listings on the landing page?',
    //             'type' => 'boolean',
    //             'value' => function () {return $this->is_featured;},
    //         ],
    //         [
    //             "name" => 'published',
    //             "doc" => "Published",
    //             "type" => "boolean",
    //             "value" => function () {return $this->published;},
    //         ],
    //         [
    //             "name" => 'title',
    //             'doc' => 'The title of  this exhibition',
    //             'type' => 'string',
    //             'value' => function () {return $this->title;},
    //         ],
    //         [
    //             "name" => 'header_copy',
    //             "doc" => "Header Copy",
    //             "type" => "string",
    //             "value" => function () {return $this->header_copy;},
    //         ],
    //         [
    //             "name" => "list_description",
    //             "doc" => "list_description",
    //             "type" => "string",
    //             "value" => function () {return $this->list_description;},
    //         ],
    //         [
    //             "name" => 'content',
    //             "doc" => "Content",
    //             "type" => "string",
    //             "value" => function () {return $this->content;},
    //         ],
    //         [
    //             "name" => 'image_url',
    //             "doc" => "Image URL",
    //             "type" => "string",
    //             "value" => function () {return starts_with($this->image('hero'), 'http') ? $this->image('hero') : null;},
    //         ],
    //         [
    //             "name" => 'web_url',
    //             "doc" => "Web URL",
    //             "type" => "string",
    //             "value" => function () {return route('digitalLabels.show', ['id' => $this->datahub_id, 'slug' => $this->getSlug() ]); },
    //         ],
    //         [
    //             "name" => 'datahub_id',
    //             "doc" => "Souce ID",
    //             "type" => "string",
    //             "value" => function () {return (int) $this->datahub_id;},
    //         ],
    //         [
    //             "name" => 'exhibition_message',
    //             "doc" => "Message",
    //             "type" => "string",
    //             "value" => function () {return $this->exhibition_message;},
    //         ],
    //         [
    //             "name" => 'cms_exhibition_type',
    //             "doc" => "CMS Type",
    //             "type" => "number",
    //             "value" => function () {return $this->cms_exhibition_type;},
    //         ],
    //     ];
    // }

    // public function getIsFeaturedAttribute() {

    //     // See ExhibitionsController::index and relations on Page model
    //     $page = Page::forType('Digital Labels')->with('apiElements')->first();

    //     $featuredIds = $page->apiElements()->whereIn('relation', [
    //         'exhibitionsExhibitions',
    //         'exhibitionsCurrent',
    //         'exhibitionsUpcoming',
    //         'exhibitionsUpcomingListing',
    //     ])->get(['datahub_id'])->pluck('datahub_id')->all();

    //     return in_array($this->datahub_id, $featuredIds);

    // }

     protected function transformMappingInternal()
    {
        return [
            [
                "name" => 'datahub_id',
                "doc" => "Type",
                "type" => "string",
                "value" => function () {return $this->datahub_id;},
            ],
        ];
    }

}
