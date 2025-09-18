<?php

namespace App\Repositories;

use App\Models\Playlist;
use Illuminate\Database\Eloquent\Builder;

class PlaylistRepository extends ModuleRepository
{
    protected $browsers = [
        'videos' => [
            'routePrefix' => 'collection.articlesPublications',
        ],
    ];

    public function __construct(Playlist $model)
    {
        $this->model = $model;
    }

    public function order($query, array $orders = []): Builder
    {
        // Default sort by title instead of created_at.
        $orders['title'] ??= 'asc';
        unset($orders['created_at']);
        return parent::order($query, $orders);
    }
}
