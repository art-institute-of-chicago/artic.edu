<?php

namespace App\Http\Controllers\Forms;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Http\Requests\Form\EmailSubscriptionsRequest;

use App\Libraries\ExactTargetService;

use App\Models\ExactTargetList;
use App\Models\Form\EmailSubscriptions;

class EmailSubscriptionsController extends FormController
{
    public function index(Request $request)
    {
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

        foreach ($this->getSubscriptionsArray(old('subscriptions')) as $d) {
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
                    'value' => old('email'),
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
                    'value' => old('first_name'),
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
                    'value' => old('last_name'),
                    'error' => (!empty($errors) && $errors->first('last_name')) ? $errors->first('last_name') : null,
                    'optional' => null,
                    'hint' => null,
                    'disabled' => false,
                    'label' => 'Last Name',
                ],
            ],
        ];


        if (!config('aic.disable_captcha')) {
            $personalInformationFields[] = [
                'variation' => null,
                'blocks' => [
                    [
                        'type' => 'captcha',
                        'variation' => null,
                        'id' => 'captcha',
                        'error' => (!empty($errors) && $errors->first('captcha'))
                            ? $errors->first('captcha')
                            : null,
                        'optional' => null,
                        'hint' => null,
                        'disabled' => false,
                        'label' => '',
                    ],
                ],
            ];
        }

        $formBlocks[] = [
            'type' => 'fieldset',
            'variation' => null,
            'fields' => $subscriptionsFields,
            'legend' => 'Newsletter Options',
        ];

        $formBlocks[] = [
            'type' => 'fieldset',
            'variation' => null,
            'fields' => $unsubscribeFields,
            'legend' => 'Unsubscribe',
        ];

        $formBlocks[] = [
            'type' => 'fieldset',
            'variation' => null,
            'fields' => $personalInformationFields,
            'legend' => 'Personal Information',
        ];

        $blocks[] = [
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
        ];

        $view_data = [
            'subNav' => [],
            'nav' => [],
            'title' => $this->title,
            'blocks' => $blocks
        ];

        return view('site.forms.form', $view_data);
    }

    private function getUnsubscribeBlocks($fieldName, $fieldLabel): array
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
            'checked' => old($fieldName) ?? false,
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
                 * ultimately what we want. So identify if this is the case and
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

        // TODO: This message won't render due to `getTwillErrorView`
        abort(500, 'Error signing up to newsletters. Please check your email address and try again.');
    }

    private function getSubscriptionsArray($selected): array
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

    private function getCheckbox(string $field, array $validated): bool
    {
        return array_key_exists($field, $validated) && $validated[$field];
    }
}
