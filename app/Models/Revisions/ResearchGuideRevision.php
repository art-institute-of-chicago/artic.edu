<?php

namespace App\Models\Revisions;

use A17\Twill\Models\Revision;

class ResearchGuideRevision extends Revision
{
    protected $table = "research_guide_revisions";

    protected $touches = ['researchGuide'];

    public function researchGuide()
    {
        return $this->belongsTo('App\Models\ResearchGuide');
    }

}
