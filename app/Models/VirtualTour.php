<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasPosition;
use App\Models\Behaviors\HasBlocks;
use App\Models\Behaviors\HasMediasEloquent;

class VirtualTour extends AbstractModel
{
    use HasSlug;
    use HasMedias;
    use HasMediasEloquent;
    use HasRevisions;
    use HasPosition;
    use HasFiles;
    use HasBlocks;
    use Transformable;

    protected $presenter = 'App\Presenters\Admin\VirtualTourPresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\VirtualTourPresenter';

    protected $fillable = [
        'published',
        'title',
        'position',
        'title',
        'date',
        'heading',
        'title_display',
        'list_description',
    ];

    protected $casts = [
        'date' => 'date',
        'published' => 'boolean',
    ];

    public $slugAttributes = [
        'title',
    ];

    public $mediasParams = [
        'hero' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 16 / 9,
                ],
            ],
        ],
    ];

    public $filesParams = ['vtour_xml_file'];

    public function getVirtualTourXML()
    {
        if ($this->file('vtour_xml_file')) {
            return $this->file('vtour_xml_file');
        }

        return null;
    }
}
