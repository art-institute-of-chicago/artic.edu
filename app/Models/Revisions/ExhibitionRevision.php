<?php

namespace App\Models\Revisions;

use A17\Twill\Models\Revision;

class ExhibitionRevision extends Revision
{
    protected $table = "exhibition_revisions";

    protected $touches = ['exhibition'];

    public function exhibition()
    {
        return $this->belongsTo('App\Models\Exhibition');
    }

}
