<?php

namespace App\Libraries\Api\Builders\Connection;

interface ApiConnectionInterface
{

    public function __construct();
    public function get($endpoint, $params);
    public function execute($verb = 'GET', $endpoint = null, $params = []);

}
