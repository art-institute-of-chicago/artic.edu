<?php

namespace App\Models\Revisions;

use A17\Twill\Models\Revision;

class EducatorResourceRevision extends Revision
{
    protected $table = "educator_resource_revisions";

    protected $touches = ['educatorResource'];

    public function educatorResource()
    {
        return $this->belongsTo('App\Models\EducatorResource');
    }

}
