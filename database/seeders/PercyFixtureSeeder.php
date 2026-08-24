<?php

namespace Database\Seeders;

use App\Models\GenericPage;
use App\Models\LandingPage;
use App\Models\Vendor\Block;
use Illuminate\Database\Seeder;

/**
 * Guarantees the CMS-managed pages that Percy snapshots (Home + one generic
 * page) exist with fixed, published content. Run before starting the app
 * server for a Percy build — see .github/workflows/percy.yml.
 *
 * This is a minimal Home fixture (labels + one self-contained block, with
 * no dependency on live API IDs). For a fuller Home page with the full set
 * of blocks, see the setup in tests/Feature/HomePageTest.php.
 */
class PercyFixtureSeeder extends Seeder
{
    public function run(): void
    {
        $homePage = LandingPage::firstOrNew(['type_id' => 1, 'title' => 'Home']);
        $homePage->published = true;
        $homePage->header_variation = 'default';
        $homePage->labels = [
            'home_intro' => '<p>Welcome to the Art Institute of Chicago.</p>',
            'home_location_label' => '111 S Michigan Ave',
            'home_location_link' => 'https://goo.gl/maps/rWJ5uyDiokKyETnw6',
            'home_buy_tix_label' => 'Buy Tickets',
            'home_buy_tix_link' => 'https://sales.artic.edu/admissions',
        ];
        $homePage->save();

        // Without at least one block, the landing page body renders as an
        // empty, zero-height div, which Playwright treats as never visible.
        // custom_banner is self-contained (static text only, no browser IDs
        // referencing live API content), so it can't render empty/broken.
        $block = Block::firstOrNew([
            'blockable_id' => $homePage->id,
            'blockable_type' => 'landingPages',
            'type' => 'custom_banner',
            'position' => 1,
        ]);
        $block->content = [
            'background_type' => 'background_image',
            'heading' => 'Join our Community',
            'body' => '<p>The best way to lend your support is to become a member.</p>',
            'button_type' => 'custom',
            'button_text' => 'Become a Member',
            'button_url' => 'https://sales.artic.edu/memberships',
            'title' => 'Join our Community',
        ];
        $block->save();

        $genericPage = GenericPage::firstOrNew(['title' => 'Percy Fixture Page']);
        $genericPage->published = true;
        $genericPage->short_description = 'Fixture page used by Percy visual regression snapshots.';
        $genericPage->save();
    }
}
