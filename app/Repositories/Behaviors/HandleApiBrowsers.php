<?php

namespace App\Repositories\Behaviors;

/**
 * Mimic Twill's generalized behavior for API browsers
 *
 * @see A17\Twill\Repositories\Behaviors\HandleBrowsers
 */
trait HandleApiBrowsers
{
    protected $apiBrowsers = [];

    protected function getApiBrowsers()
    {
        return collect($this->apiBrowsers)->map(function ($browser, $key) {
            $browserName = is_string($browser) ? $browser : $key;
            $moduleName = !empty($browser['moduleName']) ? $browser['moduleName'] : $this->inferModuleNameFromBrowserName($browserName);

            return [
                'relation' => !empty($browser['relation']) ? $browser['relation'] : $this->inferRelationFromBrowserName($browserName),
                'routePrefix' => $browser['routePrefix'] ?? null,
                'titleKey' => !empty($browser['titleKey']) ? $browser['titleKey'] : 'title',
                'moduleName' => $moduleName,
                'model' => !empty($browser['model']) ? $browser['model'] : 'App\\Models\\Api\\' . $this->inferModelFromModuleName($moduleName),
                'browserName' => $browserName,
            ];
        })->values();
    }

    public function afterSaveHandleApiBrowsers($object, $fields)
    {
        foreach ($this->getApiBrowsers() as $browser) {
            $this->updateBrowserApiRelated($object, $fields, $browser['browserName']);
        }
    }

    public function getFormFieldsHandleApiBrowsers($object, $fields)
    {
        foreach ($this->getApiBrowsers() as $browser) {
            $fields['browsers'][$browser['browserName']] = $this->getFormFieldsForBrowserApi($object, $browser['relation'], $browser['model'], $browser['routePrefix'], $browser['titleKey'], $browser['moduleName']);
        }

        return $fields;
    }
}
