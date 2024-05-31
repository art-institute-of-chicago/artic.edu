<?php

namespace App\Presenters\Admin;

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
}
