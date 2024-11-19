<?php

namespace App\Http\Controllers\Admin;

class VanityRedirectController extends ModuleController
{
    protected $moduleName = 'vanityRedirects';

    protected $indexOptions = [
        'editInModal' => true,
        'permalink' => false,
    ];

    protected $titleColumnKey = 'path';

    protected $indexColumns = [
        'path' => [
            'title' => 'Vanity path',
            'field' => 'path',
        ],
        'destination' => [
            'title' => 'Destination',
            'field' => 'destination',
        ],
    ];

    protected $defaultOrders = ['path' => 'asc'];
}
