<?php

namespace App\Models\Revisions;

use A17\Twill\Models\Revision;

class PressReleaseRevision extends Revision
{
    protected $table = "press_release_revisions";

    protected $touches = ['pressRelease'];

    public function pressRelease()
    {
        return $this->belongsTo('App\Models\PressRelease');
    }

}
