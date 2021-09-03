<?php

namespace App\Http\Controllers\API\Behaviors;

trait HideUnlisted
{
    protected function getBaseQuery()
    {
        return parent::getBaseQuery()->notUnlisted();
    }
}
