<?php

namespace App\Http\Requests\Admin;

use App\Models\Event;
use Illuminate\Validation\Rule;

use A17\Twill\Http\Requests\Admin\Request;

class EventRequest extends Request
{
    public function rulesForCreate() {
        return [];
    }

    public function rulesForUpdate()
    {
        $rules = [
            'start_time' => 'required',
            'end_time'   => 'required',
            'short_description'   => 'required',
            'event_host_id'   => [
                'required_if:add_to_event_email_series,true',
                Rule::notIn([Event::NULL_OPTION_EVENT_HOST]),
            ]
        ];

        return $rules;
    }
}
