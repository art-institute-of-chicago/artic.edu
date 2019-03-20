<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;

class DigitalLabelExperienceController extends ModuleController
{
    protected $moduleName = 'digitalLabels.experiences';
    protected $modelName = 'Experience';

    protected function getParentModuleForeignKey()
    {
        return 'digital_label_id';
    }

    protected $indexColumns = [
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

        return [
            'breadcrumb' => [
                [
                    'label' => 'Grouping',
                    'url' => moduleRoute('digitalLabels', 'collection', 'index', $request->route('digitalLabels')),
                ],
                [
                    'label' => 'Experiences',
                ],

            ],
        ];
    }

    // Intend to override the line:
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
                $role = $variant ? $column['variant']['role'] : head(array_keys($item->mediasParams));
                $crop = $variant ? $column['variant']['crop'] : head(array_keys(head($item->mediasParams)));
                $params = $variant && isset($column['variant']['params'])
                ? $column['variant']['params']
                : ['w' => 80, 'h' => 80, 'fit' => 'crop'];

                return [
                    'thumbnail' => $item->cmsImage($role, $crop, $params),
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
}
