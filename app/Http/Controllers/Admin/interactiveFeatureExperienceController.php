<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;
use App\Models\Experience;
use App\Repositories\InteractiveFeatureRepository;
use App\Repositories\ExperienceRepository;

class InteractiveFeatureExperienceController extends ModuleController
{
    protected $moduleName = 'interactiveFeatures.experiences';
    protected $modelName = 'Experience';
    protected $previewView = 'site.experienceDetail';

    protected function getParentModuleForeignKey()
    {
        return 'interactive_feature_id';
    }

    protected $indexColumns = [
        'image' => [
            'thumb' => true,
            'variant' => [
                'role' => 'image',
                'crop' => 'default',
            ],
        ],
        'title' => [
            'title' => 'Title',
            'field' => 'title',
            'sort' => true,
        ],
        'experiences' => [
            'title' => 'Slides',
            'nested' => 'slides',
        ],
    ];

    protected function indexData($request)
    {
        $interactiveFeature = app(InteractiveFeatureRepository::class)->getById(request('interactiveFeature'));
        return [
            'breadcrumb' => [
                [
                    'label' => 'Groupings',
                    'url' => moduleRoute('interactiveFeatures', 'collection', 'index'),
                ],
                [
                    'label' => $interactiveFeature->title,
                    'url' => moduleRoute('interactiveFeatures', 'collection', 'edit', $interactiveFeature->id),
                ],
                [
                    'label' => 'Experiences',
                ],

            ],
        ];
    }

    protected function formData($request)
    {
        $experience = app(ExperienceRepository::class)->getById(request('experience'));
        return [
            'breadcrumb' => [
                [
                    'label' => 'Groupings',
                    'url' => moduleRoute('interactiveFeatures', 'collection', 'index'),
                ],
                [
                    'label' => $experience->interactiveFeature->title,
                    'url' => moduleRoute('interactiveFeatures', 'collection', 'edit', $experience->interactiveFeature->id),
                ],
                [
                    'label' => 'Experiences',
                    'url' => moduleRoute('interactiveFeatures.experiences', 'collection', 'index', $request->route('interactiveFeature')),
                ],
                [
                    'label' => $experience->title,
                ],

            ],
        ];
    }

    // Intend to override the lines:
    // thumbnail
    // $value .= moduleRoute("experiences.slides", $this->routePrefix, 'index', [$item->id]);
    protected function getItemColumnData($item, $column)
    {
        if (isset($column['thumb']) && $column['thumb']) {
            if (isset($column['present']) && $column['present']) {
                return [
                    'thumbnail' => $item->presentAdmin()->{$column['presenter']},
                ];
            } else {
                $variant = isset($column['variant']);
                $crop = $variant ? $column['variant']['crop'] : head(array_keys(head($item->mediasParams)));
                $params = $variant && isset($column['variant']['params'])
                ? $column['variant']['params']
                : ['w' => 80, 'h' => 80, 'fit' => 'crop'];

                $attract_slide = $item->slides()->where('module_type', 'attract')->first();
                $attract_image = $attract_slide ? $attract_slide->attractExperienceImages()->first() : null;
                $thumbnail_image = $attract_image ? $attract_image->cmsImage('experience_image', 'default', $params) : '';
                return [
                    'thumbnail' => $thumbnail_image,
                ];
            }
        }

        if (isset($column['nested']) && $column['nested']) {
            $field = $column['nested'];
            $nestedCount = $item->{$column['nested']}->count();
            $value = '<a href="';
            $value .= moduleRoute("experiences.slides", $this->routePrefix, 'index', [$item->id]);
            $value .= '">' . $nestedCount . " " . (strtolower($nestedCount > 1
                ? str_plural($column['title'])
                : str_singular($column['title']))) . '</a>';
        } else {
            $field = $column['field'];
            $value = $item->$field;
        }

        if (isset($column['relationship'])) {
            $field = $column['relationship'] . ucfirst($column['field']);
            $value = array_get($item, "{$column['relationship']}.{$column['field']}");
        } elseif (isset($column['present']) && $column['present']) {
            $value = $item->presentAdmin()->{$column['field']};
        }

        return [
            "$field" => $value,
        ];
    }

    protected function getIndexTableMainFilters($items, $scopes = [])
    {
        $statusFilters = parent::getIndexTableMainFilters($items, $scopes);
        array_push($statusFilters, [
            'name' => 'Archived',
            'slug' => 'archived',
            'number' => Experience::archived()->count(),
        ]);
        return $statusFilters;
    }

    protected function getIndexItems($scopes = [], $forcePagination = false)
    {
        $requestFilters = $this->getRequestFilters();
        if (array_key_exists('status', $requestFilters) && $requestFilters['status'] == 'archived') {
            $scopes = $scopes + ['archived' => true];
        } else {
            $scopes = $scopes + ['unarchived' => true];
        }
        return parent::getIndexItems($scopes, $forcePagination);
    }

    protected function getPermalinkBaseUrl()
    {
        return request()->getScheme() . '://' . config('app.url') . '/interactive-features/';
    }

    protected function previewData($item)
    {
        return [
            'experience' => $item,
        ];
    }

    protected function getBrowserTableData($items)
    {
        $withImage = $this->moduleHas('medias');

        return $items->map(function ($item) use ($withImage) {
            $columnsData = collect($this->browserColumns)->mapWithKeys(function ($column) use ($item, $withImage) {
                return $this->getItemColumnData($item, $column);
            })->toArray();

            $name = $columnsData[$this->titleColumnKey];
            unset($columnsData[$this->titleColumnKey]);

            return [
                'id' => $item->id,
                'name' => $name,
                'edit' => '',
                'endpointType' => $this->moduleName,
            ] + $columnsData + ($withImage && !array_key_exists('thumbnail', $columnsData) ? [
                'thumbnail' => $item->defaultCmsImage(['w' => 100, 'h' => 100]),
            ] : []);
        })->toArray();
    }

    protected function getBrowserData($prependScope = [])
    {
        if (request()->has('except')) {
            $prependScope['exceptIds'] = request('except');
        }

        $scopes = $this->filterScope($prependScope);
        $items = $this->getBrowserItems($scopes);
        $data = $this->getBrowserTableData($items);

        return array_replace_recursive(['data' => $data], []);
    }
}
