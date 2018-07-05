<?php

namespace App\Http\Requests\Form;

use A17\Twill\Http\Requests\Admin\Request;

class EventPlanningContactRequest extends Request
{
    public function rules()
    {
        return [
            'name' => 'sometimes',
            'company' => 'sometimes',
            'email' => 'sometimes',
            'phone_number' => 'sometimes',
            'preferred_contact' => 'sometimes',
            'event_description' => 'sometimes',
            'dates' => 'sometimes',
            'know_more_about' => 'sometimes',
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}
