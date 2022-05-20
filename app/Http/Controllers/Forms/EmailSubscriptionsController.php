<?php

namespace App\Http\Controllers\Forms;

use Illuminate\Support\Str;

use App\Http\Requests\Form\EmailSubscriptionsRequest;

use App\Libraries\ExactTargetService;

use App\Models\ExactTargetList;
use App\Models\Form\EmailSubscriptions;

class EmailSubscriptionsController extends FormController
{
    protected $old;

    public function index(\Illuminate\Http\Request $request)
    {
        $withErrors = [];

        if (request('e')) {
            $email = base64_decode(request('e'));

            $exactTarget = new ExactTargetService($email);
            $response = $exactTarget->get();

            if ($response->status && $response->code == 200 && count($response->results)) {
                $old = new EmailSubscriptions();
                $subscriptions = [];
                foreach ($response->results[0]->Properties->Property as $index => $keyval) {
                    if ($keyval->Name == 'Email') {
                        $old->email = $keyval->Value;
                    } elseif ($keyval->Name == 'FirstName') {
                        $old->first_name = $keyval->Value;
                    } elseif ($keyval->Name == 'LastName') {
                        $old->last_name = $keyval->Value;
                    } elseif ($keyval->Value == 'True') {
                        $subscriptions[] = $keyval->Name;
                    }
                }
                $old->subscriptions = $subscriptions;
                $this->old = $old;
            } else {
                $withErrors['message'] = 'Your e-mail address is not currently subscribed. Please fill out and submit the form below to begin receiving messages from the Art Institute of Chicago.';
            }
        }
        $this->title = 'Email Subscriptions';
        $this->seo->setTitle($this->title);

        $blocks = [];
        $formBlocks = [];
        $subscriptionsFields = [];
        $personalInformationFields = [];
        $unsubscribeFields = [];

        $errors = session('errors');

        // Subscriptions information
        $subFields = [
            'variation' => 'm-fieldset__field--group',
            'blocks' => [
                [
                    'type' => 'label',
                    'variation' => 'm-fieldset__group-label',
                    'error' => (!empty($errors) && $errors->first('subscriptions')) ? $errors->first('subscriptions') : null,
                    'optional' => null,
                    'hint' => null,
                    'label' => '',
                ]
            ],
        ];
        foreach ($this->getSubscriptionsArray($this->old('subscriptions')) as $d) {
            array_push($subFields['blocks'], $d);
        }
        $subscriptionsFields[] = $subFields;

        // Unsubscribe
        $unsubscribeFields[] = [
            'variation' => 'm-fieldset__field--group',
            'blocks' => array_merge(
                $this->getUnsubscribeBlocks(
                    'unsubscribeFromMuseum',
                    'I no longer wish to receive museum marketing emails..'
                ),
                $this->getUnsubscribeBlocks(
                    'unsubscribeFromShop',
                    'I no longer wish to receive museum shop emails.'
                ),
                $this->getUnsubscribeBlocks(
                    'unsubscribeFromAll',
                    'I no longer wish to receive any Art Institute emails.'
                )
            ),
        ];

        // Personal information
        $personalInformationFields[] = [
            'variation' => null,
            'blocks' => [
                [
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
                ],
            ],
        ];

        $personalInformationFields[] = [
            'variation' => null,
            'blocks' => [
                [
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
                ],
            ],
        ];

        $personalInformationFields[] = [
            'variation' => null,
            'blocks' => [
                [
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
                ],
            ],
        ];

        $personalInformationFields[] = [
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
            'fields' => $subscriptionsFields,
            'legend' => 'Newsletter Options',
        ]);

        array_push($formBlocks, [
            'type' => 'fieldset',
            'variation' => null,
            'fields' => $unsubscribeFields,
            'legend' => 'Unsubscribe',
        ]);

        array_push($formBlocks, [
            'type' => 'fieldset',
            'variation' => null,
            'fields' => $personalInformationFields,
            'legend' => 'Personal Information',
        ]);

        array_push($blocks, [
            'type' => 'form',
            'variation' => null,
            'action' => '/email-subscriptions',
            'method' => 'POST',
            'blocks' => $formBlocks,
            'actions' => [
                [
                    'variation' => null,
                    'type' => 'submit',
                    'label' => 'Update',
                ]
            ]
        ]);

        $view_data = [
            'subNav' => [],
            'nav' => [],
            'title' => $this->title,
            'blocks' => $blocks
        ];

        return view('site.forms.form', $view_data)->withErrors($withErrors, 'notices');
    }

    private function getUnsubscribeBlocks($fieldName, $fieldLabel)
    {
        $errors = session('errors');

        $out = [];

        if (!empty($errors) && $errors->first($fieldName)) {
            $out[] = [
                'type' => 'label',
                'variation' => 'm-fieldset__group-label',
                'error' => (!empty($errors) && $errors->first($fieldName))
                    ? $errors->first($fieldName)
                    : null,
                'optional' => null,
                'hint' => null,
                'label' => '',
            ];
        }

        $out[] = [
            'type' => 'checkbox',
            'variation' => '',
            'id' => $fieldName,
            'name' => $fieldName,
            'value' => $fieldName,
            'error' => null,
            'optional' => null,
            'hint' => null,
            'disabled' => false,
            'checked' => $this->old($fieldName) ?? false,
            'label' => $fieldLabel,
            'behavior' => 'formUnsubscribe'
        ];

        return $out;
    }

    public function store(EmailSubscriptionsRequest $request)
    {
        $validated = $request->validated();

        $exactTarget = new ExactTargetService($validated['email'], $validated['subscriptions'] ?? null);

        $unsubscribeFromMuseum = $this->getCheckbox('unsubscribeFromMuseum', $validated);
        $unsubscribeFromShop = $this->getCheckbox('unsubscribeFromShop', $validated);
        $unsubscribeFromAll = $this->getCheckbox('unsubscribeFromAll', $validated);

        if ($unsubscribeFromShop && $unsubscribeFromMuseum) {
            $unsubscribeFromAll = true;
        }

        if ($unsubscribeFromAll) {
            $response = $exactTarget->unsubscribe();

            if ($response !== true) {
                /* If the user doesn't exist in our email list, ET will throw an
                 * error. It's ok if the user doesn't exist, because that's
                 * ultimately what we want. So idenfity if this is the case and
                 * provide a message to the user. The full expected error is
                 * 'Concurrency violation: the DeleteCommand affected 0 of the
                 * expected 1 records.' [WEB-1427]
                 */
                if (Str::startsWith(($response->results[0]->ErrorMessage ?? ''), 'Concurrency violation')) {
                    return redirect(route('forms.email-subscriptions'))->withErrors(['email' => 'This email address does not exist in our email list. Please check the address and try again.']);
                }
            }
        } else {
            $response = $exactTarget->subscribe();
        }

        if ($response === true) {
            return redirect(route('forms.email-subscriptions.thanks'));
        }

        abort(500, 'Error signing up to newsletters. Please check your email address and try again.');
    }

    private function getSubscriptionsArray($selected)
    {
        $subs = ExactTargetList::getList();

        $list = [];
        foreach ($subs as $value => $label) {
            $item = [
                'type' => 'checkbox',
                'variation' => '',
                'id' => 'subscriptions-' . $value,
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

    private function old($field)
    {
        return $this->old->{$field} ?? old($field);
    }

    private function getCheckbox(string $field, array $validated): boolean
    {
        return array_key_exists($field, $validated) && $validated[$field];
    }
}
