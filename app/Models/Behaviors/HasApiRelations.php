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
        // Obtain the API class
        $modelClass = "\\App\\Models\\Api\\" . ucfirst($model);

        // Get all Ids
        $ids = $this->$relation->pluck('datahub_id')->toArray();

        if (empty($ids)) {
            return collect();
        } else {
            // Load real the real models from the API
            $results = $modelClass::query()->ids($ids)->get();

            // Sort them by the original ids listing (coming from our CMS position attribute)
            $sorted = $results->sortBy(function($model, $key) use ($ids) {
                return collect($ids)->search(function($id, $key) use ($model) {
                    return $id == $model->id;
                });
            });

            return $sorted;
        }
    }
}
