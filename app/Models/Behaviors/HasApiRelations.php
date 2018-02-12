<?php

use Illuminate\Support\Facades\App;

namespace App\Models\Behaviors;

trait HasApiRelations
{
    public function apiElements()
    {
        return $this->morphToMany(\App\Models\ApiRelation::class, 'api_relatable')->withPivot(['position', 'relation'])->orderBy('position');
    }

    public function apiModels($relation, $model)
    {
        // TODO: Generalize, optimize and refactor

        // Obtain the API class
        $modelClass = "\\App\\Models\\Api\\" . ucfirst($model);

        // Get all Ids
        $ids = $this->$relation->pluck('datahub_id')->toArray();

        // Load the API collection
        return $modelClass::query()->ids($ids)->get();
    }
}
