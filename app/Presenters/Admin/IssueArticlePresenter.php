<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

class IssueArticlePresenter extends BasePresenter
{
    private $articlesForLanding;

    public function shortTitle()
    {
        return $this->entity->short_title_display ?? $this->entity->title_display ?? $this->entity->title;
    }

    public function date()
    {
        if ($this->entity->date) {
            return $this->entity->date->format('M j, Y');
        }
    }

    public function issueNumber()
    {
        if ($this->entity->issue) {
            return $this->entity->issue->issue_number;
        }
    }

    public function issueTitle()
    {
        if ($this->entity->issue) {
            return $this->entity->issue->title_display ?? $this->entity->issue->title;
        }
    }

    public function listDescription()
    {
        return strip_tags($this->entity->list_description, ['i']);
    }

    public function pdfDownloadPath()
    {
        if (!isset($this->entity->pdf_download_path)) {
            return;
        }

        return config('aic.pdf_s3_endpoint') . $this->entity->pdf_download_path;
    }

    public function articlesForSidebar()
    {
        $currentArticle = $this->entity;

        return $this->articlesForSidebar ?? $this->articlesForSidebar = [
            [
                'title' => 'View other articles',
                'active' => false,
                'blocks' => [
                    [
                        'type' => 'link-list',
                        'links' => $this->entity
                            ->issue
                            ->present()
                            ->articlesForLanding()
                            ->map(function ($article) use ($currentArticle) {
                                return [
                                    'label' => $article->title_display ?? $article->title,
                                    'sublabel' => $article->showAuthors(),
                                    'href' => $article->url,
                                    'active' => $article->id === $currentArticle->id,
                                ];
                            }),
                    ],
                ],
            ],
        ];
    }

    public function getArticleType()
    {
        if (isset($this->entity->type_display)) {
            return $this->entity->type_display;
        }

        return 'Article';
    }

    /**
     * PUB-146: For `_articleFeature` view on Writings
     */
    public function subtype()
    {
        return $this->getArticleType();
    }

    /**
     * PUB-84: For search results
     */
    public function subtypeForSearch()
    {
        return 'Issue ' . $this->issueNumber() . ': ' . $this->entity->issue->title;
    }

    public function references()
    {

    }

    public function citeAs()
    {
        if (empty($this->entity->cite_as)) {
            return;
        }

        return $this->addCssClass($this->entity->cite_as, 'f-secondary');
    }
}
