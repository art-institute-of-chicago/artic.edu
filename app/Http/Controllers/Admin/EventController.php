<?php

namespace App\Http\Controllers\Admin;

use A17\CmsToolkit\Http\Controllers\Admin\ModuleController;
use App\Repositories\SiteTagRepository;
use Route;

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
            'edit_link' => true,
            'sort' => true,
            'field' => 'title',
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

    protected function form($id)
    {
        $item = $this->getLocalRepository()->getById($id, $this->formWith, $this->formWithCount);

        // Load API data
        $item->refreshApi();


        // Simplify the next items
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
                $this->repository->update($id, $formRequest->all());
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

}
