<?php

namespace App\Http\Controllers\Forms;

use Illuminate\Support\Facades\Mail;

use App\Http\Requests\Form\EventPlanningContactRequest;

use App\Models\Form\EventPlanningContact;

use App\Mail\FormEventPlanningContact;

use App\Presenters\StaticObjectPresenter;

class EventPlanningContactController extends FormController
{
    public function index()
    {

        $this->title = 'Event Planning Contact';
        $this->seo->setTitle($this->title);

        $blocks = array();
        $formBlocks = array();
        $inquiryFields = array();

        $errors = session('errors');

        /*
         *
         *  Inquiry form
         *
         */
        $inquiryFields[]= array(
            'variation' => null,
            'blocks' => array(
                array(
                  'type' => 'input',
                  'variation' => null,
                  'id' => 'name',
                  'placeholder' => '',
                  'textCount' => false,
                  'value' => old('name'),
                  'error' => (!empty($errors) && $errors->first('name')) ? $errors->first('name') : null,
                  'optional' => null,
                  'hint' => null,
                  'disabled' => false,
                  'label' => 'Name',
                ),
            ),
        );

        $inquiryFields[]= array(
            'variation' => null,
            'blocks' => array(
                array(
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
                ),
            ),
        );

        $inquiryFields[]= array(
            'variation' => null,
            'blocks' => array(
                array(
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
                  'label' => 'Email',
                ),
            ),
        );

        $inquiryFields[]= array(
            'variation' => null,
            'blocks' => array(
                array(
                  'type' => 'tel',
                  'variation' => null,
                  'id' => 'phone_number',
                  'placeholder' => '',
                  'textCount' => false,
                  'value' => old('phone_number'),
                  'error' => (!empty($errors) && $errors->first('phone_number')) ? $errors->first('phone_number') : null,
                  'optional' => null,
                  'hint' => null,
                  'disabled' => false,
                  'label' => 'Phone number',
                ),
            ),
        );

        $preferredContactFields = [
            'variation' => 'm-fieldset__field--group',
            'blocks' => array(
                array(
                  'type' => 'label',
                  'variation' => 'm-fieldset__group-label',
                  'error' => (!empty($errors) && $errors->first('preferred_contact')) ? $errors->first('preferred_contact') : null,
                  'optional' => null,
                  'hint' => null,
                  'label' => 'Preferred method of contact',
                )
            ),
        ];
        foreach($this->getPreferredContactArray(old('preferred_contact')) as $t) {
            array_push($preferredContactFields['blocks'], $t);
        }
        $inquiryFields[] = $preferredContactFields;

        $inquiryFields[] = [
            'variation' => null,
            'blocks' => array(
                array(
                  "type" => 'textarea',
                  'variation' => null,
                  'id' => 'event_description',
                  'placeholder' => '',
                  'value' => old('event_description'),
                  'error' => (!empty($errors) && $errors->first('event_description')) ? $errors->first('event_description') : null,
                  'optional' => null,
                  'hint' => '',
                  'disabled' => false,
                  'label' => 'Are you currently planning an event? If so, what type of event do you have in mind?',
                ),
            ),
        ];

        $inquiryFields[] = [
            'variation' => null,
            'blocks' => array(
                array(
                  "type" => 'textarea',
                  'variation' => null,
                  'id' => 'dates',
                  'placeholder' => '',
                  'value' => old('dates'),
                  'error' => (!empty($errors) && $errors->first('dates')) ? $errors->first('dates') : null,
                  'optional' => null,
                  'hint' => '',
                  'disabled' => false,
                  'label' => 'Are you looking for a specific date? If so, what date?',
                ),
            ),
        ];

        $inquiryFields[] = [
            'variation' => null,
            'blocks' => array(
                array(
                  "type" => 'textarea',
                  'variation' => null,
                  'id' => 'know_more_about',
                  'placeholder' => '',
                  'value' => old('know_more_about'),
                  'error' => (!empty($errors) && $errors->first('know_more_about')) ? $errors->first('know_more_about') : null,
                  'optional' => null,
                  'hint' => '',
                  'disabled' => false,
                  'label' => 'Did you find the information you were looking for? If not, what would you like to know more about?',
                ),
            ),
        ];

        $inquiryFields[] = array(
            'variation' => null,
            'blocks' => array(
                array(
                  'type' => 'captcha',
                  'variation' => null,
                  'id' => 'captcha',
                  'error' => (!empty($errors) && $errors->first('captcha')) ? $errors->first('captcha') : null,
                  'optional' => null,
                  'hint' => null,
                  'disabled' => false,
                  'label' => '',
                ),
            ),
        );

        array_push($formBlocks, array(
          'type' => 'fieldset',
          'variation' => null,
          'fields' => $inquiryFields,
          'legend' => 'Inquiry Form',
        ));

        array_push($blocks, array(
          'type' => 'text',
          'content' => '<p>Bon Appétit at the Art Institute<br/>'
          .'For further information, please call (312) 443-3530 or use the inquiry form below.</p>'
        ));

        array_push($blocks, array(
            'type' => 'form',
            'variation' => null,
            'action' => '/venue-rental/contact-us',
            'method' => 'POST',
            'blocks' => $formBlocks,
            'actions' => array(
                array(
                    'variation' => null,
                    'type' => 'submit',
                    'label' => "Submit",
                )
            )
        ));

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

    /**
     * @param EventPlanningContactRequest $request
     */
    public function store(EventPlanningContactRequest $request)
    {

        $validated = $request->validated();

        $eventPlanningContact = new EventPlanningContact;
        $eventPlanningContact->name = $validated['name'] ?? '';
        $eventPlanningContact->company = $validated['company'] ?? '';
        $eventPlanningContact->email = $validated['email'] ?? '';
        $eventPlanningContact->phone_number = $validated['phone_number'] ?? '';
        $eventPlanningContact->preferred_contact = $validated['preferred_contact'] ?? '';
        $eventPlanningContact->event_description = $validated['event_description'] ?? '';
        $eventPlanningContact->dates = $validated['dates'] ?? '';
        $eventPlanningContact->know_more_about = $validated['know_more_about'] ?? '';

        Mail::to(config('forms.email_event_planning_to'))
            ->send(new FormEventPlanningContact($eventPlanningContact));

        return redirect(route('forms.event-planning-contact.thanks'));

    }

    private function getPreferredContactArray($selected)
    {
        $options = array('Email', 'Phone');

        $list = [];
        foreach($options as $value) {
            $item = [
              'type' => 'radio',
              'variation' => '',
              'id' => 'preferred_contact_'.$value,
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

}
