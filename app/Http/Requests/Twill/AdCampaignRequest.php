<?php

namespace App\Http\Requests\Twill;

use A17\Twill\Http\Requests\Admin\Request;
use App\Rules\InnerTextLength;

class AdCampaignRequest extends Request
{
    public function rulesForCreate(): array
    {
        return [
            'title' => 'required',
        ];
    }

    public function rulesForUpdate(): array
    {
        return [
            'title' => 'required',
        ];
    }
}
