<?php

namespace App\Models\Revisions;

use A17\Twill\Models\Revision;

class PrintedPublicationRevision extends Revision
{
    protected $table = 'printed_publication_revisions';

    protected $touches = ['printedPublication'];

    public function printedPublication()
    {
        return $this->belongsTo('App\Models\PrintedPublication');
    }
}
