<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

class IlluminatedLinkPresenter extends BasePresenter
{
    public function title_display() // phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    {
        return $this->title;
    }

    public function list_description() // phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    {
        return $this->description;
    }
}
