<?php

namespace App\Repositories;

use App\Models\PlaylistVideo;
use Illuminate\Database\Eloquent\Builder;

class PlaylistVideoRepository extends ModuleRepository
{
    public function __construct(PlaylistVideo $model)
    {
        $this->model = $model;
    }

    public function order($query, array $orders = []): Builder
    {
        // Default sort by position instead of created_at.
        $orders['position'] ??= 'asc';
        unset($orders['created_at']);
        return parent::order($query, $orders);
    }
}
