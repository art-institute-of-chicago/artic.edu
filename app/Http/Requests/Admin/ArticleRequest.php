<?php

namespace App\Http\Requests\Admin;

use A17\Twill\Http\Requests\Admin\Request;

class ArticleRequest extends Request
{
    public function rules()
    {
        $rules = [
            'title' => 'required',
            'heading' => 'max:255',
        ];

        // $rules['date'] = 'date_format:m/d/Y H:i';

        return $rules;
    }
}
