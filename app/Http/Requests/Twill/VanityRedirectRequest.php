<?php

namespace App\Http\Requests\Twill;

use A17\Twill\Http\Requests\Admin\Request;

class VanityRedirectRequest extends Request
{
    public function rulesForCreate()
    {
        return [
            'path' => 'required|alpha_dash',
            'destination' => 'required',
        ];
    }

    public function rulesForUpdate()
    {
        return $this->rulesForCreate();
    }
}
