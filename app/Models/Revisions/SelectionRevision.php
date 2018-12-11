<?php

namespace App\Models\Revisions;

use A17\Twill\Models\Revision;

class SelectionRevision extends Revision
{
    protected $table = "selection_revisions";

    protected $touches = ['selection'];

    public function selection()
    {
        return $this->belongsTo('App\Models\Selection');
    }

}
