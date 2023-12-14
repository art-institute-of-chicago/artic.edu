<?php

namespace App\Http\Requests\Admin;

use A17\Twill\Http\Requests\Admin\Request;

class LandingPageRequest extends Request
{
    public function rulesForCreate()
    {
        return [
            'type_id' => 'required'
        ];
    }

    public function rulesForUpdate()
    {
        return [
            'type_id' => 'required'
        ];
    }
}
