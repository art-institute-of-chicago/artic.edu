<?php

namespace App\Repositories\Behaviors;

/**
 * Mimic Twill's generalized behavior for browsers,
 * but when the relation uses HasRelated instead of being
 * a proper model relation.
 *
 * @see A17\Twill\Repositories\Behaviors\HandleBrowsers
 * @see https://github.com/area17/twill/discussions/940
 */
trait HandleRelatedBrowsers
{
    protected $relatedBrowsers = [];

    protected function getRelatedBrowsers()
    {
        return collect($this->relatedBrowsers)->map(function ($browser, $key) {
            $browserName = is_string($browser) ? $browser : $key;
            $moduleName = !empty($browser['moduleName']) ? $browser['moduleName'] : $this->inferModuleNameFromBrowserName($browserName);

            return [
                'relation' => !empty($browser['relation']) ? $browser['relation'] : $this->inferRelationFromBrowserName($browserName),
                'model' => !empty($browser['model']) ? $browser['model'] : $this->inferModelFromModuleName($moduleName),
                'browserName' => $browserName,
            ];
        })->values();
    }

    public function afterSaveHandleRelatedBrowsers($object, $fields)
    {
        foreach ($this->getRelatedBrowsers() as $browser) {
            $this->updateRelatedBrowser($object, $fields, $browser['browserName']);
        }
    }

    public function getFormFieldsHandleRelatedBrowsers($object, $fields)
    {
        foreach ($this->getRelatedBrowsers() as $browser) {
            $fields['browsers'][$browser['browserName']] = $this->getFormFieldsForRelatedBrowser($object, $browser['relation']);
        }

        return $fields;
    }
}
