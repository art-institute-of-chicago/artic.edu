<?php

namespace App\Models\Revisions;

use A17\Twill\Models\Revision;

class PageRevision extends Revision
{
    protected $table = 'page_revisions';

    protected $touches = ['page'];

    public function page()
    {
        return $this->belongsTo('App\Models\Page');
    }
}
