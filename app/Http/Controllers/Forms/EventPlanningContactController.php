<?php

namespace App\Http\Controllers\Forms;

use Illuminate\Support\Facades\Mail;

use App\Http\Requests\Form\EventPlanningContactRequest;

use App\Models\Form\EventPlanningContact;

use App\Mail\FormEventPlanningContact;

class EventPlanningContactController extends FormController
{
    public function index()
    {
        $this->title = 'Event Planning Contact';
        $this->seo->setTitle($this->title);

        $blocks = [];
        $formBlocks = [];
        $inquiryFields = [];
        $daytimeFields = [];

        $errors = session('errors');

        // Inquiry form
        $inquiryFields[] = [
            'variation' => null,
            'blocks' => [
                [
                    'type' => 'input',
                    'variation' => null,
                    'id' => 'name',
                    'placeholder' => '',
                    'textCount' => false,
                    'value' => old('name'),
                    'error' => (!empty($errors) && $errors->first('name')) ? $errors->first('name') : null,
                    'optional' => false,
                    'hint' => null,
                    'disabled' => false,
                    'label' => 'Name *',
                ],
            ],
        ];

        $inquiryFields[] = [
            'variation' => null,
            'blocks' => [
                [
                    'type' => 'input',
                    'variation' => null,
                    'id' => 'address_1',
                    'placeholder' => '',
                    'textCount' => false,
                    'value' => old('address_1'),
                    'error' => (!empty($errors) && $errors->first('address_1')) ? $errors->first('address_1') : null,
                    'optional' => null,
                    'hint' => null,
                    'disabled' => false,
                    'label' => 'Street address',
                ],
            ],
        ];

        $inquiryFields[] = [
            'variation' => null,
            'blocks' => [
                [
                    'type' => 'input',
                    'variation' => null,
                    'id' => 'address_2',
                    'placeholder' => '',
                    'textCount' => false,
                    'value' => old('address_2'),
                    'error' => (!empty($errors) && $errors->first('address_2')) ? $errors->first('address_2') : null,
                    'optional' => null,
                    'hint' => null,
                    'disabled' => false,
                    'label' => 'Apartment or suite',
                ],
            ],
        ];

        $inquiryFields[] = [
            'variation' => null,
            'blocks' => [
                [
                    'type' => 'input',
                    'variation' => null,
                    'id' => 'city',
                    'placeholder' => '',
                    'textCount' => false,
                    'value' => old('city'),
                    'error' => (!empty($errors) && $errors->first('city')) ? $errors->first('city') : null,
                    'optional' => null,
                    'hint' => null,
                    'disabled' => false,
                    'label' => 'City',
                ],
            ],
        ];

        $inquiryFields[] = [
            'variation' => null,
            'blocks' => [
                [
                    'type' => 'select',
                    'variation' => 'm-fieldset__input-narrow-x3',
                    'id' => 'state',
                    'error' => (!empty($errors) && $errors->first('state')) ? $errors->first('state') : null,
                    'optional' => null,
                    'hint' => null,
                    'disabled' => false,
                    'value' => old('state'),
                    'label' => 'State',
                    'options' => $this->getStatesArray(),
                ],
                [
                    'type' => 'input',
                    'variation' => 'm-fieldset__input-narrow-x3',
                    'id' => 'zipcode',
                    'placeholder' => '',
                    'textCount' => false,
                    'value' => old('zipcode'),
                    'error' => (!empty($errors) && $errors->first('zipcode')) ? $errors->first('zipcode') : null,
                    'optional' => null,
                    'hint' => null,
                    'disabled' => false,
                    'label' => 'Zipcode',
                ],
            ],
        ];

        $inquiryFields[] = [
            'variation' => null,
            'blocks' => [
                [
                    'type' => 'select',
                    'variation' => null,
                    'id' => 'country',
                    'error' => (!empty($errors) && $errors->first('country')) ? $errors->first('country') : null,
                    'value' => old('country'),
                    'optional' => null,
                    'hint' => null,
                    'disabled' => false,
                    'label' => 'Country',
                    'options' => $this->getCountriesArray(),
                ],
            ],
        ];

        $inquiryFields[] = [
            'variation' => null,
            'blocks' => [
                [
                    'type' => 'input',
                    'variation' => null,
                    'id' => 'company',
                    'placeholder' => '',
                    'textCount' => false,
                    'value' => old('company'),
                    'error' => (!empty($errors) && $errors->first('company')) ? $errors->first('company') : null,
                    'optional' => null,
                    'hint' => null,
                    'disabled' => false,
                    'label' => 'Company',
                ],
            ],
        ];

        $inquiryFields[] = [
            'variation' => null,
            'blocks' => [
                [
                    'type' => 'email',
                    'variation' => null,
                    'id' => 'email',
                    'placeholder' => '',
                    'textCount' => false,
                    'value' => old('email'),
                    'error' => (!empty($errors) && $errors->first('email')) ? $errors->first('email') : null,
                    'optional' => false,
                    'hint' => null,
                    'disabled' => false,
                    'label' => 'Email *',
                ],
            ],
        ];

        $inquiryFields[] = [
            'variation' => null,
            'blocks' => [
                [
                    'type' => 'tel',
                    'variation' => null,
                    'id' => 'phone_number',
                    'placeholder' => '',
                    'textCount' => false,
                    'value' => old('phone_number'),
                    'error' => (!empty($errors) && $errors->first('phone_number')) ? $errors->first('phone_number') : null,
                    'optional' => false,
                    'hint' => null,
                    'disabled' => false,
                    'label' => 'Phone number *',
                ],
            ],
        ];

        $preferredContactFields = [
            'variation' => 'm-fieldset__field--group',
            'blocks' => [
                [
                    'type' => 'label',
                    'variation' => 'm-fieldset__group-label',
                    'error' => (!empty($errors) && $errors->first('preferred_contact')) ? $errors->first('preferred_contact') : null,
                    'optional' => null,
                    'hint' => null,
                    'label' => 'Preferred method of contact',
                ]
            ],
        ];
        foreach ($this->getPreferredContactArray(old('preferred_contact')) as $t) {
            array_push($preferredContactFields['blocks'], $t);
        }
        $inquiryFields[] = $preferredContactFields;

        $howDidYouHearFields = [
            'variation' => 'm-fieldset__field--group',
            'blocks' => [
                [
                    'type' => 'label',
                    'variation' => 'm-fieldset__group-label',
                    'error' => (!empty($errors) && $errors->first('how_did_you_hear')) ? $errors->first('how_did_you_hear') : null,
                    'optional' => null,
                    'hint' => 'Select all that apply',
                    'label' => 'How did you hear about us?',
                ],
            ],
        ];
        $items = $this->getHowDidYouHearArray(old('how_did_you_hear'));
        foreach ($items as $key => $d) {
            array_push($howDidYouHearFields['blocks'], $d);
        }
        $inquiryFields[] = $howDidYouHearFields;

        $inquiryFields[] = [
            'variation' => null,
            'blocks' => [
                [
                    'type' => 'input',
                    'variation' => null,
                    'id' => 'how_did_you_hear_other',
                    'placeholder' => '',
                    'textCount' => false,
                    'value' => old('how_did_you_hear_other'),
                    'error' => (!empty($errors) && $errors->first('how_did_you_hear_other')) ? $errors->first('how_did_you_hear_other') : null,
                    'optional' => null,
                    'hint' => null,
                    'disabled' => false,
                    'label' => 'Other',
                ],
            ],
        ];

        $areYouPlanningFields = [
            'variation' => 'm-fieldset__field--group',
            'blocks' => [
                [
                    'type' => 'label',
                    'variation' => 'm-fieldset__group-label',
                    'error' => (!empty($errors) && $errors->first('are_you_currently_planning')) ? $errors->first('are_you_currently_planning') : null,
                    'optional' => false,
                    'hint' => null,
                    'label' => 'Are you currently planning an event?',
                ]
            ],
        ];
        foreach ($this->getYesNoArray(old('are_you_currently_planning'), 'are_you_currently_planning') as $t) {
            array_push($areYouPlanningFields['blocks'], $t);
        }
        $inquiryFields[] = $areYouPlanningFields;

        $typeOfEventFields = [
            'variation' => 'm-fieldset__field--group',
            'blocks' => [
                [
                    'type' => 'label',
                    'variation' => 'm-fieldset__group-label',
                    'error' => (!empty($errors) && $errors->first('type_of_event')) ? $errors->first('type_of_event') : null,
                    'optional' => null,
                    'hint' => 'Select all that apply',
                    'label' => 'If so, what type of event do you have in mind?',
                ]
            ],
        ];
        foreach ($this->getTypeOfEventArray(old('type_of_event')) as $d) {
            array_push($typeOfEventFields['blocks'], $d);
        }
        $inquiryFields[] = $typeOfEventFields;

        $inquiryFields[] = [
            'variation' => null,
            'blocks' => [
                [
                    'type' => 'input',
                    'variation' => null,
                    'id' => 'type_of_event_other',
                    'placeholder' => '',
                    'textCount' => false,
                    'value' => old('type_of_event_other'),
                    'error' => (!empty($errors) && $errors->first('type_of_event_other')) ? $errors->first('type_of_event_other') : null,
                    'optional' => null,
                    'hint' => null,
                    'disabled' => false,
                    'label' => 'Other',
                ],
            ],
        ];

        // Daytime information
        $daytimeFields[] = [
            'variation' => null,
            'blocks' => [
                [
                    'type' => 'input',
                    'variation' => null,
                    'id' => 'no_of_expected_guests',
                    'placeholder' => '',
                    'textCount' => false,
                    'value' => old('no_of_expected_guests'),
                    'error' => (!empty($errors) && $errors->first('no_of_expected_guests')) ? $errors->first('no_of_expected_guests') : null,
                    'optional' => false,
                    'hint' => null,
                    'disabled' => false,
                    'label' => 'Number of expected guests',
                ],
            ],
        ];

        $daytimeFields[] = [
            'variation' => null,
            'blocks' => [
                [
                    'type' => 'text',
                    'content' => '<span class="input s-disabled"><label class="label f-secondary">Possible Dates *'
                    . '<em class="label__hint">Please select 3 options for the date of your event.</em></label></span>'
                ],
            ],
        ];

        $daytimeFields[] = [
            'variation' => null,
            'blocks' => [
                [
                    'type' => 'date-select',
                    'variation' => 'm-fieldset__input-narrow-x3',
                    'id' => 'possible_date_1',
                    'placeholder' => 'mm/dd/yy',
                    'value' => old('possible_date_1'),
                    'error' => (!empty($errors) && $errors->first('possible_date_1')) ? $errors->first('possible_date_1') : null,
                    'optional' => false,
                    'hint' => null,
                    'disabled' => false,
                    'label' => '',
                ],
                [
                    'type' => 'date-select',
                    'variation' => 'm-fieldset__input-narrow-x3',
                    'id' => 'possible_date_2',
                    'placeholder' => 'mm/dd/yy',
                    'value' => old('possible_date_2'),
                    'error' => (!empty($errors) && $errors->first('possible_date_2')) ? $errors->first('possible_date_2') : null,
                    'optional' => null,
                    'hint' => null,
                    'disabled' => false,
                    'label' => '',
                ],
                [
                    'type' => 'date-select',
                    'variation' => 'm-fieldset__input-narrow-x3',
                    'id' => 'possible_date_3',
                    'placeholder' => 'mm/dd/yy',
                    'value' => old('possible_date_3'),
                    'error' => (!empty($errors) && $errors->first('possible_date_3')) ? $errors->first('possible_date_3') : null,
                    'optional' => null,
                    'hint' => null,
                    'disabled' => false,
                    'label' => '',
                ],
            ],
        ];

        $daytimeFields[] = [
            'variation' => null,
            'blocks' => [
                [
                    'type' => 'textarea',
                    'variation' => null,
                    'id' => 'other_info',
                    'placeholder' => '',
                    'value' => old('other_info'),
                    'error' => (!empty($errors) && $errors->first('other_info')) ? $errors->first('other_info') : null,
                    'optional' => null,
                    'hint' => null,
                    'disabled' => false,
                    'label' => 'Please share any other important information',
                ],
            ],
        ];

        $daytimeFields[] = [
            'variation' => null,
            'blocks' => [
                [
                    'type' => 'captcha',
                    'variation' => null,
                    'id' => 'captcha',
                    'error' => (!empty($errors) && $errors->first('captcha')) ? $errors->first('captcha') : null,
                    'optional' => null,
                    'hint' => null,
                    'disabled' => false,
                    'label' => '',
                ],
            ],
        ];

        array_push($formBlocks, [
            'type' => 'fieldset',
            'variation' => null,
            'fields' => $inquiryFields,
            'legend' => 'Inquiry Form',
        ]);

        array_push($formBlocks, [
            'type' => 'fieldset',
            'variation' => null,
            'fields' => $daytimeFields,
            'legend' => 'Daytime event',
        ]);

        array_push($blocks, [
            'type' => 'form',
            'variation' => null,
            'action' => '/venue-rental/contact-us',
            'method' => 'POST',
            'blocks' => $formBlocks,
            'actions' => [
                [
                    'variation' => null,
                    'type' => 'submit',
                    'label' => 'Submit',
                ]
            ]
        ]);

        $breadcrumbs = [
            [
                'label' => 'Venue Rental',
                'href' => '/venue-rental',
            ],
        ];

        $view_data = [
            'subNav' => [],
            'nav' => [],
            'title' => $this->title,
            'breadcrumb' => $breadcrumbs,
            'blocks' => $blocks
        ];

        return view('site.forms.form', $view_data);
    }


