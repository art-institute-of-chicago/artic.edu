<?php

namespace Tests\Feature;

use Aic\Hub\Foundation\Testing\FeatureTestCase as BaseTestCase;

class TranslationsTest extends BaseTestCase
{
    protected $seed = true;

    public function test_page_id_6_translations() // Update me!
    {
        // TODO Test the page where page_id = 6, from TranslationsSeeder:
        // $cols = DB::selectOne('select * from page_translations where page_id = ? and locale = ?', [6, 'en']);
        $this->markTestIncomplete('Visit this page and check translated text is present.');
    }

    public function test_dining_hours_translations()
    {
        $this->markTestIncomplete('Visit the page(s) that lists dining hours and check translated text is present.');
    }

    public function test_faqs_translations()
    {
        $this->markTestIncomplete('Visit the page(s) that display the FAQs and check translated text is present.');
    }

    public function test_fee_ages_translations()
    {
        $this->markTestIncomplete('Visit the page(s) that list fees by age and check translated text is present.');
    }

    public function test_fee_categories_translations()
    {
        $this->markTestIncomplete('Visit the page(s) that list fees by category and check translated text is present.');
    }

    public function test_locations_translations()
    {
        $this->markTestIncomplete('Visit the page(s) that list locations and check translated text is present.');
    }
}
