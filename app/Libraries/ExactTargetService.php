<?php

namespace App\Libraries;

use Illuminate\Support\Str;
use App\Models\ExactTargetList;
use FuelSdk\ET_Client;
use FuelSdk\ET_DataExtension_Row;
use FuelSdk\ET_Subscriber;

class ExactTargetService
{
    protected $email;
    protected $list;

    public function __construct($email, $list = null)
    {
        $this->email = $email;
        $this->list = $list;
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

        $auth_url = config('exact-target.client.baseAuthUrl');
        $clientId = config('exact-target.client.clientid');
        $clientSecret = config('exact-target.client.clientsecret');

        $api = new \GuzzleHttp\Client();

        $result = $api->request(
            'POST',
            $auth_url . '/v2/token',
            [
                'json' => [
                    'client_id' => $clientId,
                    'client_secret' => $clientSecret,
                    'grant_type' => 'client_credentials',
                ]
            ]
        );

        $tokenInfo = json_decode($result->getBody()->getContents(), true);

        $client = new ET_Client(
            true,
            config('app.debug'),
            array_merge(
                config('exact-target.client'),
                [
                    'authorizationCode' => $tokenInfo['access_token'],
                    'scope' => $tokenInfo['scope'],
                ]
            )
        );

        // Add the user to a data extension
        $deRow = new ET_DataExtension_Row();

        $deRow->authStub = $client;
        $deRow->props = [
            'Email' => $this->email,
        ];

        if ($this->list) {
            if (!is_array($this->list)) {
                $this->list = [$this->list];
            }

            $allLists = ExactTargetList::getList()->except('OptEnews')->keys()->all();

            foreach ($allLists as $list) {
                if (in_array($list, $this->list)) {
                    $deRow->props[$list] = 'True';
                } elseif ($alsoRemove) {
                    $deRow->props[$list] = 'False';
                }
            }
        }

        $deRow->CustomerKey = config('exact-target.customer_key');
        $deRow->Name = config('exact-target.name');

        $response = $deRow->post();

        // If it fails, try patch
        if (!$response->status) {
            $response = $deRow->patch();

            if (!$response->status) {
                return $response;
            }
        }

        // Add the subscriber
        $subscriber = new ET_Subscriber();
        $subscriber->authStub = $client;
        $subscriber->props = [
            'EmailAddress' => $this->email,
            'SubscriberKey' => $this->email,
        ];
        $response = $subscriber->post();

        if (!$response->status) {
            $error = $response->results[0]->ErrorMessage ?? '';
            $status = $response->results[0]->StatusMessage ?? '';

            if (Str::startsWith($error, 'Violation of PRIMARY KEY constraint')
                || Str::startsWith($status, 'The subscriber is already on the list')) {
                // Email has been previously subscribed, so proceed
            } else {
                return $response;
            }
        }

        // Then patch it with some additional properties
        $subscriber->props['Status'] = 'Active';
        $subscriber->Name = 'Museum Business Unit';
        $response = $subscriber->patch();

        if (!$response->status) {
            return $response;
        }

        return true;
    }

    /**
     * WEB-2401: Only use this function for `unsubscribeFromAll`, not partial.
     */
    public function unsubscribe()
    {
        $client = new ET_Client(
            true,
            config('app.debug'),
            config('exact-target.client')
        );

        // Delete the user from the data extension
        $deRow = new ET_DataExtension_Row();

        $deRow->authStub = $client;
        $deRow->props = [
            'Email' => $this->email,
        ];

        $deRow->CustomerKey = config('exact-target.customer_key');
        $deRow->Name = config('exact-target.name');

        $response = $deRow->delete();

        if (!$response->status) {
            return $response;
        }

        // Set the subscriber to Unsubscribed
        $subscriber = new ET_Subscriber();
        $subscriber->authStub = $client;
        $subscriber->props = [
            'EmailAddress' => $this->email,
            'SubscriberKey' => $this->email,
            'Status' => 'Unsubscribed'
        ];
        $subscriber->Name = 'Museum Business Unit';
        $response = $subscriber->patch();

        if (!$response->status) {
            return $response;
        }

        return true;
    }

    public function get()
    {
        $client = new ET_Client(false, config('app.debug'), config('exact-target.client'));

        $deRow = new ET_DataExtension_Row();
        $deRow->authStub = $client;

        // Select
        $allLists = ExactTargetList::getList()->except('OptEnews')->keys()->all();
        $fields = array_merge(
            [
                'Email',
                'FirstName',
                'LastName',
            ],
            $allLists
        );

        $deRow->props = array_fill_keys($fields, 'True');

        // From
        $deRow->Name = 'All Subscribers Master';

        // Where
        $deRow->filter = [
            'Property' => 'Email',
            'SimpleOperator' => 'equals',
            'Value' => $this->email,
        ];

        return $deRow->get();
    }
}
