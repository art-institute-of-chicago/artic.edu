<?php

namespace App\Repositories\Behaviors;

use A17\Twill\Models\Contracts\TwillModelContract;
use Illuminate\Support\Collection;

/**
 * Mimic Twill's generalized behavior for API browsers
 *
 * @see A17\Twill\Repositories\Behaviors\HandleBrowsers
 */
trait HandleApiBrowsers
{
    protected $apiBrowsers = [];

    protected function getApiBrowsers(): Collection
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

    public function afterSaveHandleApiBrowsers(TwillModelContract $object, array $fields): void
    {
        foreach ($this->getApiBrowsers() as $browser) {
            $this->updateBrowserApiRelated($object, $fields, $browser['browserName']);
        }
    }

    public function getFormFieldsHandleApiBrowsers(TwillModelContract $object, array $fields): array
    {
        foreach ($this->getApiBrowsers() as $browser) {
            $fields['browsers'][$browser['browserName']] = $this->getFormFieldsForBrowserApi($object, $browser['relation'], $browser['model'], $browser['routePrefix'], $browser['titleKey'], $browser['moduleName']);
        }

        return $fields;
    }
}
