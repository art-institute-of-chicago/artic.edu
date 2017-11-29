<?php

namespace App\Http\Requests\Admin;

use A17\CmsToolkit\Http\Requests\Admin\Request;

class PageRequest extends Request
{
    public function rules()
    {
        return $this->rulesForTranslatedFields([
            // regular rules
        ], [
            // translated fields
            // 'title' => 'required'
        ]);
    }
}
