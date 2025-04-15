<?php

namespace App\Repositories\Api;

use Illuminate\Database\Eloquent\Builder;
use A17\Twill\Models\Model;
use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Facades\TwillPermissions;
use App\Repositories\ModuleRepository;
use App\Repositories\Behaviors\HandleApiRelations;

abstract class BaseApiRepository extends ModuleRepository
{
    use HandleApiRelations;

    public function getById($id, $with = [], $withCount = []): TwillModelContract
    {
        $item = $this->model->with($with)->withCount($withCount)->findOrFail($id);

        if ($item instanceof Model) {
            return $item->refreshApi();
        }

        return $item;
    }

    public function filter(Builder $query, array $scopes = []): Builder
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


    public function getCountByStatusSlug(string $slug, array $scope = []): int
    {
        $query = ($this->model->getApiModel())::query();

        if (
            TwillPermissions::enabled() &&
            (
                TwillPermissions::getPermissionModule(getModuleNameByModel($this->model)) ||
                method_exists($this->model, 'scopeAccessible')
            )
        ) {
            $query = $query->accessible();
        }

        switch ($slug) {
            case 'all':
                return $query->count();
        }

        return parent::getCountByStatusSlug($slug, $scope);
    }
}
