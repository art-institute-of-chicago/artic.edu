<?php

namespace App\Http\Requests\Admin;

use A17\CmsToolkit\Http\Requests\Admin\Request;

class ArticleRequest extends Request
{
    public function rules()
    {
        $rules = [
            'title' => 'required'
        ];

        $rules['date'] = 'date_format:m/d/Y H:i';

        return $rules;
    }
}
