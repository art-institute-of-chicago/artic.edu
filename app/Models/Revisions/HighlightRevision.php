<?php

namespace App\Models\Revisions;

use A17\Twill\Models\Revision;

class HighlightRevision extends Revision
{
    protected $table = 'highlight_revisions';

    protected $touches = ['highlight'];

    public function highlight()
    {
        return $this->belongsTo('App\Models\Highlight');
    }
}
