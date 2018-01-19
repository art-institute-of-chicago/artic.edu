<?php

namespace App\Repositories\Behaviors;

use Illuminate\Support\Facades\App;
use App\Models\ApiRelation;

trait HandleApi
{
    public function updateBrowserApiRelated($object, $fields, $relationship, $positionAttribute = 'position')
    {
        $this->updateOrderedBelongsTomanyApiRelated($object, $fields, $relationship, $positionAttribute);
    }

    /**
     * The same as the normal ordered update with the difference that this one adds a relation to the pivot
     * and it creates new models per each new relation as we don't have both ends of the polymorphic relation
     * This is done this way so we can reuse the same functions and table for all API browsers.
     *
     */
    public function updateOrderedBelongsTomanyApiRelated($object, $fields, $relationship, $positionAttribute = 'position')
    {
        $fieldsHasElements = isset($fields['browsers'][$relationship]) && !empty($fields['browsers'][$relationship]);
        $relatedElements = $fieldsHasElements ? $fields['browsers'][$relationship] : [];

        // If we don't have an element to save the datahub_id, let's create one
        $relatedElements = array_map(function($element) {
            return ApiRelation::firstOrCreate(['datahub_id' => $element['id']]);
        }, $relatedElements);

        $relatedElementsWithPosition = [];
        $position = 1;

        foreach ($relatedElements as $relatedElement) {
            $relatedElementsWithPosition[$relatedElement['id']] = [
                // Add the relationship to the pivot, this way we can use this browser several times per model
                'relation' => $relationship,
                $positionAttribute => $position++
            ];
        }

        $object->$relationship()->sync($relatedElementsWithPosition);
    }

    /**
     * Get all elements and return data filled with the API elements.
     * This way we don't have to redesign the browser.
     *
     */
    public function getFormFieldsForBrowserApi($object, $relation, $apiModel, $routePrefix = null, $titleKey = 'title', $moduleName = null)
    {
        // Get all datahub_id's
        $ids = $object->$relation->pluck('datahub_id')->toArray();
        // Use those to load API records
        $apiElements = $apiModel::query()->ids($ids)->get();

        return $object->$relation->map(function ($relatedElement) use ($titleKey, $routePrefix, $relation, $moduleName, $apiElements) {
            $data = [];
            // Get the API elements and use them to build the browser elements
            $apiElement = $apiElements->where('id', $relatedElement->datahub_id)->first();

            // If it contains an augmented model create an edit link
            if ($apiElement->getAugmentedModelLoaded()) {
                $data['edit'] = moduleRoute($moduleName ?? $relation, $routePrefix ?? '', 'edit', $apiElement->getAugmentedModelLoaded()->id);
            }

            return [
                'id' => $apiElement->id,
                'name' => $apiElement->titleInBrowser ?? $apiElement->$titleKey,
            ] + $data;
        })->toArray();
    }
}
