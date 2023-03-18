<?php

namespace App\Repositories\Behaviors;

use DamsImageService;
use App\Models\ApiRelation;
use App\Helpers\UrlHelpers;
use A17\Twill\Models\RelatedItem;

trait HandleApiRelations
{
    /**
     * The same as the normal ordered update with the difference that this one adds a relation to the pivot
     * and it creates new models per each new relation as we don't have both ends of the polymorphic relation
     * This is done this way so we can reuse the same functions and table for all API browsers.
     */
    public function updateBrowserApiRelated($object, $fields, $relationship, $positionAttribute = 'position')
    {
        $relatedElementsWithPosition = [];

        $fieldsHasElements = isset($fields['browsers'][$relationship]) && !empty($fields['browsers'][$relationship]);
        $relatedElements = $fieldsHasElements ? $fields['browsers'][$relationship] : [];

        // If we don't have an element to save the datahub_id, let's create one
        $relatedElements = array_map(function ($element) {
            return ApiRelation::firstOrCreate(['datahub_id' => $element['id']]);
        }, $relatedElements);

        $position = 1;

        foreach ($relatedElements as $relatedElement) {
            $relatedElementsWithPosition[$relatedElement['id']] = [
                // Add the relationship to the pivot, this way we can use this browser several times per model
                'relation' => $relationship,
                $positionAttribute => $position++
            ];
        }

        $object->{$relationship}()->detach($object->{$relationship}->pluck('id'));
        $object->{$relationship}()->attach($relatedElementsWithPosition);
    }

    public function updateMultiBrowserApiRelated($object, $fields, $relationship, $typeUsesApi)
    {
        // WEB-2272: check if we dont leave some stale data in database by not deleting apiElements
        // Remove all associations
        // $object->apiElements()->detach();

        $relatedElementsWithPosition = [];

        $fieldsHasElements = isset($fields['browsers'][$relationship]) && !empty($fields['browsers'][$relationship]);
        $relatedElements = $fieldsHasElements ? $fields['browsers'][$relationship] : [];
        // If we don't have an element to save the datahub_id, let's create one
        $relatedElements = array_map(function ($element) use ($typeUsesApi) {
            if ($typeUsesApi[$element['endpointType']]) {
                $apiItem = ApiRelation::firstOrCreate(['datahub_id' => $element['id']]);
                $apiItem->endpointType = $element['endpointType'];

                return $apiItem;
            }

            return $element;
        }, $relatedElements);

        RelatedItem::where([
            'browser_name' => $relationship,
            'subject_id' => $object->getKey(),
            'subject_type' => $object->getMorphClass(),
        ])->delete();

        $position = 1;
        collect($relatedElements)->each(function ($values) use ($relationship, &$position, $object) {
            RelatedItem::create([
                'subject_id' => $object->getKey(),
                'subject_type' => $object->getMorphClass(),
                'related_id' => $values['id'],
                'related_type' => $values['endpointType'],
                'browser_name' => $relationship,
                'position' => $position,
            ]);
            $position++;
        });
    }

