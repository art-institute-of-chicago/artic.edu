<?php

namespace App\Repositories\Behaviors;

use A17\Twill\Repositories\ModuleRepository;
use A17\Twill\Services\MediaLibrary\ImageService;
use Illuminate\Support\Str;
use App\Helpers\UrlHelpers;

trait HandleApiBlocks
{
    protected function getBlockBrowsers($block): array
    {
        return collect($block['content']['browsers'])->mapWithKeys(function ($ids, $relation) use ($block) {
            try {
                $relationRepository = $this->getModelRepository($relation);
                $relatedItems = $relationRepository->get([], ['id' => $ids], [], -1);
            } catch (\Throwable $th) {
                $relatedItems = collect();
            }
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
                        $data['edit'] = moduleRoute($relation, config('twill.block_editor.browser_route_prefixes.' . $relation), 'edit', [$relatedElement->getAugmentedModel()->id]);

                        if (classHasTrait($relatedElement->getAugmentedModel(), \App\Models\Behaviors\HasMedias::class)) {
                            $data['thumbnail'] = $relatedElement->getAugmentedModel()->defaultCmsImage(['w' => 100, 'h' => 100]);
                        }

                        // WEB-2271: Refactor me!
                        if (
                            ((
                                !isset($data['thumbnail'])
                            ) || (
                                isset($data['thumbnail']) && $data['thumbnail'] === ImageService::getTransparentFallbackUrl(['w' => 100, 'h' => 100])
                            )) && (
                                classHasTrait($relatedElement, \Aic\Hub\Foundation\Library\Api\Models\Behaviors\HasMediasApi::class)
                            )
                        ) {
                            $data['thumbnail'] = $relatedElement->defaultCmsImage(['w' => 100, 'h' => 100]);
                        }
                    } else {
                        // WEB-1187: This is reached after page refresh, if the model hasn't been augmented
                        if (UrlHelpers::moduleRouteExists($relation, config('twill.block_editor.browser_route_prefixes.' . $relation), 'augment')) {
                            $data['edit'] = moduleRoute($relation, config('twill.block_editor.browser_route_prefixes.' . $relation), 'augment', [$relatedElement->id]);
                        }

                        if (classHasTrait($relatedElement, \Aic\Hub\Foundation\Library\Api\Models\Behaviors\HasMediasApi::class)) {
                            $data['thumbnail'] = $relatedElement->defaultCmsImage(['w' => 100, 'h' => 100]);
                        }
                    }
                } else {
                    // Load a normal edit
                    $data['edit'] = moduleRoute($relation, config('twill.block_editor.browser_route_prefixes.' . Str::camel($relation)), 'edit', [$relatedElement->id]);
                    $data['thumbnail'] = $relatedElement->defaultCmsImage(['w' => 100, 'h' => 100]);
                }

                return [
                    'id' => $relatedElement->id,
                    'name' => $relatedElement->titleInBrowser ?? $relatedElement->title,
                    'endpointType' => $relatedElement->getMorphClass(),
                ] + $data;
            })->toArray();

            return [
                "blocks[{$block->id}][${relation}]" => $items,
            ];
        })->filter()->toArray();
    }

    protected function getModelRepository(
        string $relation,
        ModuleRepository|string|null $model = null,
    ): ModuleRepository {
        if (!$model) {
            $model = ucfirst(Str::camel(Str::singular($relation)));
        }

        // Always load the API repository first and fallback to the augmented or regular one.
        $apiRepo = config('twill.namespace') . '\\Repositories\\Api\\' . ucfirst($model) . 'Repository';

        if (class_exists($apiRepo)) {
            return app($apiRepo);
        }

        return app(config('twill.namespace') . '\\Repositories\\' . ucfirst($model) . 'Repository');
    }
}
