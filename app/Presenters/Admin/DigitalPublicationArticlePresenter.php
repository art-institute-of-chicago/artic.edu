<?php

namespace App\Presenters\Admin;

use Illuminate\Support\Str;
use App\Presenters\BasePresenter;

class DigitalPublicationArticlePresenter extends BasePresenter
{
    public function getCanonicalUrl()
    {
        return $this->getArticleUrl($this->entity->digitalPublication);
    }

    public function type()
    {
        return $this->entity->type->name;
    }

    public function pdfDownloadPath()
    {
        if (!isset($this->entity->pdf_download_path)) {
            return;
        }

        return config('aic.pdf_s3_endpoint') . $this->entity->pdf_download_path;
    }

    public function getArticleUrl($digitalPublication, $article = null)
    {
        $article = $article ?? $this->entity;

        return route('collection.publications.digital-publications-articles.show', [
            'pubId' => $digitalPublication->id,
            'pubSlug' => $digitalPublication->slug,
            'id' => $article->id,
            'slug' => $article->slug,
        ]);
    }

    public function getBrowseMoreLink($showAll = false)
    {
        if ($this->entity->children->count() > 0  && !$showAll) {
            return [
                [
                    'label' => 'Browse all ' . $this->entity->children->count() . ' ' . $this->entity->title,
                    'href' => route(
                        'collection.publications.digital-publications.showListing',
                        [
                            'id' => $this->entity->digitalPublication->id,
                            'slug' => $this->entity->digitalPublication->getSlug()
                        ]
                    ) . '#' . Str::kebab($this->entity->title)
                ]
            ];
        }
        return '';
    }

    public function references()
    {
        if (empty($this->entity->references)) {
            return;
        }

        return $this->addCssClass($this->entity->references, 'f-secondary');
    }

    public function citeAs()
    {
        if (empty($this->entity->cite_as)) {
            return;
        }

        return $this->addCssClass($this->entity->cite_as, 'f-secondary');
    }

    public function isArticleInTree($items, $currentArticle)
    {
        foreach ($items as $childItem) {
            if ($childItem->id === $currentArticle->id) {
                return true;
            }
            if (count($childItem->children) > 0 && $this->isArticleInTree($childItem->children, $currentArticle)) {
                return true;
            }
        }
        return false;
    }
}
