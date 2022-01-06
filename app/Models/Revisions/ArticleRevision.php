<?php

namespace App\Models\Revisions;

use A17\Twill\Models\Revision;

class ArticleRevision extends Revision
{
    protected $table = 'article_revisions';

    protected $touches = ['article'];

    public function article()
    {
        return $this->belongsTo('App\Models\Article');
    }
}
