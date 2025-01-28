<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleSlugs;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;

class CategoryRepository extends ModuleRepository
{
    use HandleSlugs;

    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    public function order(Builder $query, array $orders = []): Builder
    {
        // Default sort by name instead of created_at.
        $orders['name'] ??= 'asc';
        unset($orders['created_at']);
        return parent::order($query, $orders);
    }
}
