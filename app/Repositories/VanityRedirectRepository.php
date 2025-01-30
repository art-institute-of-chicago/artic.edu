<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleRevisions;
use App\Models\VanityRedirect;
use Illuminate\Database\Eloquent\Builder;

class VanityRedirectRepository extends ModuleRepository
{
    use HandleRevisions;

    public function __construct(VanityRedirect $model)
    {
        $this->model = $model;
    }

    public function order(Builder $query, array $orders = []): Builder
    {
        // Default sort by path instead of created_at.
        $orders['path'] ??= 'asc';
        unset($orders['created_at']);
        return parent::order($query, $orders);
    }
}
