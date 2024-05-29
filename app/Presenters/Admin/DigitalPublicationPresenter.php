<?php

namespace App\Presenters\Admin;

use App\Models\DigitalPublicationArticle;
use App\Presenters\BasePresenter;

class DigitalPublicationPresenter extends BasePresenter
{
    /**
     * Formatted specifically for `_o-accordion`.
     */
    private $articlesForSidebar = [];

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
                    return $article->type === $type;
                })
                ->values();
        }

        return $this->articles[$type];
    }

    protected function isDscStub()
    {
        return $this->entity->is_dsc_stub ? 'Yes' : 'No';
    }

    public function articlesForSidebar($currentArticle = null)
    {
        if (!$this->articlesForSidebar) {
            foreach (array_keys(DigitalPublicationArticle::$types) as $type) {
                if (!$this->hasArticles($type)) {
                    continue;
                }

                $this->articlesForSidebar[] = [
                    'title' => DigitalPublicationArticle::$types[$type],
                    'active' => !isset($currentArticle) || $currentArticle->type === $type,
                    'blocks' => [
                        [
                            'type' => 'link-list',
                            'links' => $this
                                ->getArticles($type)
                                ->map(function ($article) use ($currentArticle) {
                                    return [
                                        'label' => $article->title_display ?? $article->title,
                                        'sublabel' => $article->type === DigitalPublicationArticle::TEXT ? $article->showAuthors() : null,
                                        'href' => $article->present()->getArticleUrl($this->entity),
                                        'active' => isset($currentArticle) && $article->id === $currentArticle->id,
                                    ];
                                }),
                        ],
                    ],
                ];
            }
        }

        return $this->articlesForSidebar;
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
