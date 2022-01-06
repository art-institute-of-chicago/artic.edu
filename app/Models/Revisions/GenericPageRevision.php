<?php

namespace App\Models\Revisions;

use A17\Twill\Models\Revision;

class GenericPageRevision extends Revision
{
    protected $table = 'generic_page_revisions';

    protected $touches = ['genericPage'];

    public function genericPage()
    {
        return $this->belongsTo('App\Models\GenericPage');
    }
}
