<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;

class DigitalLabelExperienceSlideController extends ModuleController
{
    protected $moduleName = 'digitalLabels.experiences.slides';
    protected $modelName = 'Slide';

    protected function getParentModuleForeignKey()
    {
        return 'experience_id';
    }

    public function index($digitalLabelId = null, $experienceId = null)
    {
        $this->digitalLabelId = $digitalLabelId;
        return parent::index($experienceId);
    }

    public function store($digitalLabelId = null, $experienceId = null)
    {
        $this->digitalLabelId = $digitalLabelId;
        return parent::store($experienceId);
    }

    public function edit($digitalLabelId = null, $experienceId = null)
    {
        $this->digitalLabelId = $digitalLabelId;
        return parent::edit($experienceId);
    }

    protected function getIndexUrls($moduleName, $routePrefix)
    {
        return collect([
            'store',
            'publish',
            'bulkPublish',
            'restore',
            'bulkRestore',
            'reorder',
            'feature',
            'bulkFeature',
            'bulkDelete',
        ])->mapWithKeys(function ($endpoint) use ($moduleName, $routePrefix) {
            return [
                $endpoint . 'Url' => $this->getIndexOption($endpoint) ? moduleRoute(
                    $this->moduleName, $this->routePrefix, $endpoint,
                    $this->submodule ? [$this->digitalLabelId, $this->submoduleParentId] : []
                ) : null,
            ];
        })->toArray();
    }

    protected function getIndexTableData($items)
    {
        $translated = $this->moduleHas('translations');
        return $items->map(function ($item) use ($translated) {
            $columnsData = collect($this->indexColumns)->mapWithKeys(function ($column) use ($item) {
                return $this->getItemColumnData($item, $column);
            })->toArray();

            $name = $columnsData[$this->titleColumnKey];

            if (empty($name)) {
                if ($this->moduleHas('translations')) {
                    $fallBackTranslation = $item->translations()->where('active', true)->first();

                    if (isset($fallBackTranslation->{$this->titleColumnKey})) {
                        $name = $fallBackTranslation->{$this->titleColumnKey};
                    }
                }

                $name = $name ?? ('Missing ' . $this->titleColumnKey);
            }

            unset($columnsData[$this->titleColumnKey]);

            $itemIsTrashed = method_exists($item, 'trashed') && $item->trashed();
            $itemCanDelete = $this->getIndexOption('delete') && ($item->canDelete ?? true);
            $canEdit = $this->getIndexOption('edit');

            return array_replace([
                'id' => $item->id,
                'name' => $name,
                'publish_start_date' => $item->publish_start_date,
                'publish_end_date' => $item->publish_end_date,
                'edit' => $canEdit ? $this->getModuleRoute($item->digitalLabel->id, $item->id, 'edit') : null,
                'delete' => ($canEdit && $itemCanDelete) ? $this->getModuleRoute($item->id, 'destroy') : null,
            ] + ($this->getIndexOption('editInModal') ? [
                'editInModal' => $this->getModuleRoute($item->id, 'edit'),
                'updateUrl' => $this->getModuleRoute($item->id, 'update'),
            ] : []) + ($this->getIndexOption('publish') && ($item->canPublish ?? true) ? [
                'published' => $item->published,
            ] : []) + ($this->getIndexOption('feature') && ($item->canFeature ?? true) ? [
                'featured' => $item->{$this->featureField},
            ] : []) + (($this->getIndexOption('restore') && $itemIsTrashed) ? [
                'deleted' => true,
            ] : []) + ($translated ? [
                'languages' => $item->getActiveLanguages(),
            ] : []) + $columnsData, $this->indexItemData($item));
        })->toArray();
    }

}
