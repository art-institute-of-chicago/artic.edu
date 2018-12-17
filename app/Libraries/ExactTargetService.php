<?php

namespace App\Libraries;

use digitaladditive\ExactTargetLaravel\ExactTargetLaravelApi;
use FuelSdk\ET_Client;
use FuelSdk\ET_DataExtension_Row;
use FuelSdk\ET_DataExtension;

class ExactTargetService
{
    protected $email;
    protected $list;

    function __construct($email, $list)
    {
        $this->email = $email;
        $this->list  = $list;
    }

    function subscribe()
    {
        $client = new ET_Client(false, true, config('exact-target'));
        $deRow  = new ET_DataExtension_Row();

        $deRow->authStub = $client;
        $deRow->props = array("email" => $this->email);
        if ($this->list)
        {
            $deRow->props[$this->list] = 'Y';
        }

        $deRow->Name = "Museum Business Unit";
        $deRow->CustomerKey = "All Subscribers Master";

        $response = $deRow->post();

        // If the request is successful, go ahead and return
        if ($response->status) {
            return true;
        }

        // Otherwise, return the response
        return $response;
    }
}
