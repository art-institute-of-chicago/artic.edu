<?php

namespace App\Repositories\Behaviors;

use Illuminate\Support\Str;

trait HandleApiBlocks
{

    protected function getBlockBrowsers($block)
    {
        return collect($block['content']['browsers'])->mapWithKeys(function ($ids, $relation) use ($block) {
            $relationRepository = $this->getModelRepository($relation);
            $relatedItems = $relationRepository->get([], ['id' => $ids], [], -1);
            $sortedRelatedItems = array_flip($ids);

            foreach ($relatedItems as $item) {
                $sortedRelatedItems[$item->id] = $item;
            }

            $items = collect(array_values($sortedRelatedItems))->filter(function ($value) {
                return is_object($value);
            })->map(function ($relatedElement) use ($relation) {
                $data = [];

                // If it's an API model and has an augmented model setup the correct edit link
                if (method_exists($relatedElement, 'hasAugmentedModel')) {
                    if ($relatedElement->hasAugmentedModel() && $relatedElement->getAugmentedModel()) {
                        $data['edit'] = moduleRoute($relation, config('twill.block_editor.browser_route_prefixes.' . $relation), 'edit', $relatedElement->getAugmentedModel()->id);
                    }
                } else {
                    // Load a normal edit
                    $data['edit'] = moduleRoute($relation, config('twill.block_editor.browser_route_prefixes.' . $relation), 'edit', $relatedElement->id);
                }

                return [
                    'id' => $relatedElement->id,
                    'name' => $relatedElement->titleInBrowser ?? $relatedElement->title,
                ] + $data;
            })->toArray();

            return [
                "blocks[$block->id][$relation]" => $items,
            ];
        })->filter()->toArray();
    }

    protected function getModelRepository($relation, $model = null)
    {
        if (!$model) {
            $model = ucfirst(Str::camel(Str::singular($relation)));
        }

        // Always load the API repository first and fallback to the augmented or regular one.
        $apiRepo = config('twill.namespace') . "\\Repositories\\Api\\" . ucfirst($model) . "Repository";

        if (class_exists($apiRepo)) {
            return app($apiRepo);
        } else {
            return app(config('twill.namespace') . "\\Repositories\\" . ucfirst($model) . "Repository");
        }
    }

}
