<?php

namespace App\Repositories\Api;

use A17\Twill\Models\Model;
use App\Repositories\ModuleRepository;
use App\Repositories\Behaviors\HandleApiRelations;

abstract class BaseApiRepository extends ModuleRepository
{
    use HandleApiRelations;

    public function getById($id, $with = [], $withCount = []): \A17\Twill\Models\Contracts\TwillModelContract
    {
        $item = $this->model->with($with)->withCount($withCount)->findOrFail($id);

        if ($item instanceof Model) {
            return $item->refreshApi();
        }

        return $item;
    }

    public function filter(\Illuminate\Database\Eloquent\Builder $query, array $scopes = []): \Illuminate\Database\Eloquent\Builder
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

    public function forSearchQuery($string, $perPage = null, $columns = [], $pageName = 'page', $page = null, $options = [])
    {
        // Build the search query
        $search = $this->model->search($string);

        // Perform the query
        $results = $search->getSearch($perPage, $columns, $pageName, $page, $options);

        return $results;
    }
}
