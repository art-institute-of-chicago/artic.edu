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
        $deRow->Name = $this->list;

        $response = $deRow->post();

        if ($response->status) {
            return true;
        } else {
            // If we wet an error and it's a code 2, means the email already exists. Return true
            $existent = isset($response->results[0]->ErrorCode) && $response->results[0]->ErrorCode == 2;

            return $existent;
        }
    }
}
