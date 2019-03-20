<?php

namespace App\Http\Requests\Form;

class EmailSubscriptionsRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => 'required',
            'subscriptions' => 'sometimes',
            'unsubscribe' => 'sometimes',
            'first_name' => 'sometimes',
            'last_name' => 'sometimes',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $this->validateCaptcha($validator);
        });
    }

}
