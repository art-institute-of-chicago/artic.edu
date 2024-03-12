<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\LandingPage;

return new class () extends Migration {
    public function up(): void
    {
        // Copy relevant columns to labels json column
        foreach (LandingPage::all() as $landingPage) {
            switch ($landingPage->type_id) {
                case 1:
                    $prefix = 'home_';
                    break;
                case 2:
                    $prefix = 'exhibition_intro';
                    break;
                case 4:
                    $prefix = 'visit_';
                    break;
                case 6:
                    $prefix = 'exhibition_history_';
                    break;
                case 7:
                    $prefix = 'art_intro';
                    break;
                case 8:
                    $prefix = 'resources_landing_';
                    break;
                case 9:
                    $prefix = 'printed_publications_';
                    break;
                case 11:
                    $prefix = 'tours_';
                    break;
                default:
                    $prefix = null;
                    break;
            }
            if (!$prefix) {
                continue;
            }
            $landingPage->labels = collect($landingPage->getAttributes())
                ->filter(fn ($value, $key) => str($key)->startsWith($prefix) && is_null($value));
            $landingPage->save();

            // Remove common hours keys
            if ($landingPage->type_id == 4) {
                $landingPage->labels->pull('visit_hide_hours');
                $landingPage->labels->pull('visit_hour_image_caption');
                $landingPage->labels->pull('visit_hour_header');
                $landingPage->labels->pull('visit_hour_subheader');
                $landingPage->labels->pull('visit_hour_intro');
            }
            // Re-prefix intro
            if ($landingPage->type_id == 8) {
                $landingPage->labels->put('resources_landing_intro', $landingPage->art_intro);
            }
            $landingPage->save();
        }
    }

    public function down(): void
    {
    }
};
