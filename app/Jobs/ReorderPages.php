<?php

namespace App\Jobs;

use App\Models\GenericPage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ReorderPages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $nodesArray;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($nodesArray)
    {
        $this->nodesArray = $nodesArray;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        GenericPage::saveTreeFromIds($this->nodesArray);
    }
}
