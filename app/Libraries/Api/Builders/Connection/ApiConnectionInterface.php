<?php

namespace App\Libraries\Api\Builders\Connection;

interface ApiConnectionInterface
{

    public function __construct($endpoint);
    public function get($params);
    public function execute($verb = 'GET', $endpoint = null, $params = []);

}
