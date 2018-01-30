<?php

namespace App\Repositories\Api;

use A17\CmsToolkit\Repositories\ModuleRepository;
use App\Repositories\Behaviors\HandleApiRelations;

abstract class BaseApiRepository extends ModuleRepository
{
    use HandleApiRelations;

    public function filter($query, array $scopes = [])
    {
        // Perform a search first and then filter.
        // Because endpoints are different is preferable to acknoledge a search before
        // computing the rest of the filters
        $this->searchIn($query, $scopes, 'search', []);

        return parent::filter($query, $scopes);
    }

    public function searchIn($query, &$scopes, $scopeField, $orFields = [])
    {
        if (isset($scopes[$scopeField]) && is_string($scopes[$scopeField])) {
            $query->search($scopes[$scopeField]);
            unset($scopes[$scopeField]);
        }
    }

}
