<?php

namespace App\Http\Requests\Twill;

use A17\Twill\Http\Requests\Admin\Request;

class PageRequest extends Request
{
    public function rules(): array
    {
        return $this->rulesForTranslatedFields([
            // Regular rules
        ], [
            // Translated fields
        ]);
    }
}
