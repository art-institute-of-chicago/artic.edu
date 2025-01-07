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
    private $old;

    public function index(Request $request)
    {
        $withErrors = [];

        $this->old = new EmailSubscriptions();

        if (request('e')) {
            $email = $this->getDecryptedEmail(request('e'));

            $exactTarget = new ExactTargetService($email);
            $response = $exactTarget->get();

            if (isset($response['items']) && count($response['items'])) {
                // When a new property gets added to the data extension,
                // even if it is given a default value, existing records
                // will not be updated with that value. We need to assume
                // some true/false defaults here.
                foreach ($response['items'][0]['keys'] as $key => $value) {
                    switch ($key) {
                        case 'email':
                            $this->old->email = $value;
                            break;
                    }
                }
                foreach ($response['items'][0]['values'] as $key => $value) {
                    switch ($key) {
                        case 'firstname':
                            $this->old->first_name = $value;
                            break;
                        case 'lastname':
                            $this->old->last_name = $value;
                            break;
                    }
                }
                foreach (ExactTargetList::getList() as $sub => $name) {
                    if (isset($response['items'][0]['values'][Str::lower($sub)])) {
                        $value = $response['items'][0]['values'][Str::lower($sub)];
                        $this->old->{$sub} = !empty($value) && strtolower($value) == 'true';
                    }
                }
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
                    'type' => 'text',
                    'content' => '<p>Set your preferences: check to opt-in, uncheck to opt-out and click &ldquo;Update&rdquo; to submit.</p>',
                ],
                [
                    'type' => 'label',
                    'variation' => 'm-fieldset__group-label',
                    'error' => (!empty($errors) && $errors->first('subscriptions')) ? $errors->first('subscriptions') : null,
                    'optional' => null,
                    'hint' => null,
                    'label' => '',
                ],
                ...$this->getSubscriptionsArray(),
            ],
        ];

        $subscriptionsFields[] = $subFields;

        // Unsubscribe
        $unsubscribeFields[] = [
            'variation' => 'm-fieldset__field--group',
            'blocks' => array_merge(
                $this->getUnsubscribeBlocks(
                    'unsubscribeFromMuseum',
                    'I no longer wish to receive museum marketing emails.',
                    [
                        'checked' => $this->getOld('OptMuseum') === false
                            ? 'checked'
                            : false,
                    ]
                ),
                // $this->getUnsubscribeBlocks(
                //     'unsubscribeFromShop',
                //     'I no longer wish to receive museum shop emails.'
                // ),
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
                    'placeholder' => 'your@email.com',
                    'autocomplete' => 'email',
                    'textCount' => false,
                    'value' => $this->getOld('email'),
                    'error' => (!empty($errors) && $errors->first('email')) ? $errors->first('email') : null,
                    'optional' => false,
                    'hint' => null,
                    'disabled' => false,
                    'label' => 'Email *',
                ],
            ],
        ];

        if (request('e')) {
            $personalInformationFields[] = [
                'variation' => 'm-fieldset__field--flush',
                'blocks' => [
                    [
                        'type' => 'hidden',
                        'id' => 'encrypted_email',
                        'value' => request('e'),
                    ],
                ],
            ];
        }

        $personalInformationFields[] = [
            'variation' => null,
            'blocks' => [
                [
                    'type' => 'input',
                    'variation' => null,
                    'id' => 'first_name',
                    'autocomplete' => 'given-name',
                    'textCount' => false,
                    'value' => $this->getOld('first_name'),
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
                    'autocomplete' => 'family-name',
                    'textCount' => false,
                    'value' => $this->getOld('last_name'),
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
            'behavior' => 'emailSubscriptions',
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

    private function getUnsubscribeBlocks(
        string $fieldName,
        string $fieldLabel,
        array $checkboxModifiers = []
    ): array {
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

        $out[] = array_merge([
            'type' => 'checkbox',
            'variation' => '',
            'id' => $fieldName,
            'name' => $fieldName,
            'value' => $fieldName,
            'error' => null,
            'optional' => null,
            'hint' => null,
            'autocomplete' => false,
            'disabled' => false,
            'checked' => $this->getOld($fieldName) ?? false,
            'label' => $fieldLabel,
            'behavior' => 'formUnsubscribe'
        ], $checkboxModifiers);

        return $out;
    }

    public function store(EmailSubscriptionsRequest $request)
    {
        $validated = $request->validated();

        $wasFormPrefilled = $validated['email'] === $this->getDecryptedEmail(
            $validated['encrypted_email'] ?? null
        );

        $exactTarget = new ExactTargetService(
            $validated['email'],
            $validated['subscriptions'] ?? null,
            $validated['first_name'] ?? null,
            $validated['last_name'] ?? null,
            $wasFormPrefilled
        );

        $unsubscribeFromMuseum = $this->getCheckbox('unsubscribeFromMuseum', $validated);
        $unsubscribeFromShop = $this->getCheckbox('unsubscribeFromShop', $validated);
        $unsubscribeFromAll = $this->getCheckbox('unsubscribeFromAll', $validated);

        if (!in_array('OptShop', $validated['subscriptions'] ?? [])) {
            $unsubscribeFromShop = true;
        }

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

    private function getSubscriptionsArray(): array
    {
        $subs = ExactTargetList::getList();
        $list = [];

        foreach ($subs as $value => $label) {
            $isChecked = $this->getOld($value) ?? false;
            $isDisabled = $this->getOld('OptMuseum') === false && $value !== 'OptShop';

            if ($value === 'OptMuseum') {
                $isChecked = $this->getOld($value) ?? true;
                $isDisabled = true;
            }

            $item = [
                'type' => 'checkbox',
                'variation' => '',
                'id' => 'subscriptions-' . $value,
                'name' => 'subscriptions[]',
                'value' => $value,
                'error' => null,
                'optional' => null,
                'hint' => null,
                'autocomplete' => false,
                'disabled' => $isDisabled ? 'disabled' : false,
                'checked' => $isChecked ? 'checked' : false,
                'label' => $label
            ];

            $list[] = $item;
        }

        return $list;
    }

    private function getOld($field)
    {
        return $this->old->{$field} ?? old($field);
    }

    private function getCheckbox(string $field, array $validated): bool
    {
        return array_key_exists($field, $validated) && $validated[$field];
    }

    private function getDecryptedEmail($encryptedEmail)
    {
        return trim(openssl_decrypt(
            base64_decode($encryptedEmail),
            'des-ede3-ecb',
            hex2bin(config('exact-target.encryption_key')),
            OPENSSL_ZERO_PADDING,
            ''
        ));
    }
}
