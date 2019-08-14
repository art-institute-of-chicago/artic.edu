<?php

return [

    /*
    |--------------------------------------------------------------------------
    | The domains that this website serves
    |--------------------------------------------------------------------------
    |
    | List all the domains that this website servers. Any requests outside of
    | this list will be redirected to www.
    |
    */

    'domains' => array_map('trim', explode(',', env('AIC_DOMAINS', 'www.artic.edu'))),

];
