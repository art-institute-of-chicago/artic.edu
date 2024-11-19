<?php

namespace App\Presenters\Admin;

use Illuminate\Support\Str;
use App\Presenters\BasePresenter;
use App\Enums\DigitalPublicationArticleType;

class DigitalPublicationArticlePresenter extends BasePresenter
{
    public function getCanonicalUrl()
    {
        if ($this->entity->article_type === DigitalPublicationArticleType::Grouping) {
            return route(
                'collection.publications.digital-publications.showListing',
                [
                    'id' => $this->entity->digitalPublication->id,
                    'slug' => $this->entity->digitalPublication->getSlug()
                ]
            ) . '#' . Str::kebab($this->entity->title);
        } else {
            return $this->getArticleUrl($this->entity->digitalPublication);
        }
    }

    public function articleType()
    {
        return $this->entity->article_type->name;
    }

    public function type()
    {
        return 'Digital Publication Article';
    }

    public function subtype()
    {
        return 'From The Digital Publication';
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
        if ($this->entity->children->count() > 0 && !$showAll) {
            $totalChildrenCount = $this->countAllChildren($this->entity);
            return [
                [
                    'label' => 'Browse all ' . $totalChildrenCount . ' ' . $this->entity->title,
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

    public function countAllChildren($entity)
    {
        $descendants = $entity->descendants;

        $filteredDescendants = $descendants->filter(function ($descendant) {
            return $descendant->article_type !== DigitalPublicationArticleType::Grouping;
        });

        return $filteredDescendants->count();
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

    public function isArticleInTree($items)
    {
        foreach ($items as $childItem) {
            if ($childItem->id === $this->entity->id) {
                return true;
            }
            if (count($childItem->children) > 0 && $this->isArticleInTree($childItem->children)) {
                return true;
            }
        }
        return false;
    }
}
