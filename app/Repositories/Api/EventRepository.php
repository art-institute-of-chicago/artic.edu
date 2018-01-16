<?php

namespace App\Repositories\Api;

use A17\CmsToolkit\Repositories\Behaviors\HandleSlugs;
use A17\CmsToolkit\Repositories\ModuleRepository;

use App\Models\Api\Event;

class EventRepository extends ModuleRepository
{
    use HandleSlugs;

    public function __construct(Event $model)
    {
        $this->model = $model;
    }

    public function getById($id, $with = [], $withCount = [])
    {
        return $this->model->with($with)->find($id);
    }

}
