<?php

namespace App\Http\Requests\Admin;

use A17\Twill\Http\Requests\Admin\Request;

class PageRequest extends Request
{
    public function rules()
    {
        return $this->rulesForTranslatedFields([
            // Regular rules
        ], [
            // Translated fields
        ]);
    }
}
