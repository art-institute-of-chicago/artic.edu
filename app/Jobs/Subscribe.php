<?php

namespace App\Jobs;

use App\Libraries\ExactTargetService;

class Subscribe extends BaseJob
{
    private $email;

    public function __construct($email)
    {
        $this->email = $email;
    }

    public function handle()
    {
        $exactTarget = new ExactTargetService($this->email);
        return $exactTarget->subscribe(false);
    }
}