    /**
     * Get all elements and return data filled with the API elements.
     * This way we don't have to redesign the browser.
     *
     */
    public function getFormFieldsForBrowserApi($object, $relation, $apiModel, $routePrefix = null, $titleKey = 'title', $moduleName = null)
    {
        // Get all datahub_id's
        $ids = $object->{$relation}->pluck('datahub_id')->toArray();
        // Use those to load API records
        $apiElements = $apiModel::query()->ids($ids)->get();

        // Find locally selected objects
        $localApiMapping = $object->{$relation}->filter(function ($relatedElement) use ($apiElements) {
            return $apiElements->where('id', $relatedElement->datahub_id)->first();
        });

        return $localApiMapping->map(function ($relatedElement) use ($titleKey, $routePrefix, $relation, $moduleName, $apiElements) {
            $data = [];
            // Get the API elements and use them to build the browser elements
            $apiElement = $apiElements->where('id', $relatedElement->datahub_id)->first();

            // If it contains an augmented model create an edit link
            if ($apiElement->hasAugmentedModel() && $apiElement->getAugmentedModel()) {
                $data['edit'] = moduleRoute($moduleName ?? $relation, $routePrefix ?? '', 'edit', [$apiElement->getAugmentedModel()->id]);

                if (classHasTrait($apiElement->getAugmentedModel(), \App\Models\Behaviors\HasMedias::class)) {
                    $data['thumbnail'] = $apiElement->getAugmentedModel()->defaultCmsImage(['w' => 100, 'h' => 100]);
                }
            } else {
                // WEB-1187: This is reached after page refresh, if the model hasn't been augmented
                if (UrlHelpers::moduleRouteExists($moduleName ?? $relation, $routePrefix ?? '', 'augment')) {
                    $data['edit'] = moduleRoute($moduleName ?? $relation, $routePrefix ?? '', 'augment', [$apiElement->id]);
                }

                $data['thumbnail'] = DamsImageService::getTransparentFallbackUrl(['w' => 100, 'h' => 100]);
            }

            return [
                'id' => $apiElement->id,
                'name' => $apiElement->titleInBrowser ?? $apiElement->{$titleKey},
            ] + $data;
        })->values()->toArray();
    }

    public function getFormFieldsForMultiBrowserApi($object, $browser_name, $apiModelsDefinitions, $typeUsesApi)
    {
        $results = collect();

        $typedFormFields = $object->relatedItems
            ->where('browser_name', $browser_name)
            ->groupBy('related_type')
            ->map(function ($items, $type) use ($apiModelsDefinitions, $browser_name, $typeUsesApi) {
                if ($typeUsesApi[$type]) {
                    $apiElements = $this->getApiElements($items, $type, $apiModelsDefinitions);
                    $localApiMapping = $this->getLocalApiMapping($items, $apiElements);
                    $apiModelDefinition = $apiModelsDefinitions[$type];

                    return $localApiMapping->map(function ($relatedElement) use ($apiModelDefinition, $apiElements) {
                        $data = [];
                        // Get the API elements and use them to build the browser elements
                        $apiRelationElement = \App\Models\ApiRelation::where('id', $relatedElement->related_id)->first();
                        $apiElement = $apiElements->where('id', $apiRelationElement->datahub_id)->first();

                        // If it contains an augmented model create an edit link
                        if ($apiElement->hasAugmentedModel() && $apiElement->getAugmentedModel()) {
                            $data['edit'] = moduleRoute($apiModelDefinition['moduleName'], $apiModelDefinition['routePrefix'] ?? '', 'edit', [$apiElement->getAugmentedModel()->id]);

                            if (classHasTrait($apiElement->getAugmentedModel(), \App\Models\Behaviors\HasMedias::class)) {
                                $data['thumbnail'] = $apiElement->getAugmentedModel()->defaultCmsImage(['w' => 100, 'h' => 100]);
                            }
                        }
                            // WEB-1187: Add augment route here!

                        return [
                            'id' => $apiElement->id,
                            'name' => $apiElement->titleInBrowser ?? $apiElement->title,
                            'endpointType' => $apiModelDefinition['moduleName'],
                            'position' => $relatedElement->position
                        ] + $data;
                    })->values()->toArray();
                } else {
                    return $items->map(function ($relatedElement) {
                        $element = $relatedElement->related;
                        $elementPosition = $relatedElement->position;

                        if ($element) {
                            return [
                                'id' => $element->id,
                                'name' => $element->titleInBrowser ?? $element->title,
                                'endpointType' => $element->getMorphClass(),
                                'position' => $elementPosition,
                                'edit' => $element->adminEditUrl,
                            ] + ((classHasTrait($element, \A17\Twill\Models\Behaviors\HasMedias::class)) ? [
                                'thumbnail' => $element->defaultCmsImage(['w' => 100, 'h' => 100]),
                            ] : []);
                        }
                    });
                }
            });

        return $typedFormFields->flatten(1)->sortBy(function ($browserItem, $key) {
            return $browserItem['position'];
        })->values()->toArray();
    }
}
