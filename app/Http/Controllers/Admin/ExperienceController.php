<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use A17\Twill\Http\Controllers\Admin\ModuleController;
use App\Models\Experience;
use App\Models\InteractiveFeature;
use App\Models\Article;

class ExperienceController extends ModuleController
{
    protected $moduleName = 'experiences';
    protected $modelName = 'Experience';
    protected $previewView = 'site.experienceDetail';

    protected $indexOptions = [
        'reorder' => true,
    ];

    protected $indexColumns = [
        'image' => [
            'thumb' => true,
            'variant' => [
                'role' => 'image',
                'crop' => 'default',
            ],
        ],
        'isWebPublished' => [
            'title' => 'Is web published?',
            'field' => 'isWebPublished',
            'present' => true,
        ],
        'title' => [
            'title' => 'Title',
            'field' => 'title',
        ],
        'interactiveFeatureTitle' => [ // Relation column
            'title' => 'Grouping',
            'relationship' => 'interactiveFeature',
            'field' => 'title'
        ],
        'experiences' => [
            'title' => 'Slides',
            'nested' => 'slides',
        ],
    ];

    /**
     * Intend to override the lines:
     * thumbnail
     * $value .= moduleRoute("experiences.slides", $this->routePrefix, 'index', [$item->id]);
     */
    protected function getItemColumnData($item, $column)
    {
        if (isset($column['thumb']) && $column['thumb']) {
            if (isset($column['present']) && $column['present']) {
                return [
                    'thumbnail' => $item->presentAdmin()->{$column['presenter']},
                ];
            }
                $variant = isset($column['variant']);
                $crop = $variant ? $column['variant']['crop'] : head(array_keys(head($item->mediasParams)));
                $params = $variant && isset($column['variant']['params'])
                ? $column['variant']['params']
                : ['w' => 80, 'h' => 80, 'fit' => 'crop'];

                $thumbnail_image = $item->defaultCmsImage($params);

                return [
                    'thumbnail' => $thumbnail_image,
                ];

        }

        if (isset($column['nested']) && $column['nested']) {
            $field = $column['nested'];
            $nestedCount = $item->{$column['nested']}->count();
            $value = '<a href="';
            $value .= moduleRoute('experiences.slides', $this->routePrefix, 'index', [$item->id]);
            $value .= '">' . $nestedCount . ' ' . (strtolower($nestedCount > 1
                ? Str::plural($column['title'])
                : Str::singular($column['title']))) . '</a>';
        } else {
            $field = $column['field'];
            $value = $item->{$field};
        }

        if (isset($column['relationship'])) {
            $field = $column['relationship'] . ucfirst($column['field']);
            $value = Arr::get($item, "{$column['relationship']}.{$column['field']}");
        } elseif (isset($column['present']) && $column['present']) {
            $value = $item->presentAdmin()->{$column['field']};
        }

        return [
            "${field}" => $value,
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
        $articles = Article::published()
            ->orderBy('date', 'desc')
            ->notUnlisted()
            ->paginate(4);

        return [
            'experience' => $item,
            'singleSlide' => true,
            'contrastHeader' => true,
            'slide' => $item,
            'furtherReading' => $articles,
            'canonicalUrl' => route('interactiveFeatures.show', ['id' => $item->id, 'slug' => $item->titleSlug]),
        ];
    }

    protected function formData($request)
    {
        return [
            'groupingsList' => InteractiveFeature::all()->pluck('title', 'id')
        ];
    }

    protected function indexData($request)
    {
        return [
            'groupingsList' => InteractiveFeature::all()->pluck('title', 'id')
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
