<?php

namespace App\Http\Controllers\Forms;

use Carbon\Carbon;

use App\Http\Controllers\FrontController;

use App\Http\Requests\Form\ContactRequest;
use App\Models\Form\Contact;

use App\Presenters\StaticObjectPresenter;

class ContactsController extends FrontController
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
                  'variation' => 'm-fieldset__input-narrow',
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
                  'variation' => 'm-fieldset__input-narrow',
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
                  'variation' => 'm-fieldset__input-narrow',
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
                  'variation' => 'm-fieldset__input-narrow',
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
                  'variation' => 'm-fieldset__input-narrow',
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

        return view('site.forms.contact', $view_data);
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

        $contact->visit_date = Carbon::parse($validated['visit_date']);
        $contact->days_class_meets = implode(", ", $validated['days_class_meets']);
        $contact->comments = $validated['comments'];
        $contact->type_of_visit = $validated['type_of_visit'];

        if ($contact->save()) {
            return redirect(route('forms.contact.thanks'));
        } else {
            abort(500);
        }
    }

    public function thanks()
    {
        $blocks = [];
        array_push($blocks, array(
          "type" => 'text',
          "content" => '<p>Submission complete.</p>'
        ));


        $view_data = [
            'subNav' => [],
            'nav' => [],
            'title' => 'Thank you!',
            "breadcrumb" => [],
            "blocks" => $blocks
        ];

        return view('site.forms.thanks', $view_data);
    }


    private function getStatesArray()
    {
        $us_state_abbrevs = array('AL', 'AK', 'AS', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'DC', 'FM', 'FL', 'GA', 'GU', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MH', 'MD', 'MA', 'MI', 'MN', 'MS', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'MP', 'OH', 'OK', 'OR', 'PW', 'PA', 'PR', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VI', 'VA', 'WA', 'WV', 'WI', 'WY', 'AE', 'AA', 'AP');


        $list = [];
        $list[] = ['value' => '', 'label' => 'Select'];
        foreach($us_state_abbrevs as $value => $label) {
            $item = [
                'value' => strtolower($label)
            ,   'label' => $label
            ];

            $list[] = $item;
        }

        return $list;
    }


    private function getCountriesArray()
    {
        $countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");

        $list = [];
        $list[] = ['value' => '', 'label' => 'Select'];
        foreach($countries as $value => $label) {
            $list[] = [
                'value' => strtolower($label)
            ,   'label' => $label
            ];
        }

        return $list;
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
