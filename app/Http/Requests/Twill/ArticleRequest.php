<?php

namespace App\Http\Requests\Admin;

use A17\Twill\Http\Requests\Admin\Request;

class ArticleRequest extends Request
{
    public function rulesForCreate()
    {
        return [];
    }

    public function rulesForUpdate()
    {
        return [
            'date' => 'required',
            'heading' => 'max:255',
            'list_description' => 'max:255',
            'citations' => 'max:255',
            'hero_caption' => 'max:255'
        ];
    }
}
