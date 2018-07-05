<?php

namespace App\Http\Controllers\Forms;

use Carbon\Carbon;

use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\FrontController;

use App\Http\Requests\Form\GroupReservationRequest;
use App\Models\Form\GroupReservation;

use App\Mail\FormGroupReservation;

use App\Presenters\StaticObjectPresenter;

class GroupReservationsController extends FrontController
{
    public function index()
    {

        $blocks = array();
        $formBlocks = array();
        $contactInformationFields = array();
        $visitInformationFields = array();

        $errors = session('errors');

        /*
         *
         *  Contact information
         *
         */
        $contactInformationFields[]= array(
            'variation' => null,
            'blocks' => array(
                array(
                  'type' => 'input',
                  'variation' => null,
                  'id' => 'group_name',
                  'placeholder' => '',
                  'textCount' => false,
                  'value' => old('group_name'),
                  'error' => (!empty($errors) && $errors->first('group_name')) ? $errors->first('group_name') : null,
                  'optional' => null,
                  'hint' => null,
                  'disabled' => false,
                  'label' => 'Group name',
                ),
            ),
        );

        $contactInformationFields[]= array(
            'variation' => null,
            'blocks' => array(
                array(
                  'type' => 'input',
                  'variation' => null,
                  'id' => 'contact_name',
                  'placeholder' => '',
                  'textCount' => false,
                  'value' => old('contact_name'),
                  'error' => (!empty($errors) && $errors->first('contact_name')) ? $errors->first('contact_name') : null,
                  'optional' => false,
                  'hint' => null,
                  'disabled' => false,
                  'label' => 'Contact name',
                ),
            ),
        );

        $contactInformationFields[]= array(
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

        $contactInformationFields[]= array(
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

        $contactInformationFields[]= array(
            'variation' => null,
            'blocks' => array(
                array(
                  'type' => 'tel',
                  'variation' => null,
                  'id' => 'fax_number',
                  'placeholder' => '',
                  'textCount' => false,
                  'value' => old('fax_number'),
                  'error' => (!empty($errors) && $errors->first('fax_number')) ? $errors->first('fax_number') : null,
                  'optional' => null,
                  'hint' => null,
                  'disabled' => false,
                  'label' => 'Fax number',
                ),
            ),
        );

        $contactInformationFields[]= array(
            'variation' => null,
            'blocks' => array(
                array(
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
                ),
            ),
        );

        $contactInformationFields[]= array(
            'variation' => null,
            'blocks' => array(
                array(
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
                ),
            ),
        );

        $contactInformationFields[]= array(
            'variation' => null,
            'blocks' => array(
                array(
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
                ),
            ),
        );

        $contactInformationFields[] = array(
            'variation' => null,
            'blocks' => array(
                array(
                  'type' => 'select',
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
                  'type' => 'input',
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
                ),
            ),
        );


        /*
         *
         *  Visit information
         *
         */
        $visitInformationFields[] = array(
            'variation' => null,
            'blocks' => array(
                array(
                  'type' => 'date-select',
                  'variation' => 'm-fieldset__input-narrow',
                  'id' => 'visit_date',
                  'placeholder' => 'mm/dd/yy',
                  'value' => old('visit_date'),
                  'error' => (!empty($errors) && $errors->first('visit_date')) ? $errors->first('visit_date') : null,
                  'optional' => null,
                  'hint' => null,
                  'disabled' => false,
                  'label' => 'Visit date',
                ),
                array(
                  'type' => 'select',
                  'variation' => 'm-fieldset__input-narrow',
                  'id' => 'visit_time',
                  'error' => (!empty($errors) && $errors->first('visit_time')) ? $errors->first('visit_time') : null,
                  'value' => old('visit_time'),
                  'optional' => null,
                  'hint' => null,
                  'disabled' => false,
                  'label' => 'Time',
                  'options' => $this->getTimeArray()
                ),
            ),
        );

        $visitInformationFields[] = array(
            'variation' => null,
            'blocks' => array(
                array(
                    'type' => 'text',
                    'content' => '<p>Total number of people in group:</p>'
                ),
            ),
        );

        $visitInformationFields[] = array(
            'variation' => null,
            'blocks' => array(
                array(
                  'type' => 'number',
                  'pattern' => '\d*',
                  'variation' => 'm-fieldset__input-narrow',
                  'id' => 'no_of_adults',
                  'value' => old('no_of_adults'),
                  'error' => (!empty($errors) && $errors->first('no_of_adults')) ? $errors->first('no_of_adults') : null,
                  'optional' => null,
                  'hint' => null,
                  'disabled' => false,
                  'label' => 'Adults',
                ),
                array(
                  'type' => 'number',
                  'pattern' => '\d*',
                  'variation' => 'm-fieldset__input-narrow',
                  'id' => 'no_of_students',
                  'value' => old('no_of_students'),
                  'error' => (!empty($errors) && $errors->first('no_of_students')) ? $errors->first('no_of_students') : null,
                  'optional' => null,
                  'hint' => null,
                  'disabled' => false,
                  'label' => 'Students',
                ),
                array(
                  'type' => 'number',
                  'pattern' => '\d*',
                  'variation' => 'm-fieldset__input-narrow',
                  'id' => 'no_of_seniors',
                  'value' => old('no_of_seniors'),
                  'error' => (!empty($errors) && $errors->first('no_of_seniors')) ? $errors->first('no_of_seniors') : null,
                  'optional' => null,
                  'hint' => null,
                  'disabled' => false,
                  'label' => 'Seniors',
                ),
            ),
        );

        $diningOptionFields = [
            'variation' => 'm-fieldset__field--group',
            'blocks' => array(
                array(
                  'type' => 'label',
                  'variation' => 'm-fieldset__group-label',
                  'error' => (!empty($errors) && $errors->first('dining_option')) ? $errors->first('dining_option') : null,
                  'optional' => null,
                  'hint' => null,
                  'label' => 'Dining options',
                )
            ),
        ];
        foreach($this->getDiningOptionArray(old('dining_option')) as $t) {
            array_push($diningOptionFields['blocks'], $t);
        }
        $visitInformationFields[] = $diningOptionFields;

        $visitInformationFields[]= array(
            'variation' => null,
            'blocks' => array(
                array(
                  'type' => 'number',
                  'pattern' => '\d*',
                  'variation' => null,
                  'id' => 'no_of_audio_tours',
                  'placeholder' => '',
                  'textCount' => false,
                  'value' => old('no_of_audio_tours'),
                  'error' => (!empty($errors) && $errors->first('no_of_audio_tours')) ? $errors->first('no_of_audio_tours') : null,
                  'optional' => null,
                  'hint' => null,
                  'disabled' => false,
                  'label' => 'Number of Audio Tours',
                ),
            ),
        );

        $visitInformationFields[] = array(
            'variation' => null,
            'blocks' => array(
                array(
                  'type' => 'select',
                  'variation' => null,
                  'id' => 'topic',
                  'error' => (!empty($errors) && $errors->first('topic')) ? $errors->first('topic') : null,
                  'value' => old('topic'),
                  'optional' => null,
                  'hint' => null,
                  'disabled' => false,
                  'label' => 'Topic of gallery tour/slide lecture',
                  'options' => $this->getTopicsArray(),
                ),
            ),
        );

        $needsFields = [
            'variation' => 'm-fieldset__field--group',
            'blocks' => array(
                array(
                  'type' => 'label',
                  'variation' => 'm-fieldset__group-label',
                  'error' => (!empty($errors) && $errors->first('needs')) ? $errors->first('needs') : null,
                  'optional' => null,
                  'hint' => 'Please specify the needs of your group',
                  'label' => 'Special needs',
                )
            ),
        ];
        foreach($this->getNeedsArray(old('needs')) as $d) {
            array_push($needsFields['blocks'], $d);
        }
        $visitInformationFields[] = $needsFields;

        array_push($formBlocks, array(
          'type' => 'fieldset',
          'variation' => null,
          'fields' => $contactInformationFields,
          'legend' => 'Contact Information',
        ));

        array_push($formBlocks, array(
          'type' => 'fieldset',
          'variation' => null,
          'fields' => $visitInformationFields,
          'legend' => 'Visit Information',
        ));

        array_push($blocks, array(
          'type' => 'text',
          'content' => '<p>Thank you for your request. Please note if you are booking a visit for a student group, pre-K–12th grade, use the student tours application form [LINK].</p>'
          .'<p>Group visits require a minimum of 15 people. Reservations are requested 21 days in advance and will be confirmed in writing within 10 business days of receipt. Thank you for thinking of the Art Institute of Chicago.</p>'
          .'<p>You may also print this form and return it to:</p>'
          .'<p>Group Sales<br/>'
          .'The Art Institute of Chicago<br/>'
          .'111 S. Michigan Avenue<br/>'
          .'Chicago, IL 60603-6110<br/>'
          .'Fax: (312) 541-9480</p>'
        ));

        array_push($blocks, array(
            'type' => 'form',
            'variation' => null,
            'action' => '/forms/group-reservation',
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

        $view_data = [
            'subNav' => [],
            'nav' => [],
            'title' => 'Group Reservation Form',
            'breadcrumb' => [],
            'blocks' => $blocks
        ];

        return view('site.forms.contact', $view_data);
    }

    public function store(GroupReservationRequest $request)
    {
        $validated = $request->validated();

        $groupReservation = new GroupReservation;
        $groupReservation->group_name = $validated['group_name'] ?? '';
        $groupReservation->contact_name = $validated['contact_name'] ?? '';
        $groupReservation->email = $validated['email'] ?? '';
        $groupReservation->phone_number = $validated['phone_number'] ?? '';
        $groupReservation->fax_number = $validated['fax_number'] ?? '';
        $groupReservation->address_1 = $validated['address_1'] ?? '';
        $groupReservation->address_2 = $validated['address_2'] ?? '';
        $groupReservation->city = $validated['city'] ?? '';
        $groupReservation->state = $validated['state'] ?? '';
        $groupReservation->zipcode = $validated['zipcode'] ?? '';
        $groupReservation->country = $validated['country'] ?? '';

        $groupReservation->visit_date = Carbon::parse($validated['visit_date']) ?? '';
        $groupReservation->visit_time = $validated['visit_time'] ?? '';
        $groupReservation->no_of_adults = $validated['no_of_adults'] ?? '';
        $groupReservation->no_of_students = $validated['no_of_students'] ?? '';
        $groupReservation->no_of_seniors = $validated['no_of_seniors'] ?? '';
        $groupReservation->dining_option = $validated['dining_option'] ?? '';
        $groupReservation->no_of_audio_tours = $validated['no_of_audio_tours'] ?? '';
        $groupReservation->topic = $validated['topic'] ?? '';
        $groupReservation->needs = isset($validated['needs']) ? implode(", ", $validated['needs']) : '';

        Mail::to('groupsales@artic.edu')
            ->send(new FormGroupReservation($groupReservation));

        return redirect(route('forms.group-reservation.thanks'));

    }

    public function thanks()
    {
        $blocks = [];
        array_push($blocks, array(
          'type' => 'text',
          'content' => '<p>Submission complete.</p>'
        ));


        $view_data = [
            'subNav' => [],
            'nav' => [],
            'title' => 'Thank you!',
            'breadcrumb' => [],
            'blocks' => $blocks
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
                'value' => $label
            ,   'label' => $label
            ];

            $list[] = $item;
        }

        return $list;
    }


    private function getCountriesArray()
    {
        $countries = array("United States", "Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");

        $list = [];
        $list[] = ['value' => '', 'label' => 'Select'];
        foreach($countries as $value => $label) {
            $list[] = [
                'value' => $label
            ,   'label' => $label
            ];
        }

        return $list;
    }

    private function getTimeArray()
    {
        $hours = hoursSelectOptions($shortlist = true);

        $list = [];
        $list[] = ['value' => '', 'label' => 'Select'];
        foreach($hours as $value => $label) {
            $list[] = [
                'value' => $label
            ,   'label' => $label
            ];
        }

        return $list;
    }


    private function getDiningOptionArray($selected)
    {
        $options = array('Lunch' => 'Lunch', 'Wine-and-cheese reception' => 'Wine-and-cheese reception');

        $list = [];
        foreach($options as $value => $label) {
            $item = [
              'type' => 'radio',
              'variation' => '',
              'id' => 'dining_option_'.$value,
              'name' => 'dining_option',
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


    private function getTopicsArray()
    {
        $topics = array('Highlights of the Art Institute',
                        'Highlights of the Modern Wing: Modern and Contemporary Art',
                        'American Art',
                        'Ancient Etruscan, Greek, and Roman Art',
                        'Chicago Giants of the Gilded Age',
                        'Compelling Old Master Paintings',
                        'Depictions of Religion in Art',
                        'Discerning Eye (Additional fees apply)',
                        'Impressionism from the Permanent Collection',
                        'Indian, Southeast Asian, Himalayan, and Islamic Art',
                        'The Photography Collection',
                        'Treasured European Decorative Arts',
                        'The New Contemporary',
                        'Gauguin: Artist as Alchemist (Slide Lecture)',
        );

        $list = [];
        $list[] = ['value' => '', 'label' => 'Select'];
        foreach($topics as $value => $label) {
            $item = [
                'value' => $label
            ,   'label' => $label
            ];

            $list[] = $item;
        }

        return $list;
    }


    private function getNeedsArray($selected)
    {
        $needs = array('Foreign language' => 'Foreign language',
                       'Wheelchair use' => 'Wheelchair use',
                       'Sign language' => 'Sign language',
                       'No special needs' => 'No special needs',
        );

        $list = [];
        foreach($needs as $value => $label) {
            $item = [
              'type' => 'checkbox',
              'variation' => '',
              'id' => 'needs-'.$value,
              'name' => 'needs[]',
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
}
