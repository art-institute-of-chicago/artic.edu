<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

use App\Libraries\SmartyPants;

class BlockPresenter extends BasePresenter
{

    public function input($name)
    {
        return SmartyPants::defaultTransform($this->entity->input($name));
    }

}
