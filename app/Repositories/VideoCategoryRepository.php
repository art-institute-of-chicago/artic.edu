<?php

namespace App\Repositories;

use A17\Twill\Repositories\ModuleRepository;
use App\Models\VideoCategory;
use Illuminate\Database\Eloquent\Builder;

class VideoCategoryRepository extends ModuleRepository
{
    public function __construct(VideoCategory $model)
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
