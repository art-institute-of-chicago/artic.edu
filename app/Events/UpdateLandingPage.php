<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Console\Command;
use App\Models\LandingPage;
use Illuminate\Support\Facades\Artisan;

class UpdateLandingPage
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $item;
    public $urls = [];

    public $output;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(LandingPage $item)
    {
        $this->item = $item;

        if ($item->is_published) {
            $landingPageModel = LandingPage::byId($item->id)->first();

            if ($landingPageModel) {
                $this->urls = [
                    '/' . $landingPageModel->slug,
                ];
            }
        }
    }
}
