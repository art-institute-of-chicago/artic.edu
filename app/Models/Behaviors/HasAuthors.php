<?php

use Illuminate\Support\Facades\App;

namespace App\Models\Behaviors;

/**
 * TODO: Requires HasRelations. Shouldn't this just extend HasRelations, then?
 */
trait HasAuthors
{
    public function authors()
    {
        return $this->morphToMany('App\Models\Author', 'authorable')->orderBy('position');
    }
}
