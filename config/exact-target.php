<?php

return [
    'client' => [
        'appsignature' => 'none',
        'clientid' => env('EXACT_TARGET_CLIENT_ID'),
        'clientsecret' => env('EXACT_TARGET_SECRET'),
        'defaultwsdl' => 'https://webservice.exacttarget.com/etframework.wsdl',
        'xmlloc' => storage_path('app/etframework.wsdl'),
        'baseUrl' => env('EXACT_TARGET_BASE_URL'),
        'baseAuthUrl' => env('EXACT_TARGET_BASE_AUTH_URL'),
        'baseSoapUrl' => env('EXACT_TARGET_BASE_SOAP_URL'),
        'useOAuth2Authentication' => true,
        'accountId' => env('EXACT_TARGET_ACCOUNT_ID'),
    ],
    'customer_key' => env('EXACT_TARGET_CUSTOMER_KEY'),
    'name' => env('EXACT_TARGET_NAME'),
];
