<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasSlug;
use App\Models\Behaviors\HasBlocks;
use App\Models\Behaviors\HasMedias;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DigitalExplorer extends AbstractModel
{

  use HasSlug;
  use HasFactory;
  use HasBlocks;
  use HasFiles;
  use HasMedias;

  protected $fillable = [
    'published',
    'title',
    'type',
    'meta_title',
    'meta_description',
    'short_description',
    'listing_description',
    'settings',
  ];

  public $casts = [
    'settings' => AsCollection::class,
    'published' => 'boolean'
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
        'special' => [
            [
                'name' => 'default',
                'ratio' => 21 / 9,
            ],
        ],
    ],
    'mobile_hero' => [
        'default' => [
            [
                'name' => 'default',
                'ratio' => 1,
            ],
        ],
    ],
  ];

  protected array $repeaters = [
    'digital_explorer_annotations',
    'digital_explorer_models',
    'digital_explorer_lights'
  ];

  public function digitalExplorerAnnotations()
  {
    return $this->hasMany(DigitalExplorerAnnotation::class)->orderBy('position');
  }

  public function digitalExplorerLights()
  {
    return $this->hasMany(DigitalExplorerLight::class)->orderBy('position');
  }

    public function digitalExplorerModels()
  {
    return $this->hasMany(DigitalExplorerModel::class)->orderBy('position');
  }
}