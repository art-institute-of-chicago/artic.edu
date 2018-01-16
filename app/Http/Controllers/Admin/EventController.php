<?php

namespace App\Http\Controllers\Admin;

use A17\CmsToolkit\Http\Controllers\Admin\ModuleController;
use App\Repositories\SiteTagRepository;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Route;
use Session;

class EventController extends ModuleController
{
    protected $moduleName = 'events';
    protected $modelName  = 'Api\Event';
    protected $localModelName  = 'Event';

    protected $indexOptions = [
        'publish' => false,
        'bulkPublish' => false,
        'feature' => false,
        'bulkFeature' => false,
        'restore' => false,
        'bulkRestore' => false,
        'bulkDelete' => false,
        'reorder' => false,
        'permalink' => false,
    ];

    protected $indexColumns = [
        'title' => [
            'title' => 'Title',
            'field' => 'title',
        ],
        'augmented' => [
            'title' => 'Augmented?',
            'field' => 'augmented',
        ],
    ];

    protected $featureField = 'landing';

    protected $indexWith = ['medias'];

    protected $formWith = ['revisions', 'siteTags', 'events'];

    protected $filters = [];

    protected $defaultOrders = ['title' => 'desc'];

    protected function indexData($request)
    {
        return [];
    }

    protected function formData($request)
    {
        return [
            'siteTagsList' => app(SiteTagRepository::class)->listAll('name'),
        ];
    }

    /**
     * Create a new model to augment it and redirect to the editing form
     *
     * @param string $datahubId
     */
    public function augment($datahubId) {
        // Load data from the API
        $apiItem = $this->repository->getById($datahubId);

        // Force the datahub_id field
        $data = $apiItem->toArray() + ['datahub_id' => $apiItem->id];

        // Create a new model with this data
        $item = $this->getLocalRepository()->create($data);

        // Redirect to edit this model
        return $this->redirectToForm($item->id);
    }

    protected function getLocalRepository()
    {
        return $this->app->make("$this->namespace\Repositories\\" . $this->localModelName . "Repository");
    }

    protected function validateFormRequest()
    {
        return $this->app->make("$this->namespace\Http\Requests\Admin\\" . $this->localModelName . "Request");
    }

    protected function form($id)
    {
        $item = $this->getLocalRepository()->getById($id, $this->formWith, $this->formWithCount);

        // Load API data into the Local DB Object just to show it
        $item->refreshApi();

        $fullRoutePrefix = 'admin.' . ($this->routePrefix ? $this->routePrefix . '.' : '') . $this->moduleName . '.';
        $previewRouteName = $fullRoutePrefix . 'preview';
        $restoreRouteName = $fullRoutePrefix . 'restore';

        $data = [
            'item' => $item,
            'moduleName' => $this->moduleName,
            'titleFormKey' => $this->titleFormKey ?? $this->titleColumnKey,
            'form_fields' => $this->getLocalRepository()->getFormFields($item),
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

    protected function addLock($id)
    {
        $item = $this->getLocalRepository()->getById($id);

        if ($item->isLockable()) {
            if (!$item->isLocked()) {
                $item->lock(null, Auth::user());
                return true;
            } else {
                // was this lock held by the current user?
                if ($item->lockedBy()->id == Auth::user()->id) {
                    return true;
                }
            }
        }

        return false;
    }

    public function update($id)
    {
        $item = $this->getLocalRepository()->getById($id);
        $input = $this->request->all();

        if (isset($input['cmsSaveType']) && $input['cmsSaveType'] === 'cancel') {
            if ($item->isLockable() && $item->isLocked() && $item->isLockedByCurrentUser()) {
                $this->removeLock($id);
            }
            return $this->respondWithRedirect($this->getBackLink());
        } else {

            $formRequest = $this->validateFormRequest();

            if (($item->isLockable() == false) || ($item->isLocked() && $item->isLockedByCurrentUser())) {
                // check the lock?
                $this->getLocalRepository()->update($id, $formRequest->all());
                return $this->respondWithSuccess('Content saved. All good!');
            } else {
                abort(403);
            }
        }
    }

    public function getIndexTableMainFilters($items)
    {
        return [];
    }

    public function getIndexTableData($items)
    {
        // Make a call to obtain all augmented models included on this list
        $ids = $items->pluck('id')->toArray();
        $localElements = $this->getLocalRepository()->get([], ['datahub_id' => $ids], [], -1);

        return $items->map(function ($item) use ($localElements) {
            // If the element has an augmented model the edit URL will change
            // So it will create automatically a model to be edited and so follow
            // Our CMS guidelines
            if ($element = $localElements->where('datahub_id', $item->id)->first()) {
                $item->setAugmentedModel($element);
                $editRoute = moduleRoute($this->moduleName, $this->routePrefix, 'edit', $element->id);
            } else {
                $editRoute = moduleRoute($this->moduleName, $this->routePrefix, 'augment', $item->id);
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

}
