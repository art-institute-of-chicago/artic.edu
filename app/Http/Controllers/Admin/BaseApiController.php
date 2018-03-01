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

use A17\CmsToolkit\Http\Controllers\Admin\ModuleController;
use Illuminate\Http\Request;
use Route;

class BaseApiController extends ModuleController
{
    // Option to setup links and the possibility of augmenting a model
    protected $hasAugmentedModel = false;

    protected $defaultFilters = [
        'search' => 'search',
    ];

    // Remove CMS toolkit table filters.
    public function getIndexTableMainFilters($items)
    {
        return [];
    }

    /**
     * Create a new model to augment it and redirect to the editing form
     *
     * @param string $datahubId
     */
    public function augment($datahubId) {
        // Load data from the API
        $apiItem = $this->getApiRepository()->getById($datahubId);

        // Force the datahub_id field
        $data = $apiItem->toArray() + ['datahub_id' => $apiItem->id];

        // Create a new model with this data
        $item = $this->repository->create($data);

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

    protected function getApiRepository()
    {
        return $this->app->make("$this->namespace\Repositories\\Api\\" . $this->modelName . "Repository");
    }

    public function getIndexItems($scopes = [], $forcePagination = false)
    {
        $perPage = request('offset') ?? $this->perPage ?? 50;
        return $this->getApiRepository()->get($this->indexWith, $scopes, $this->orderScope(), $perPage, $forcePagination);
    }

    // DISABLE ORDERS, this only works when using ES search.
    protected function orderScope()
    {
        return [];
    }

    public function getIndexTableData($items)
    {
        // Make a call to obtain all augmented models included on this list
        $localElements = [];
        if ($this->hasAugmentedModel) {
            $ids = $items->pluck('id')->toArray();
            $localElements = $this->repository->get([], ['datahub_id' => $ids], [], -1);
        }

        return $items->map(function ($item) use ($localElements) {
            // If the element has an augmented model the edit URL will change
            // So it will create automatically a model to be edited and so follow
            // Our CMS guidelines
            if ($this->hasAugmentedModel) {
                if ($element = $localElements->where('datahub_id', $item->id)->first()) {
                    $item->setAugmentedModel($element);
                    $editRoute = moduleRoute($this->moduleName, $this->routePrefix, 'edit', $element->id);
                } else {
                    $editRoute = moduleRoute($this->moduleName, $this->routePrefix, 'augment', $item->id);
                }
            } else {
                $editRoute = null;
            }

            $columnsData = collect($this->indexColumns)->mapWithKeys(function ($column) use ($item) {
                return $this->getItemColumnData($item, $column);
            })->toArray();

            $name = $columnsData[$this->titleColumnKey];
            unset($columnsData[$this->titleColumnKey]);

            $itemIsTrashed = method_exists($item, 'trashed') && $item->trashed();

            return [
                'id' => $item->id,
                'name' => $name,
                'edit' => $editRoute,
                'delete' => moduleRoute($this->moduleName, $this->routePrefix, 'destroy', $item->id),
                'publish_start_date' => $item->publish_start_date,
                'publish_end_date' => $item->publish_end_date,
            ] + $columnsData
                 + ($this->getIndexOption('publish') ? ['published' => $item->published] : [])
                 + ($this->getIndexOption('feature') ? ['featured' => $item->{$this->featureField}] : [])
                 + (($this->getIndexOption('restore') && $itemIsTrashed) ? ['deleted' => true] : []);
        })->toArray();
    }

    protected function form($id)
    {
        $item = $this->repository->getById($id, $this->formWith, $this->formWithCount);

        // Load API data into the Local DB Object just to show it
        $item->refreshApi();

        $fullRoutePrefix = 'admin.' . ($this->routePrefix ? $this->routePrefix . '.' : '') . $this->moduleName . '.';
        $previewRouteName = $fullRoutePrefix . 'preview';
        $restoreRouteName = $fullRoutePrefix . 'restore';

        $data = [
            'item' => $item,
            'moduleName' => $this->moduleName,
            'titleFormKey' => $this->titleFormKey ?? $this->titleColumnKey,
            'form_fields' => $this->repository->getFormFields($item),
            'baseUrl' => $item->urlWithoutSlug ?? config('app.url') . '/',
            'revisions' => $item->revisions ? $item->revisions->map(function ($revision) {
                return [
                    'id' => $revision->id,
                    'author' => $revision->user->name,
                    'datetime' => $revision->created_at->toIso8601String(),
                ];
            })->toArray() : null,
            'saveUrl' => moduleRoute($this->moduleName, $this->routePrefix, 'update', $id),
        ] + (Route::has($previewRouteName) ? [
            'previewUrl' => moduleRoute($this->moduleName, $this->routePrefix, 'preview', $id),
        ] : []) + (Route::has($restoreRouteName) ? [
            'restoreUrl' => moduleRoute($this->moduleName, $this->routePrefix, 'restoreRevision', $id),
        ] : []);

        return array_replace_recursive($data, $this->formData($this->request));
    }

}
