<?php

namespace App\Http\Requests\Form;

class EventPlanningContactRequest extends FormRequest
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

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $this->validateCaptcha($validator);
        });
    }

}
