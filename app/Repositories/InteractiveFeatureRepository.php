<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use App\Models\Experience;
use App\Models\InteractiveFeature;
use Illuminate\Database\Eloquent\Builder;

class InteractiveFeatureRepository extends ModuleRepository
{
    use HandleSlugs;
    use HandleRevisions;
    use HandleMedias;
    use HandleBlocks;

    public function __construct(InteractiveFeature $model)
    {
        $this->model = $model;
    }

    public function order(Builder $query, array $orders = []): Builder
    {
        $orders['title'] ??= 'desc';
        unset($orders['created_at']);

        return parent::order($query, $orders);
    }

    public function getCountByStatusSlug(string $slug, array $scope = []): int
    {
        $scope = $scope + ['archived' => false];

        return parent::getCountByStatusSlug($slug, $scope);
    }

    public function search($search)
    {
        return Experience::where('title', 'ILIKE', "%{$search}%")->published();
    }
}
