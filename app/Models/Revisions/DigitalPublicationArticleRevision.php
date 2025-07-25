<?php

namespace App\Models\Revisions;

use A17\Twill\Models\Revision;

class DigitalPublicationArticleRevision extends Revision
{
    protected $table = 'digital_publication_article_revisions';

    protected $touches = ['digitalPublicationArticle'];

    public function digitalPublicationArticle()
    {
        return $this->belongsTo('App\Models\DigitalPublicationArticle');
    }
}
