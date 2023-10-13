<?php

namespace App\Models\Behaviors;

/**
 * TODO: Requires HasRelations. Shouldn't this just extend HasRelations, then?
 */
trait HasApiRelations
{
    public function apiElements()
    {
        return $this->morphToMany(\App\Models\ApiRelation::class, 'api_relatable')->withPivot(['position', 'relation'])->orderBy('position');
    }

    public function apiModels($relation, $model, $ttl = null)
    {
        // Obtain the API class
        $modelClass = '\\App\\Models\\Api\\' . ucfirst($model);

        // Get all Ids
        $ids = $this->{$relation}->pluck('datahub_id')->toArray();

        if (empty($ids)) {
            return collect();
        }
        // Load real the real models from the API
        $results = $modelClass::query()->ttl($ttl)->ids($ids)->get();

        // Sort them by the original ids listing (coming from our CMS position attribute)
        $sorted = $results->sortBy(function ($model, $key) use ($ids) {
            return collect($ids)->search(function ($id, $key) use ($model) {
                return $id == $model->id;
            });
        });

        return $sorted;
    }

    public function getRelatedWithApiModels($browser_name, $apiModelsDefinitions, $typeUsesApi)
    {
        if (!isset($this->relatedCache[$browser_name])) {
            $this->loadRelatedWithApiModels($browser_name, $apiModelsDefinitions, $typeUsesApi);
        }

        return $this->relatedCache[$browser_name];
    }

    public function loadRelatedWithApiModels($browser_name, $apiModelsDefinitions, $typeUsesApi)
    {
        $this->load('relatedItems');

        return $this->relatedCache[$browser_name] = $this->relatedItems
            ->where('browser_name', $browser_name)
            ->groupBy('related_type')
            ->map(function ($items, $type) use ($apiModelsDefinitions, $browser_name, $typeUsesApi) {
                if (!isset($typeUsesApi[$type])) {
                    throw new \Exception('Cannot tell if type uses API: ' . $type);
                }

                if ($typeUsesApi[$type]) {
                    $apiElements = $this->getApiElements($items, $type, $apiModelsDefinitions);
                    $localApiMapping = $this->getLocalApiMapping($items, $apiElements);

                    return $localApiMapping->map(function ($relatedElement) use ($apiElements) {
                        // Get the API elements and use them to build the browser elements
                        $apiRelationElement = \App\Models\ApiRelation::where('id', $relatedElement->related_id)->first();
                        $apiElement = $apiElements->where('id', $apiRelationElement->datahub_id)->first();
                        $apiElement->position = $relatedElement->position;

                        return $apiElement;
                    })->values();
                } else {
                    return $items->map(function ($relatedElement) {
                        $element = $relatedElement->related;
                        $element->position = $relatedElement->position;

                        if ($element->isNotUnlisted === false) {
                            return false;
                        }

                        if ($element->isPublished === false) {
                            return false;
                        }

                        return $element;
                    })->filter();
                }
            })->flatten(1)->sortBy('position');
    }

    public function getApiElements($items, $type, $apiModelsDefinitions, $isDataHubId = false)
    {
        // Get all related id's
        $relatedIds = $items->pluck('related_id')->toArray();
        // Get all datahub id's
        $datahubIds = \App\Models\ApiRelation::whereIn($isDataHubId ? 'datahub_id' : 'id', $relatedIds)->pluck('datahub_id')->toArray();
        // Use those to load API records
        $apiModelDefinition = $apiModelsDefinitions[$type];
        $apiModel = $apiModelDefinition['apiModel'];

        return $apiModel::query()->ids($datahubIds)->get();
    }

    public function getLocalApiMapping($items, $apiElements, $isDataHubId = false)
    {
        // Find locally selected objects
        return $items->filter(function ($relatedElement) use ($apiElements, $isDataHubId) {
            $apiRelationElement = \App\Models\ApiRelation::where($isDataHubId ? 'datahub_id' : 'id', $relatedElement->related_id)->first();
            $result = $apiElements->where('id', $apiRelationElement->datahub_id)->first();

            if ($result) {
                $result->position = $relatedElement->position;
            }

            return $result;
        });
    }
}
