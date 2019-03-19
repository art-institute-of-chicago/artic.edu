<?php

namespace App\Http\Controllers\Forms;

use Illuminate\Support\Facades\Mail;

use App\Http\Requests\Form\EmailSubscriptionsRequest;

use App\Libraries\ExactTargetService;

use App\Models\ExactTargetList;
use App\Models\Form\EmailSubscriptions;

use App\Mail\FormEmailSubscriptions;

use App\Presenters\StaticObjectPresenter;

class EmailSubscriptionsController extends FormController
{

    protected $old = null;

    public function index(\Illuminate\Http\Request $request)
    {

        if (request('e')) {
            $email = base64_decode(request('e'));

            $exactTarget = new ExactTargetService($email);
            $response = $exactTarget->get();

            if ($response->status && $response->code == 200) {
                $old = new EmailSubscriptions;
                $subscriptions = [];
                foreach ($response->results[0]->Properties->Property as $index => $keyval) {
                    if ($keyval->Name == 'Email') {
                        $old->email = $keyval->Value;
                    }
                    elseif ($keyval->Name == 'FirstName') {
                        $old->first_name = $keyval->Value;
                    }
                    elseif ($keyval->Name == 'LastName') {
                        $old->last_name = $keyval->Value;
                    }
                    elseif ($keyval->Value == 'True') {
                        $subscriptions[] = $keyval->Name;
                    }
                }
                $old->subscriptions = $subscriptions;
                $this->old = $old;
            }
            else {
                // Set error message "Your e-mail address is not currently subscribed. Please fill out and submit the form below to begin receiving messages from the Art Institute."
            }
        }
        $this->title = 'Email Subscriptions';
        $this->seo->setTitle($this->title);

        $blocks = array();
        $formBlocks = array();
        $subscriptionsFields = array();
        $personalInformationFields = array();
        $unsubscribeFields = array();

        $errors = session('errors');

        /*
         *
         *  Subscriptions information
         *
         */
        $subFields = [
            'variation' => 'm-fieldset__field--group',
            'blocks' => array(
                array(
                  "type" => 'label',
                  'variation' => 'm-fieldset__group-label',
                  'error' => (!empty($errors) && $errors->first('subscriptions')) ? $errors->first('subscriptions') : null,
                  'optional' => null,
                  'hint' => null,
                  'label' => '',
                )
            ),
        ];
        foreach($this->getSubscriptionsArray($this->old('subscriptions')) as $d) {
            array_push($subFields['blocks'], $d);
        }
        $subscriptionsFields[] = $subFields;

        /*
         *
         *  Unsubscribe
         *
         */
        $unsubscribeFields[] = [
            'variation' => 'm-fieldset__field--group',
            'blocks' => array(
                array(
                  "type" => 'label',
                  'variation' => 'm-fieldset__group-label',
                  'error' => (!empty($errors) && $errors->first('unsubscribe')) ? $errors->first('unsubscribe') : null,
                  'optional' => null,
                  'hint' => null,
                  'label' => '',
                ),
                array(
                    'type' => 'checkbox',
                    'variation' => '',
                    'id' => 'unsubscribe',
                    'name' => 'unsubscribe[]',
                    'value' => 'unsubscribe',
                    'error' => null,
                    'optional' => null,
                    'hint' => null,
                    'disabled' => false,
                    'checked' => $this->old('unsubscribe') ?? false,
                    'label' => 'I no longer wish to receive any Art Institute emails.'
                ),
            ),
        ];

        /*
         *
         *  Personal information
         *
         */
        $personalInformationFields[]= array(
            'variation' => null,
            'blocks' => array(
                array(
                  'type' => 'email',
                  'variation' => null,
                  'id' => 'email',
                  'placeholder' => '',
                  'textCount' => false,
                  'value' => $this->old('email'),
                  'error' => (!empty($errors) && $errors->first('email')) ? $errors->first('email') : null,
                  'optional' => false,
                  'hint' => null,
                  'disabled' => false,
                  'label' => 'Email *',
                ),
            ),
        );

        $personalInformationFields[]= array(
            'variation' => null,
            'blocks' => array(
                array(
                  'type' => 'input',
                  'variation' => null,
                  'id' => 'first_name',
                  'placeholder' => '',
                  'textCount' => false,
                  'value' => $this->old('first_name'),
                  'error' => (!empty($errors) && $errors->first('first_name')) ? $errors->first('first_name') : null,
                  'optional' => null,
                  'hint' => null,
                  'disabled' => false,
                  'label' => 'First Name',
                ),
            ),
        );

        $personalInformationFields[]= array(
            'variation' => null,
            'blocks' => array(
                array(
                  'type' => 'input',
                  'variation' => null,
                  'id' => 'last_name',
                  'placeholder' => '',
                  'textCount' => false,
                  'value' => $this->old('last_name'),
                  'error' => (!empty($errors) && $errors->first('last_name')) ? $errors->first('last_name') : null,
                  'optional' => null,
                  'hint' => null,
                  'disabled' => false,
                  'label' => 'Last Name',
                ),
            ),
        );

        $personalInformationFields[]= array(
            'variation' => null,
            'blocks' => array(
                array(
                  'type' => 'input',
                  'variation' => null,
                  'id' => 'company',
                  'placeholder' => '',
                  'textCount' => false,
                  'value' => $this->old('company'),
                  'error' => (!empty($errors) && $errors->first('company')) ? $errors->first('company') : null,
                  'optional' => null,
                  'hint' => null,
                  'disabled' => false,
                  'label' => 'Company or Organization',
                ),
            ),
        );

        $prefFields = [
            'variation' => 'm-fieldset__field--group',
            'blocks' => array(
                array(
                  "type" => 'label',
                  'variation' => 'm-fieldset__group-label',
                  'error' => (!empty($errors) && $errors->first('preferences')) ? $errors->first('preferences') : null,
                  'optional' => null,
                  'hint' => null,
                  'label' => 'Email Preferences',
                )
            ),
        ];
        foreach($this->getPreferencesArray($this->old('preferences')) as $t) {
            array_push($prefFields['blocks'], $t);
        }
        $personalInformationFields[] = $prefFields;

        $personalInformationFields[] = array(
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
          'fields' => $subscriptionsFields,
          'legend' => 'Newsletter Options',
        ));

