<?php

namespace App\Jobs;

use App\Models\GenericPage;

class ReorderPages extends BaseJob
{
    protected $nodesArray;

    public function __construct($nodesArray)
    {
        $this->nodesArray = $nodesArray;
    }

    public function handle()
    {
        GenericPage::saveTreeFromIds($this->nodesArray);
    }
}
