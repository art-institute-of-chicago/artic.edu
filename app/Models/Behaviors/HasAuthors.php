<?php

namespace App\Models\Behaviors;

trait HasAuthors
{
    public function authors()
    {
        return $this->morphToMany('App\Models\Author', 'authorable')->orderBy('position');
    }

    public function showAuthors()
    {
        if ($this->authors->isNotEmpty()) {
            $names = $this->authors->pluck('title')->all();

            return summation($names);
        }

        if ($this->author_display) {
            return $this->entity->author_display;
        }
    }
}
