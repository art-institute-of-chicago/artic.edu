<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class VendorServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(\A17\Twill\Models\Block::class, \App\Models\Vendor\Block::class);
    }
}
