<?php

namespace App\Libraries;

use App\Models\ExactTargetList;
use digitaladditive\ExactTargetLaravel\ExactTargetLaravelApi;
use FuelSdk\ET_Client;
use FuelSdk\ET_DataExtension_Row;
use FuelSdk\ET_DataExtension;
use FuelSdk\ET_Subscriber;

class ExactTargetService
{
    protected $email;
    protected $list;

    function __construct($email, $list = null)
    {
        $this->email = $email;
        $this->list  = $list;
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
    function subscribe($alsoRemove = true)
    {
        $client = new ET_Client(false, true, config('exact-target'));

        // Add the user to a data extension
        $deRow  = new ET_DataExtension_Row();

        $deRow->authStub = $client;
        $deRow->props = [
            "Email" => $this->email,
        ];

        if ($this->list)
        {
            if (is_array($this->list)) {
                $allLists = ExactTargetList::getList()->except('OptEnews')->keys()->all();
                foreach ($allLists as $list) {
                    if (in_array($list, $this->list)) {
                        $deRow->props[$list] = 'True';
                    }
                    elseif ($alsoRemove) {
                        $deRow->props[$list] = 'False';
                    }
                }
            }
            else {
                $deRow->props[$this->list] = 'True';
            }
        }

        $deRow->CustomerKey = "All Subscribers Master";
        $deRow->Name = "Museum Business Unit";

        $response = $deRow->post();

        // If it fails, try patch
        if (!$response->status) {
            $response = $deRow->patch();

            if (!$response->status) {
                return $response;
            }
        }

        // Add the subscriber
        $subscriber  = new ET_Subscriber();
        $subscriber->authStub = $client;
        $subscriber->props = array("EmailAddress" => $this->email,
                                   "SubscriberKey" => $this->email);
        $response = $subscriber->post();

        if (!$response->status) {
            $error = $response->results[0]->ErrorMessage ?? '';
            $status = $response->results[0]->StatusMessage ?? '';

            if (starts_with($error, 'Violation of PRIMARY KEY constraint')
                || starts_with($status, 'The subscriber is already on the list')) {
                // Email has been previously subscribed, so proceed
            }
            else {
                return $response;
            }
        }

        // Then patch it with some additional properties
        $subscriber->props['Status'] = 'Active';
        $subscriber->Name = "Museum Business Unit";
        $response = $subscriber->patch();

        if (!$response->status) {
            return $response;
        }

        return true;
    }

    function unsubscribe()
    {
        $client = new ET_Client(false, true, config('exact-target'));

        // Delete the user from the data extension
        $deRow  = new ET_DataExtension_Row();

        $deRow->authStub = $client;
        $deRow->props = [
            "Email" => $this->email,
        ];

        $deRow->CustomerKey = "All Subscribers Master";
        $deRow->Name = "Museum Business Unit";

        $response = $deRow->delete();

        if (!$response->status) {
            return $response;
        }

        // Set the subscriber to Unsubscribed
        $subscriber  = new ET_Subscriber();
        $subscriber->authStub = $client;
        $subscriber->props = array("EmailAddress" => $this->email,
                                   "SubscriberKey" => $this->email,
                                   "Status" => "Unsubscribed");
        $subscriber->Name = "Museum Business Unit";
        $response = $subscriber->patch();

        if (!$response->status) {
            return $response;
        }

        return true;
    }

    function get()
    {
        $client = new ET_Client(false, true, config('exact-target'));

        $deRow  = new ET_DataExtension_Row();
        $deRow->authStub = $client;

        // Select
        $fields = array_merge(['Email', 'FirstName', 'LastName'], ExactTargetList::getList()->except('OptEnews')->keys()->all());
        $deRow->props = array_fill_keys($fields, 'True');

        // From
        $deRow->Name = "All Subscribers Master";

        // Where
        $deRow->filter = [
            'Property' => 'Email',
            'SimpleOperator' => 'equals',
            'Value' => $this->email,
        ];

        return $deRow->get();
    }
}
