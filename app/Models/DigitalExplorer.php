<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasSlug;
use App\Models\Behaviors\HasBlocks;
use App\Models\Behaviors\HasMedias;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    public $filesParams = ['model'];

    /**
     * Attribute: Get ALL top-level model blocks with their COMPLETE hierarchies.
     * This includes:
     * - The model itself
     * - Direct children (lights & annotations under the model)
     * - ALL recursively nested blocks under those annotations
     *
     * Access via: $explorer->digital_explorer_models
     */
    protected function digitalExplorerModels(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->blocks()
                    ->where('type', 'explorer_model')
                    ->whereNull('parent_id')
                    ->with([
                        'children' => function ($query) {
                            // Eager load ALL nested levels recursively
                            $query->with('children.children.children.children.children')
                                ->orderBy('position');
                        }
                    ])
                    ->orderBy('position')
                    ->get();
            }
        );
    }

    /**
     * Attribute: Get ONLY standalone, top-level annotations.
     * Excludes any annotation that has a parent_id (nested under models or other annotations).
     *
     * Access via: $explorer->digital_explorer_annotations
     */
    protected function digitalExplorerAnnotations(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->blocks()
                    ->where('type', 'explorer_annotation')
                    ->whereNull('parent_id')
                    ->orderBy('position')
                    ->get();
            }
        );
    }

    /**
     * Attribute: Get ONLY standalone, top-level lights.
     * Excludes any light that has a parent_id (nested under models).
     *
     * Access via: $explorer->digital_explorer_lights
     */
    protected function digitalExplorerLights(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->blocks()
                    ->where('type', 'explorer_light')
                    ->whereNull('parent_id')
                    ->orderBy('position')
                    ->get();
            }
        );
    }
}