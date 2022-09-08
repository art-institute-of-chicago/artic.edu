<?php

namespace App\Http\Controllers\API\Behaviors;

trait HideUnlisted
{
    /**
     * API-331: If this trait is applied to a controller that is a child of
     * BaseController, it will also only show published items, so long as
     * we retain the call to the `published` scope in BaseController.
     */
    protected function getBaseQuery()
    {
        return parent::getBaseQuery()->notUnlisted();
    }
}
