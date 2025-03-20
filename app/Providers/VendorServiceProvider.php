<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use A17\Twill\Models\Block as TwillBLock;
use App\Models\Vendor\Block as VendorBlock;

class VendorServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(TwillBlock::class, VendorBlock::class);
    }
}
