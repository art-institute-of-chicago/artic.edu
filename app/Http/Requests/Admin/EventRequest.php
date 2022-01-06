<?php

namespace App\Http\Requests\Admin;

use App\Models\Event;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

use A17\Twill\Http\Requests\Admin\Request;

class EventRequest extends Request
{
    /**
     * Adapted from https://stackoverflow.com/questions/29454798
     */
    public function __construct()
    {
        Validator::extend('emails', function ($attribute, $value, $parameters) {
            $values = array_map('trim', array_filter(explode(',', rtrim($this->test_emails, ','))));

            if (count($values) < 1) {
                return true;
            }

            foreach ($values as $email) {
                $validator = Validator::make([
                    'email' => $email
                ], [
                    'email' => 'required|email',
                ]);

                if ($validator->fails()) {
                    return false;
                }
            }

            return true;
        });
    }

    public function rulesForCreate()
    {
        return [];
    }

    public function rulesForUpdate()
    {
        $rules = [
            'start_time' => 'required',
            'end_time' => 'required',
            'short_description' => 'required',
            'event_host_id' => [
                'required_if:add_to_event_email_series,true',
                Rule::notIn([Event::NULL_OPTION_EVENT_HOST]),
            ],
            'test_emails' => 'emails',
        ];

        return $rules;
    }
}
