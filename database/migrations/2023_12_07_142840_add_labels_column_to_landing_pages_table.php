<?php

use App\Models\LandingPage;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('landing_pages', function (Blueprint $table) {
            $table->json('labels')->nullable();
        });

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
                default:
                    $prefix = null;
                    break;
            }
            if (!$prefix) {
                continue;
            }
            $landingPage->labels = collect($landingPage->getAttributes())
                ->filter(fn ($value, $key) => str($key)->startsWith($prefix) && !is_null($value));
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

        // Rename prefixed hours columns
        Schema::table('landing_pages', function (Blueprint $table) {
            $table->renameColumn('visit_hide_hours', 'hide_hours');
            $table->renameColumn('visit_hour_image_caption', 'hour_image_caption');
            $table->renameColumn('visit_hour_header', 'hour_header');
            $table->renameColumn('visit_hour_subheader', 'hour_subheader');
            $table->renameColumn('visit_hour_intro', 'hour_intro');
        });
    }

    public function down(): void
    {
        Schema::table('landing_pages', function (Blueprint $table) {
            $table->renameColumn('hide_hours', 'visit_hide_hours');
            $table->renameColumn('hour_image_caption', 'visit_hour_image_caption');
            $table->renameColumn('hour_header', 'visit_hour_header');
            $table->renameColumn('hour_subheader', 'visit_hour_subheader');
            $table->renameColumn('hour_intro', 'visit_hour_intro');
        });
        Schema::table('landing_pages', function (Blueprint $table) {
            $table->dropColumn('labels');
        });
    }
};
