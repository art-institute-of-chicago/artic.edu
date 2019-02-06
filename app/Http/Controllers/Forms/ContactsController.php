<?php

namespace App\Http\Controllers\Forms;

use App\Http\Requests\Form\ContactRequest;
use App\Models\Form\Contact;

use App\Presenters\StaticObjectPresenter;

/**
 * This is a sample form. Ignore for fixes.
 */
class ContactsController extends FormController
{
    public function index()
    {

        $blocks = array();
        $formBlocks = array();
        $contactInformationFields = array();
        $visitInformationFields = array();

        $errors = session('errors');

        $contactInformationFields[]= array(
            'variation' => null,
            'blocks' => array(
                array(
                  "type" => 'select',
                  'variation' => 'm-fieldset__input-narrow-x4',
                  'id' => 'prefix',
                  'error' => (!empty($errors) && $errors->first('prefix')) ? $errors->first('prefix') : null,
                  'optional' => null,
                  'hint' => null,
                  'disabled' => false,
                  'label' => 'Prefix',
                  'value' => old('prefix'),
                  'options' => array(
                    array('value' => '', 'label' => 'None')
                  , array('value' => 'mr', 'label' => 'Mr.')
                  , array('value' => 'ms', 'label' => 'Ms.')
                  , array('value' => 'miss', 'label' => 'Miss.')
                  , array('value' => 'mrs', 'label' => 'Mrs.')
                  , array('value' => 'dr', 'label' => 'Dr.')
                  ),
                ),
            ),
        );

        $contactInformationFields[]= array(
            'variation' => null,
            'blocks' => array(
                array(
                  "type" => 'input',
                  'variation' => null,
                  'id' => 'first_name',
                  'placeholder' => 'First name',
                  'textCount' => false,
                  'value' => old('first_name'),
                  'error' => (!empty($errors) && $errors->first('first_name')) ? $errors->first('first_name') : null,
                  'optional' => null,
                  'hint' => null,
                  'disabled' => false,
                  'label' => 'First name',
                ),

            ),
        );

        $contactInformationFields[]= array(
            'variation' => 'null',
            'blocks' => array(
                array(
                  "type" => 'input',
                  'variation' => 'm-fieldset__input-narrow-x4',
                  'id' => 'middle_initial',
                  'placeholder' => 'Middle initital',
                  'textCount' => false,
                  'value' => old('middle_initital'),
                  'error' => (!empty($errors) && $errors->first('middle_initital')) ? $errors->first('middle_initital') : null,
                  'optional' => true,
                  'hint' => null,
                  'disabled' => false,
                  'label' => 'Middle initital',
                ),
            ),
        );

        $contactInformationFields[]= array(
            'variation' => null,
            'blocks' => array(
                array(
                  "type" => 'input',
                  'variation' => null,
                  'id' => 'last_name',
                  'placeholder' => 'Last name',
                  'textCount' => false,
                  'value' => old('last_name'),
                  'error' => (!empty($errors) && $errors->first('last_name')) ? $errors->first('last_name') : null,
                  'optional' => null,
                  'hint' => null,
                  'disabled' => false,
                  'label' => 'Last name',
                ),

            ),
        );

        $contactInformationFields[]= array(
            'variation' => null,
            'blocks' => array(
                array(
                  "type" => 'input',
                  'variation' => null,
                  'id' => 'phone_number',
                  'placeholder' => 'Phone number',
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

        $contactInformationFields[]= array(
            'variation' => null,
            'blocks' => array(
                array(
                  "type" => 'input',
                  'variation' => null,
                  'id' => 'address_1',
                  'placeholder' => 'Street address',
                  'textCount' => false,
                  'value' => old('address_1'),
                  'error' => (!empty($errors) && $errors->first('address_1')) ? $errors->first('address_1') : null,
                  'optional' => null,
                  'hint' => null,
                  'disabled' => false,
                  'label' => 'Street address',
                ),
            ),
        );

        $contactInformationFields[]= array(
            'variation' => null,
            'blocks' => array(
                array(
                  "type" => 'input',
                  'variation' => null,
                  'id' => 'address_2',
                  'placeholder' => '',
                  'textCount' => false,
                  'value' => old('address_2'),
                  'error' => (!empty($errors) && $errors->first('address_2')) ? $errors->first('address_2') : null,
                  'optional' => true,
                  'hint' => null,
                  'disabled' => false,
                  'label' => 'Apartment or suite',
                ),
            ),
        );

        $contactInformationFields[]= array(
            'variation' => null,
            'blocks' => array(
                array(
                  "type" => 'input',
                  'variation' => null,
                  'id' => 'city',
                  'placeholder' => '',
                  'textCount' => false,
                  'value' => old('city'),
                  'error' => (!empty($errors) && $errors->first('city')) ? $errors->first('city') : null,
                  'optional' => false,
                  'hint' => null,
                  'disabled' => false,
                  'label' => 'City',
                ),
            ),
        );

        $contactInformationFields[] = array(
            'variation' => null,
            'blocks' => array(
                array(
                  "type" => 'select',
                  'variation' => 'm-fieldset__input-narrow-x4',
                  'id' => 'state',
                  'error' => (!empty($errors) && $errors->first('state')) ? $errors->first('state') : null,
                  'optional' => null,
                  'hint' => null,
                  'disabled' => false,
                  'value' => old('state'),
                  'label' => 'State',
                  'options' => $this->getStatesArray(),
                ),
                array(
                  "type" => 'input',
                  'variation' => 'm-fieldset__input-narrow-x4',
                  'id' => 'zipcode',
                  'placeholder' => '',
                  'textCount' => false,
                  'value' => old('zipcode'),
                  'error' => (!empty($errors) && $errors->first('zipcode')) ? $errors->first('zipcode') : null,
                  'optional' => null,
                  'hint' => null,
                  'disabled' => false,
                  'label' => 'Zipcode',
                ),
            ),
        );

        $contactInformationFields[] = array(
            'variation' => null,
            'blocks' => array(
                array(
                  "type" => 'select',
                  'variation' => null,
                  'id' => 'country',
                  'error' => (!empty($errors) && $errors->first('country')) ? $errors->first('country') : null,
                  'value' => old('country'),
                  'optional' => null,
                  'hint' => null,
                  'disabled' => false,
                  'label' => 'Country',
                  'options' => $this->getCountriesArray(),
                ),
            ),
        );

        $visitInformationFields[] = array(
            'variation' => null,
            'blocks' => array(
                array(
                  "type" => 'date-select',
                  'variation' => 'm-fieldset__input-narrow-x4',
                  'id' => 'visit_date',
                  'placeholder' => 'dd/mm/yy',
                  'value' => old('visit_date'),
                  'error' => (!empty($errors) && $errors->first('visit_date')) ? $errors->first('visit_date') : null,
                  'optional' => null,
                  'hint' => null,
                  'disabled' => false,
                  'label' => 'Visit date',
                ),
            ),
        );

        $dayFields = [
            'variation' => 'm-fieldset__field--group',
            'blocks' => array(
                array(
                  "type" => 'label',
                  'variation' => 'm-fieldset__group-label',
                  'error' => (!empty($errors) && $errors->first('days_class_meets')) ? $errors->first('days_class_meets') : null,
                  'optional' => null,
                  'hint' => null,
                  'label' => 'Days the Class Meets',
                )
            ),
        ];
        foreach($this->getWeekDayArray(old('days_class_meets')) as $d) {
            array_push($dayFields['blocks'], $d);
        }
        $visitInformationFields[] = $dayFields;

        $visitInformationFields[] = [
            'variation' => null,
            'blocks' => array(
                array(
                  "type" => 'textarea',
                  'variation' => null,
                  'id' => 'comments',
                  'placeholder' => '',
                  'value' => old('comments'),
                  'error' => (!empty($errors) && $errors->first('comments')) ? $errors->first('comments') : null,
                  'optional' => true,
                  'hint' => 'Special material requests, etc',
                  'disabled' => false,
                  'label' => 'Additional comments',
                ),
            ),
        ];

        $typeOfVisitFields = [
            'variation' => 'm-fieldset__field--group',
            'blocks' => array(
                array(
                  "type" => 'label',
                  'variation' => 'm-fieldset__group-label',
                  'error' => (!empty($errors) && $errors->first('type_of_visit')) ? $errors->first('type_of_visit') : null,
                  'optional' => null,
                  'hint' => null,
                  'label' => 'Type of Visit',
                )
            ),
        ];
        foreach($this->getTypeOfVisitArray(old('type_of_visit')) as $t) {
            array_push($typeOfVisitFields['blocks'], $t);
        }
        $visitInformationFields[] = $typeOfVisitFields;

        array_push($formBlocks, array(
          "type" => 'fieldset',
          'variation' => null,
          'fields' => $contactInformationFields,
          'legend' => 'Contact Information',
        ));

        array_push($formBlocks, array(
          "type" => 'fieldset',
          'variation' => null,
          'fields' => $visitInformationFields,
          'legend' => 'Visit Information',
        ));

        array_push($blocks, array(
          "type" => 'text',
          "content" => '<p>Nullam id dolor id nibh ultricies vehicula ut id elit. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Maecenas faucibus mollis interdum. Maecenas faucibus mollis interdum.</p>'
        ));

        array_push($blocks, array(
            'type' => 'form',
            'variation' => null,
            'action' => '/forms/contact',
            'method' => 'POST',
            "blocks" => $formBlocks,
            "actions" => array(
                array(
                    'variation' => null,
                    'type' => 'submit',
                    'label' => "Submit",
                )
            )
        ));

        $view_data = [
            'subNav' => [],
            'nav' => [],
            'title' => 'Sample Form',
            "breadcrumb" => [],
            "blocks" => $blocks
        ];

        return view('site.forms.form', $view_data);
    }

    public function store(ContactRequest $request)
    {
        $validated = $request->validated();

        $contact = new Contact;
        $contact->prefix = $validated['prefix'];
        $contact->first_name = $validated['first_name'];
        $contact->middle_initial = $validated['middle_initial'];
        $contact->last_name = $validated['last_name'];
        $contact->phone_number = $validated['phone_number'];
        $contact->address_1 = $validated['address_1'];
        $contact->address_2 = $validated['address_2'];
        $contact->city = $validated['city'];
        $contact->state = $validated['state'];
        $contact->zipcode = $validated['zipcode'];
        $contact->country = $validated['country'];

        $contact->visit_date = $this->getDateField($validated, 'visit_date');
        $contact->days_class_meets = implode(", ", $validated['days_class_meets']);
        $contact->comments = $validated['comments'];
        $contact->type_of_visit = $validated['type_of_visit'];

        if ($contact->save()) {
            return redirect(route('forms.contact.thanks'));
        } else {
            abort(500);
        }
    }

    private function getWeekDayArray($selected)
    {
        // dd($selected);
        $days = array('mon' => 'Monday', 'tue' => 'Tuesday', 'wed' => 'Wednesday', 'thu' => 'Thursday', 'fri' => 'Friday');

        $list = [];
        foreach($days as $value => $label) {
            $item = [
              'type' => 'checkbox',
              'variation' => '',
              'id' => 'days_class_meets-'.$value,
              'name' => 'days_class_meets[]',
              'value' => $value,
              'error' => null,
              'optional' => null,
              'hint' => null,
              'disabled' => false,
              'checked' => false,
              'label' => $label
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

    private function getTypeOfVisitArray($selected)
    {
        $days = array('orientation' => 'Library Orientation', 'research' => 'Course-Related Research Session', 'tour' => 'Library Tour');

        $list = [];
        foreach($days as $value => $label) {
            $item = [
              'type' => 'radio',
              'variation' => '',
              'id' => 'type_of_visit_'.$value,
              'name' => 'type_of_visit',
              'value' => $value,
              'error' => null,
              'optional' => null,
              'hint' => null,
              'disabled' => false,
              'checked' => false,
              'label' => $label
            ];

            if ($selected == $value) {
                $item['checked'] = 'checked';
            }

            $list[] = $item;
        }

        return $list;
    }

}
