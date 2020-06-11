<?php

use Illuminate\Support\Facades\App;

namespace App\Models\Behaviors;

trait HasAuthors
{
    public function authors()
    {
        return $this->morphToMany('App\Models\Author', 'authorable')->orderBy('position');
    }
}
