<?php

namespace App\Libraries;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\ExactTargetList;

class ExactTargetService
{
    protected $email;
    protected $list;
    protected $firstName;
    protected $lastName;
    protected $wasFormPrefilled;

    public function __construct(
        $email,
        $list = null,
        $firstName = null,
        $lastName = null,
        $wasFormPrefilled = null
    ) {
        $this->email = $email;
        $this->list = $list;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->wasFormPrefilled = $wasFormPrefilled;
    }

    /**
     * Subscribe a user to our email lists
     *
     * The also remove flag is used in contexts where an array of newsletters are passed
     * to $this->list. On the Email Subscriptions page where a user can see all the
     * lists they're already signed up to, it makes sense to remove them from unselected
     * lists. But on the inline form where they're entering in their email address and
     * they can't see what they're already signed up to, it doesn't make sense to remove
     * them from unchecked lists.
     */
    public function subscribe($alsoRemove = true)
    {
        $accessToken = $this->getAccessToken();
        $dataExtensionKey = config('exact-target.customer_key');
        $props = [
            'OptMuseum' => 'True',
        ];

        if ($this->list) {
            if (!is_array($this->list)) {
                $this->list = [$this->list];
            }

            $allLists = ExactTargetList::getList()->keys()->all();

            foreach ($allLists as $list) {
                if (in_array($list, $this->list)) {
                    $props[$list] = 'True';
                } elseif ($alsoRemove) {
                    $props[$list] = 'False';
                }
            }
        }

        if ($this->wasFormPrefilled || $this->firstName) {
            $props['FirstName'] = $this->firstName;
        }

        if ($this->wasFormPrefilled || $this->lastName) {
            $props['LastName'] = $this->lastName;
        }

        $response = Http::withToken($accessToken)->post(
            config('exact-target.client.baseUrl') . "hub/v1/dataeventsasync/key:$dataExtensionKey/rowset",
            [
                [
                    'keys' => [
                        'Email' => $this->email
                    ],
                    'values' => $props
                ]
            ]
        );

        if ($response->failed()) {
            return $response->json();
        }

        return true;
    }

    /**
     * WEB-2401: Only use this function for `unsubscribeFromAll`, not partial.
     */
    public function unsubscribe()
    {
        $accessToken = $this->getAccessToken();
        $dataExtensionKey = config('exact-target.customer_key');

        // Delete the user from the data extension
        $response = Http::withToken($accessToken)->delete(
            config('exact-target.client.baseUrl') . "hub/v1/dataevents/key:$dataExtensionKey/rowset",
            [
                'keys' => [
                    'Email' => $this->email
                ]
            ]
        );

        if ($response->failed()) {
            return $response->json();
        }

        return true;
    }

    public function get()
    {
        $accessToken = $this->getAccessToken();
        $dataExtensionKey = config('exact-target.customer_key');
        $fields = array_merge([
            'Email',
            'FirstName',
            'LastName',
        ], ExactTargetList::getList()->keys()->all());

        $response = Http::withToken($accessToken)->get(
            config('exact-target.client.baseUrl') . "data/v1/customobjectdata/key:$dataExtensionKey/rowset",
            [
                'fields' => implode(',', $fields),
                'filter' => [
                    'Property' => 'Email',
                    'SimpleOperator' => 'equals',
                    'Value' => $this->email
                ]
            ]
        );

        return $response->json();
    }

    protected function getAccessToken()
    {
        $auth_url = config('exact-target.client.baseAuthUrl');

        $response = Http::asForm()->post($auth_url . "v2/token", [
            'grant_type' => 'client_credentials',
            'client_id' => config('exact-target.client.clientid'),
            'client_secret' => config('exact-target.client.clientsecret'),
        ]);


        if ($response->failed()) {
            throw new \Exception('Unable to retrieve access token');
        }

        return $response->json()['access_token'];
    }
}
