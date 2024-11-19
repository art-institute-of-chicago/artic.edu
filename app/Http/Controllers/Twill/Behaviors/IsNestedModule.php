<?php

namespace App\Http\Controllers\Admin\Behaviors;

use Illuminate\Support\Collection;

trait IsNestedModule
{
    /**
     * PUB-35, PUB-127: Adds check for `$parentModuleId`
     */
    public function browser($parentModuleId = null)
    {
        $this->submodule = isset($parentModuleId);
        $this->submoduleParentId = $parentModuleId;

        return parent::browser();
    }

    /**
     * PUB-35, PUB-127, PUB-146: Override inherited function to fix `edit` link
     */
    protected function getBrowserTableData($items)
    {
        $withImage = $this->moduleHas('medias');

        return $items->map(function ($item) use ($withImage) {
            $columnsData = Collection::make($this->browserColumns)->mapWithKeys(function ($column) use ($item, $withImage) {
                return $this->getItemColumnData($item, $column);
            })->toArray();

            $name = $columnsData[$this->titleColumnKey];
            unset($columnsData[$this->titleColumnKey]);

            return [
                'id' => $item->id,
                'name' => $name,
                'edit' => moduleRoute($this->moduleName, $this->routePrefix, 'edit', [
                    $item->{$this->getParentModuleForeignKey()},
                    $item->id,
                ]),
                'endpointType' => $this->repository->getMorphClass(),
            ] + $columnsData + ($withImage && !array_key_exists('thumbnail', $columnsData) ? [
                'thumbnail' => $item->defaultCmsImage(['w' => 100, 'h' => 100]),
            ] : []);
        })->toArray();
    }
}
