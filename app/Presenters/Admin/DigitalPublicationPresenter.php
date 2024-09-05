<?php

namespace App\Presenters\Admin;

use App\Enums\DigitalPublicationArticleType;
use App\Presenters\BasePresenter;

class DigitalPublicationPresenter extends BasePresenter
{
    /**
     * This is an associative array, keyed by article type.
     * It will also have an `all` key, containing all articles.
     * This is done to reduce the number of DB queries.
     */
    private $articles = [];

    public function getCanonicalUrl()
    {
        return route('collection.publications.digital-publications.show', [
            'id' => $this->entity->id,
            'slug' => $this->entity->getSlug(),
        ]);
    }

    public function date()
    {
        if ($this->entity->date) {
            return $this->entity->date->format('M j, Y');
        }
    }

    public function hasArticles($type = null)
    {
        return $this->getArticles($type)->count() > 0;
    }

    public function getArticles($type = null)
    {
        if (!isset($this->articles['all'])) {
            $this->articles['all'] = $this->entity
                ->articles()
                ->published()
                ->ordered()
                ->get();
        }

        if (!isset($type)) {
            return $this->articles['all'];
        }

        if (!isset($this->articles[$type])) {
            $this->articles[$type] = $this->articles['all']
                ->filter(function ($article) use ($type) {
                    return $article->type->value === $type;
                })
                ->values();
        }

        return $this->articles[$type];
    }

    protected function isDscStub()
    {
        return $this->entity->is_dsc_stub ? 'Yes' : 'No';
    }

    public function topLevelArticles()
    {
        return $this->entity->articles()->published()->ordered()->whereNull('parent_id')->get();
    }

    public function headerTitle()
    {
        return $this->entity->header_title_display ?? $this->entity->title_display;
    }

    public function headerSubtitle()
    {
        return $this->entity->header_subtitle_display;
    }

    public function blocks()
    {
        if (!$this->entity->is_dsc_stub) {
            $return = '<h1>' . $this->entity->title . '</h1>';
            $return .= $this->entity->welcome_note_display;
            $return .= '<p>';

            foreach ($this->entity->articles as $article) {
                $return .= $article->title . '<br/>';
            }
            $return .= '</p>';

            return $return;
        }

        return $this->entity->blocks;
    }
}
