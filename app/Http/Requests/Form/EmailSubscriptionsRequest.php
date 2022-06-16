<?php

namespace App\Http\Requests\Form;

class EmailSubscriptionsRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => 'required',
            'subscriptions' => 'sometimes',
            'unsubscribeFromAll' => 'sometimes',
            'first_name' => 'sometimes',
            'last_name' => 'sometimes',
        ];
    }

    public function withValidator($validator)
    {
        if (config('aic.disable_captcha')) {
            return;
        }

        $validator->after(function ($validator) {
            $this->validateCaptcha($validator);
        });
    }
}
