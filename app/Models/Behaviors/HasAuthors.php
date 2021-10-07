<?php

namespace App\Models\Behaviors;

use App\Helpers\StringHelpers;

trait HasAuthors
{
    public function authors()
    {
        return $this->morphToMany('App\Models\Author', 'authorable')->orderBy('position');
    }

    /**
     * Meant for listings.
     */
    public function showAuthors()
    {
        if ($this->authors->isNotEmpty()) {
            $names = $this->authors->pluck('title')->all();

            return StringHelpers::summation($names);
        }

        if ($this->author_display) {
            return $this->author_display;
        }
    }

    /**
     * Meant for sidebar.
     */
    public function showAuthorsWithLinks()
    {
        if ($this->authors->isNotEmpty()) {
            $links = $this->authors->map(function ($author) {
                if (!$author->published) {
                    return $author->title;
                }

                return '<a href="' . route('authors.show', [
                    'id' => $author->id,
                    'slug' => $author->getSlug(),
                ]) . '" rel="author">' . $author->title . '</a>';
            })->all();

            return StringHelpers::summation($links);
        }

        if ($this->author_display) {
            return '<span itemprop="author">' . $this->author_display . '</span>';
        }
    }
}