    public function store(EventPlanningContactRequest $request)
    {
        $validated = $request->validated();

        $eventPlanningContact = new EventPlanningContact();
        $eventPlanningContact->name = $validated['name'] ?? '';
        $eventPlanningContact->address_1 = $validated['address_1'] ?? '';
        $eventPlanningContact->address_2 = $validated['address_2'] ?? '';
        $eventPlanningContact->city = $validated['city'] ?? '';
        $eventPlanningContact->state = $validated['state'] ?? '';
        $eventPlanningContact->zipcode = $validated['zipcode'] ?? '';
        $eventPlanningContact->country = $validated['country'] ?? '';
        $eventPlanningContact->company = $validated['company'] ?? '';
        $eventPlanningContact->email = $validated['email'] ?? '';
        $eventPlanningContact->phone_number = $validated['phone_number'] ?? '';
        $eventPlanningContact->preferred_contact = $validated['preferred_contact'] ?? '';

        $eventPlanningContact->how_did_you_hear = $validated['how_did_you_hear'] ?? '';
        $eventPlanningContact->how_did_you_hear_other = $validated['how_did_you_hear_other'] ?? '';
        $eventPlanningContact->are_you_currently_planning = $validated['are_you_currently_planning'] ?? '';
        $eventPlanningContact->type_of_event = $validated['type_of_event'] ?? '';
        $eventPlanningContact->type_of_event_other = $validated['type_of_event_other'] ?? '';
        $eventPlanningContact->no_of_expected_guests = $validated['no_of_expected_guests'] ?? '';
        $eventPlanningContact->possible_date_1 = $this->getDateField($validated, 'possible_date_1');
        $eventPlanningContact->possible_date_2 = $this->getDateField($validated, 'possible_date_2');
        $eventPlanningContact->possible_date_3 = $this->getDateField($validated, 'possible_date_3');
        $eventPlanningContact->other_info = $validated['other_info'] ?? '';

        Mail::to(config('forms.email_event_planning_to'))
            ->send(new FormEventPlanningContact($eventPlanningContact));

        return redirect(route('forms.event-planning-contact.thanks'));
    }

