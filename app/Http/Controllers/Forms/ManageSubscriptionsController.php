<?php

namespace App\Http\Controllers\Forms;

use Illuminate\Support\Facades\Mail;

use App\Http\Requests\Form\ManageSubscriptionsRequest;

use App\Models\ExactTargetList;
use App\Models\Form\ManageSubscriptions;

use App\Mail\FormManageSubscriptions;

use App\Presenters\StaticObjectPresenter;

class ManageSubscriptionsController extends FormController
{
    public function index()
    {

        $this->title = 'Email subscription';
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
        foreach($this->getSubscriptionsArray(old('subscriptions')) as $d) {
            array_push($subFields['blocks'], $d);
        }
        $subscriptionsFields[] = $subFields;


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
                  'value' => old('email'),
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
                  'value' => old('first_name'),
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
                  'value' => old('last_name'),
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
                  'value' => old('company'),
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
        foreach($this->getPreferencesArray(old('preferences')) as $t) {
            array_push($prefFields['blocks'], $t);
        }
        $personalInformationFields[] = $prefFields;

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
                    'checked' => old('unsubscribe') ?? false,
                    'label' => 'I no longer wish to receive any further emails'
                ),
            ),
        ];

        $unsubscribeFields[] = array(
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
          'legend' => 'Subscriptions',
        ));

        array_push($formBlocks, array(
          'type' => 'fieldset',
          'variation' => null,
          'fields' => $personalInformationFields,
          'legend' => 'Personal Information',
        ));

        array_push($formBlocks, array(
          'type' => 'fieldset',
          'variation' => null,
          'fields' => $unsubscribeFields,
          'legend' => 'Unsubscribe',
        ));

        array_push($blocks, array(
            'type' => 'form',
            'variation' => null,
            'action' => '/manage-subscriptions',
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

}
