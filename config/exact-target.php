<?php
return [
    'client' => [
        'appsignature' => 'none',
        'clientid' => env('EXACT_TARGET_CLIENT_ID'),
        'clientsecret' => env('EXACT_TARGET_SECRET'),
        'defaultwsdl' => 'https://webservice.exacttarget.com/etframework.wsdl',
        'xmlloc' => 'https://webservice.exacttarget.com/etframework.wsdl',
        'baseUrl' => 'https://www.exacttargetapis.com',
        'baseAuthUrl' => 'https://auth.exacttargetapis.com',
        'proxyhost' => '',
        'proxyport' => '',
        'proxyusername' => '',
        'proxypassword' => '',
    ],
    'customer_key' => env('EXACT_TARGET_CUSTOMER_KEY'),
    'name' => env('EXACT_TARGET_NAME'),
];
