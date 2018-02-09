<?php

use Illuminate\Support\Facades\App;

namespace App\Models\Behaviors;

trait HasApiRelations
{
    protected $defaultApiRelationships = [];

    /**
    * Define the base element
    *
    */
    public function apiElements()
    {
        return $this->morphToMany(\App\Models\ApiRelation::class, 'api_relatable')->withPivot(['position', 'relation'])->orderBy('position');
    }

    public function exhibitions()
    {
        return $this->apiElements()->where('relation', 'exhibitions');
    }

    public function getApiRelationships() {
        return array_merge($this->defaultApiRelationships, $this->apiRelationships);
    }
}
