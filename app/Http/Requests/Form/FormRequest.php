<?php

namespace App\Http\Requests\Form;

use A17\Twill\Http\Requests\Admin\Request;

class FormRequest extends Request
{

    public function validateCaptcha($validator)
    {
        $fields = array(
            'secret' => urlencode(config('forms.recaptcha_secret')),
            'response' => urlencode($_POST['g-recaptcha-response']),
        );
        $fields_string = '';
        foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
        rtrim($fields_string, '&');

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

        ob_start();
        curl_exec($ch);
        curl_close($ch);
        $string = ob_get_contents();
        ob_end_clean();
        $res = json_decode($string);

        if (!$res->success)
        {
            $validator->errors()->add('captcha', 'Your captcha is invalid');
        }
    }
}