        array_push($formBlocks, array(
          'type' => 'fieldset',
          'variation' => null,
          'fields' => $unsubscribeFields,
          'legend' => 'Unsubscribe',
        ));

        array_push($formBlocks, array(
          'type' => 'fieldset',
          'variation' => null,
          'fields' => $personalInformationFields,
          'legend' => 'Personal Information',
        ));

        array_push($blocks, array(
            'type' => 'form',
            'variation' => null,
            'action' => '/email-subscriptions',
            'method' => 'POST',
            'blocks' => $formBlocks,
            'actions' => array(
                array(
                    'variation' => null,
                    'type' => 'submit',
                    'label' => "Update",
                )
            )
        ));

        $breadcrumbs = [
            [
                'label' => 'Visit',
                'href' => '/visit',
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
     * @param EducatorAdmissionRequest $request
     */
    public function store(EducatorAdmissionRequest $request)
    {

        $validated = $request->validated();

        $educatorAdmission = new EducatorAdmission;

        $educatorAdmission->name = $validated['name'] ?? '';
        $educatorAdmission->email = $validated['email'] ?? '';
        $educatorAdmission->visit_date = $this->getDateField($validated, 'visit_date');
        $educatorAdmission->school_location = $validated['school_location'] ?? '';
        $educatorAdmission->type_of_educator = $validated['type_of_educator'] ?? '';
        $educatorAdmission->grades_taught = $validated['grades_taught'] ?? '';
        $educatorAdmission->subjects_taught = $validated['subjects_taught'] ?? '';

        Mail::to($educatorAdmission->email)
            ->send(new FormEducatorAdmission($educatorAdmission));

        return redirect(route('forms.educator-admission-request.thanks'));

    }


    private function getSubscriptionsArray($selected)
    {
        $subs = ExactTargetList::getList();

        $list = [];
        foreach($subs as $value => $label) {
            $item = [
              'type' => 'checkbox',
              'variation' => '',
              'id' => 'subscriptions-'.$value,
              'name' => 'subscriptions[]',
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

    private function getPreferencesArray($selected)
    {
        $prefs = array('html' => 'HTML emails', 'plain_text' => 'Plain text emails (AOL 6.0 and older)');

        $list = [];
        foreach($prefs as $value => $label) {
            $item = [
              'type' => 'radio',
              'variation' => '',
              'id' => 'preferences_'.$value,
              'name' => 'preferences',
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


    private function old($field) {
        return $this->old->$field ?? old($field);
    }
}
