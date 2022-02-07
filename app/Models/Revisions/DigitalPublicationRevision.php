<?php

namespace App\Models\Revisions;

use A17\Twill\Models\Revision;

class DigitalPublicationRevision extends Revision
{
    protected $table = 'digital_publication_revisions';

    protected $touches = ['digitalPublication'];

    public function digitalPublication()
    {
        return $this->belongsTo('App\Models\DigitalPublication');
    }
}
