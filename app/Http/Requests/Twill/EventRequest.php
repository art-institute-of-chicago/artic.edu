<?php

namespace App\Http\Requests\Twill;

use App\Models\Event;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use A17\Twill\Http\Requests\Admin\Request;
use DateInterval;

class EventRequest extends Request
{
    /**
     * Adapted from https://stackoverflow.com/questions/29454798
     */
    public function __construct()
    {
        Validator::extend('time_greater_than', function ($attribute, $value, $parameters) {
            $startInterval = new DateInterval($this->start_time);
            $endInterval = new DateInterval($value);

            $start_time = $startInterval->h * 3600 + $startInterval->i * 60;
            $end_time = $endInterval->h * 3600 + $endInterval->i * 60;

            return $end_time > $start_time;
        });

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
        return [
            'title' => 'required',
        ];
    }

    public function rulesForUpdate()
    {
        return [
            'start_time' => 'required',
            'end_time' => 'required|time_greater_than',
            'short_description' => 'required',
            'list_description' => 'required',
            'repeaters.date_rule' => 'required|array|min:1',
            'repeaters.date_rule.*.type' => 'required',
            'repeaters.date_rule.*.start_date' => 'required|date',
            'repeaters.date_rule.*.every' => 'required',
            'event_host_id' => [
                'required_if:add_to_event_email_series,true',
                Rule::notIn([Event::NULL_OPTION_EVENT_HOST]),
            ],
            'test_emails' => 'emails',
        ];
    }

    public function messages()
    {
        return [
            'start_time.required' => 'The start time field is required.',
            'end_time.required' => 'The end time field is required.',
            'end_time.time_greater_than' => 'The end time must be greater than the start time.',
            'short_description.required' => 'A short description is required.',
            'list_description.required' => 'A list description is required.',
            'repeaters.date_rule.required' => 'At least one date rule must be added.',
            'repeaters.date_rule.array' => 'Date rules must be in the correct format.',
            'repeaters.date_rule.min' => 'You must add at least one date rule!',
            'repeaters.date_rule.*.type' => 'Please specify a date rule type',
            'repeaters.date_rule.*.start_date.required' => 'The start date is required for each date rule.',
            'repeaters.date_rule.*.start_date.date' => 'Please provide a valid date format.',
            'repeaters.date_rule.*.every.required' => 'Please provide an repeat interval',
            'event_host_id.required_if' => 'An event host must be selected when adding to the email series.',
            'test_emails.emails' => 'Please enter valid email addresses separated by commas.',
        ];
    }
}
