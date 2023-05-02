<?php

namespace App\Models\Revisions;

use A17\Twill\Models\Revision;

class LandingPageRevision extends Revision
{
    protected $table = 'landing_page_revisions';

    protected $touches = ['landing_page'];

    public function landing_page()
    {
        return $this->belongsTo('App\Models\LandingPage');
    }
}
