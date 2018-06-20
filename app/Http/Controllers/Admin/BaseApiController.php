<?php

/**
 * WIP.
 *
 * TODO: Refactor this controller so we don't have dependencies to update
 * When we are updating the CMS.
 *
 * Right now the relationship between model and modelApi, redefinition of forms, and it's harcoded nature
 * doesn't scale in a maintenance window.
 *
 */

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;
use Illuminate\Http\Request;

class BaseApiController extends ModuleController
{
    // Option to setup links and the possibility of augmenting a model
    protected $hasAugmentedModel = false;

    protected $localElements = [];

    protected $defaultFilters = [
        'search' => 'search',
    ];

    // Remove Twill table filters.
    public function getIndexTableMainFilters($items, $scopes = [])
    {
        return [];
    }

    /**
     * Create a new model to augment it and redirect to the editing form
     *
     * @param string $datahubId
     */
    public function augment($datahubId)
    {
        // Load data from the API
        $apiItem = $this->getApiRepository()->getById($datahubId);

        // Force the datahub_id field
        $data = $apiItem->toArray() + ['datahub_id' => $apiItem->id];

        // Find if we have an existing model before creating an augmented one
        $item = $this->getRepository()->firstOrCreate(['datahub_id' => $apiItem->id], $data);

        // Redirect to edit this model
        return $this->redirectToForm($item->id);
    }

    protected function getRepository()
    {
        if ($this->hasAugmentedModel) {
            return parent::getRepository();
        } else {
            return $this->getApiRepository();
        }
    }

    protected function getBrowserTableData($items)
    {
        // Ensure data is an array and not an object to avoid json_encode wrong conversion
        return array_values(parent::getBrowserTableData($items));
    }

    protected function getApiRepository()
    {
        return $this->app->make("$this->namespace\Repositories\\Api\\" . $this->modelName . "Repository");
    }

    public function getIndexItems($scopes = [], $forcePagination = false)
    {
        $perPage = request('offset') ?? $this->perPage ?? 50;
        $items = $this->getApiRepository()->get($this->indexWith, $scopes, $this->orderScope(), $perPage, $forcePagination);

        if ($this->hasAugmentedModel) {
            $ids = $items->pluck('id')->toArray();
            $this->localElements = $this->repository->whereIn('datahub_id', $ids)->get();
            $items->setCollection($items->getCollection()->map(function ($item) {
                if ($element = collect($this->localElements)->where('datahub_id', $item->id)->first()) {
                    $item->setAugmentedModel($element);
                }

                return $item;
            }));

        }

        return $items;
    }

    // Disable sorting by default for API listings. This has to be implemented individually on each controller
    protected function orderScope()
    {
        return [];
    }

    protected function indexItemData($item)
    {
        if ($this->hasAugmentedModel) {
            if ($localItem = collect($this->localElements)->where('datahub_id', $item->id)->first()) {
                $editRoute = moduleRoute($this->moduleName, $this->routePrefix, 'edit', $localItem->id);
            } else {
                $editRoute = moduleRoute($this->moduleName, $this->routePrefix, 'augment', $item->id);
            }
        } else {
            $editRoute = null;
        }

        return ['edit' => $editRoute];
    }
}
