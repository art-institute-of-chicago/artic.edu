<?php

namespace App\Models;

use Illuminate\Support\Str;

use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\Sortable;
use A17\Twill\Models\Model;

use App\Models\Behaviors\HasAuthors;
use App\Models\Behaviors\HasMedias;
use App\Models\Behaviors\HasMediasEloquent;
use App\Models\Behaviors\HasBlocks;

class DigitalPublicationSection extends AbstractModel implements Sortable
{
    use HasSlug, HasRevisions, HasPosition, HasMedias, HasMediasEloquent, HasBlocks, HasAuthors;

    protected $presenter = 'App\Presenters\Admin\DigitalPublicationSectionPresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\DigitalPublicationSectionPresenter';

    protected $fillable = [
        'published',
        'title',
        'title_display',
        'list_description',
        'date',
        'type',
        'heading',
        'author_display',
        'publish_start_date',
        'digital_publication_id',
        'position',
        'pdf_download_path',
        'cite_as',
        'references',
        'type_display',
    ];

    public $slugAttributes = [
        'title',
    ];

    public $checkboxes = [
        'published'
    ];

    public $dates = [
        'date',
        'publish_start_date',
    ];

    public $mediasParams = [
        'hero' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 16 / 9,
                ],
            ],
            'special' => [
                [
                    'name' => 'default',
                    'ratio' => 21 / 9,
                ],
            ],
        ],
    ];

    const ABOUT = 'about';
    const TEXT = 'text';
    const WORK = 'work';

    public static $types = [
        self::ABOUT => 'About',
        self::TEXT => 'Essays',
        self::WORK => 'Works',
    ];

    public function scopePublished($query)
    {
        parent::scopePublished($query);

        // ...and the parent publication has to be published as well
        return $query->whereHas('digitalPublication', function($subquery) {
            $subquery->published();
        });
    }

    public function getPublishedAttribute()
    {
        return ($this->digitalPublication->isPublished ?? false) && $this->isPublished;
    }

    public function digitalPublication()
    {
        return $this->belongsTo('App\Models\DigitalPublication');
    }

    public function getRouteKeyName()
    {
        return 'digital_publication_slug';
    }

    public function getDigitalPublicationSlugAttribute()
    {
        return join([$this->id, $this->getSlug()], '/');
    }

    public function getUrlAttribute()
    {
        return $this->present()->getCanonicalUrl();
    }
}
