<?php

namespace App\Http\Controllers\Forms;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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

        $withErrors = [];

        if (request('e')) {
            $email = base64_decode(request('e'));

            $exactTarget = new ExactTargetService($email);
            $response = $exactTarget->get();

            if ($response->status && $response->code == 200 && count($response->results)) {
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
                $withErrors['message'] = "Your e-mail address is not currently subscribed. Please fill out and submit the form below to begin receiving messages from the Art Institute of Chicago.";
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
                    'name' => 'unsubscribe',
                    'value' => 'unsubscribe',
                    'error' => null,
                    'optional' => null,
                    'hint' => null,
                    'disabled' => false,
                    'checked' => $this->old('unsubscribe') ?? false,
                    'label' => 'I no longer wish to receive any Art Institute emails.',
                    'behavior' => 'formUnsubscribe'
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

        $view_data = [
            'subNav' => [],
            'nav' => [],
            'title' => $this->title,
            'blocks' => $blocks
        ];

        return view('site.forms.form', $view_data)->withErrors($withErrors, 'notices');
    }

    /**
     * @param EmailSubscriptionsRequest $request
     */
    public function store(EmailSubscriptionsRequest $request)
    {
        $validated = $request->validated();

        $exactTarget = new ExactTargetService($validated['email'], $validated['subscriptions'] ?? null);

        if (array_key_exists('unsubscribe', $validated) && $validated['unsubscribe']) {
            $response = $exactTarget->unsubscribe();
            if ($response !== true) {
                // If the user doesn't exist in our email list, ET will throw an
                // error. It's ok if the user doesn't exist, because that's
                // ultimately what we want. So idenfity if this is the case and
                // provide a message to the user. The full expected error is
                // 'Concurrency violation: the DeleteCommand affected 0 of the
                // expected 1 records.' [WEB-1427]
                if (Str::startsWith(($response->results[0]->ErrorMessage ?? ''), 'Concurrency violation')) {
                    return redirect(route('forms.email-subscriptions'))->withErrors(['email' => 'This email address does not exist in our email list. Please check the address and try again.']);
                }
            }
        }
        else {
            $response = $exactTarget->subscribe();
        }

        if ($response === true) {
            return redirect(route('forms.email-subscriptions.thanks'));
        }
        else {
            abort(500, 'Error signing up to newsletters. Please check your email address and try again.');
        }
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

            if ($value === 'OptEnews') {
                $item['checked'] = 'checked';
                $item['disabled'] = 'disabled';
            }

            $list[] = $item;
        }

        return $list;
    }

    private function old($field) {
        return $this->old->$field ?? old($field);
    }
}