    private function getPreferredContactArray($selected)
    {
        $options = ['Email', 'Phone'];

        $list = [];
        foreach ($options as $value) {
            $item = [
                'type' => 'radio',
                'variation' => '',
                'id' => 'preferred_contact_' . $value,
                'name' => 'preferred_contact',
                'value' => $value,
                'error' => null,
                'optional' => null,
                'hint' => null,
                'disabled' => false,
                'checked' => false,
                'label' => $value
            ];

            if ($selected == $value) {
                $item['checked'] = 'checked';
            }

            $list[] = $item;
        }

        return $list;
    }

    private function getHowDidYouHearArray($selected)
    {
        $hows = ['Open Table', 'TripAdvisor', 'Website search', 'Special event', 'Museum visit', 'The Knot', 'Chicago Social',
            'Party Slate', 'Choose Chicago'];

        $list = [];
        foreach ($hows as $value) {
            $item = [
                'type' => 'checkbox',
                'variation' => '',
                'id' => 'how_did_you_hear-' . $value,
                'name' => 'how_did_you_hear[]',
                'value' => $value,
                'error' => null,
                'optional' => null,
                'hint' => null,
                'disabled' => false,
                'checked' => false,
                'label' => $value
            ];

            if ($selected) {
                if (in_array($value, $selected)) {
                    $item['checked'] = 'checked';
                }
            }

            $list[] = $item;
        }

        return $list;
    }

    private function getTypeOfEventArray($selected)
    {
        $types = ['Reception', 'Seated dinner', 'Wedding', 'Meeting', 'Performance Program', 'Nonprofit fundraiser'];

        $list = [];
        foreach ($types as $value) {
            $item = [
                'type' => 'checkbox',
                'variation' => '',
                'id' => 'type_of_event-' . $value,
                'name' => 'type_of_event[]',
                'value' => $value,
                'error' => null,
                'optional' => null,
                'hint' => null,
                'disabled' => false,
                'checked' => false,
                'label' => $value
            ];

            if ($selected) {
                if (in_array($value, $selected)) {
                    $item['checked'] = 'checked';
                }
            }

            $list[] = $item;
        }

        return $list;
    }
}
