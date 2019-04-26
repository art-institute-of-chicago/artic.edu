<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

use Michelf\SmartyPants;

class BlockPresenter extends BasePresenter
{

    public function input($name)
    {
        return SmartyPants::defaultTransform($this->entity->input($name));
    }

}
