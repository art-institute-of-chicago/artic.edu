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
        $id = $item->id;

        if ($item->is_published) {
            $this->urls = [
                route('events', null, false),
                route('exhibitions', null, false),
                route('collection', null, false),
                route('visit', null, false),
                route('articles', null, false),
                '/'
            ];

            $landingPageModel = LandingPage::join('landing_page_slugs', function ($join) use ($id) {
                $join->on('landing_page_slugs.landing_page_id', 'landing_pages.id')
                     ->where('landing_page_slugs.id', $id)
                     ->where('landing_page_slugs.active', true);
            })->first();

            $commandOutput = $this->output;

            if ($landingPageModel) {
                $landingPageSlug = '/' . $landingPageModel->slug;
                Artisan::call('cache:invalidate-cloudfront', [
                    'urls' => [$landingPageSlug],
                ], $commandOutput);
                dump(Artisan::output());
            }
        }
    }
}
