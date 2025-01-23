<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use App\Models\Sponsor;
use Illuminate\Database\Eloquent\Builder;

class SponsorRepository extends ModuleRepository
{
    use HandleBlocks;

    public function __construct(Sponsor $model)
    {
        $this->model = $model;
    }

    public function order(Builder $query, array $orders = []): Builder
    {
        // Default sort by title instead of created_at.
        $orders['title'] ??= 'asc';
        unset($orders['created_at']);
        return parent::order($query, $orders);
    }
}
