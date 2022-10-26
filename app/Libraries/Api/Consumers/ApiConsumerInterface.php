<?php

namespace App\Libraries\Api\Consumers;

interface ApiConsumerInterface
{
    public function request($method, $uri = '', array $options = []);
    public function adaptParameters($params);
    public function headers($params);
    public function __call($name, $args): mixed;
}
