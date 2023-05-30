<?php

namespace App\Models\Revisions;

use A17\Twill\Models\Revision;

class LandingPageRevision extends Revision
{
    protected $table = 'landing_page_revisions';

    protected $touches = ['landingPage'];

    public function landingPage()
    {
        return $this->belongsTo('App\Models\LandingPage');
    }
}
