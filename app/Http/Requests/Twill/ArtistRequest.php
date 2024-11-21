<?php

namespace App\Http\Requests\Twill;

use A17\Twill\Http\Requests\Admin\Request;

class ArtistRequest extends Request
{
    public function rulesForCreate()
    {
        return [
            'title' => 'required',
        ];
    }

    public function rulesForUpdate()
    {
        return [
            'title' => 'required',
            'datahub_id' => 'required',
        ];
    }
}
