<?php

return [
    // Package Service Providers...
    A17\Twill\TwillServiceProvider::class,

    // Application Service Providers...
    App\Providers\AppServiceProvider::class,
    App\Providers\InvalidationServiceProvider::class,

    Aic\Hub\Foundation\Providers\ResourceServiceProvider::class
];
