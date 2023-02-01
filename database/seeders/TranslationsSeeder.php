<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TranslationsSeeder extends Seeder
{
    public function run()
    {
        // TODO: I'm unsure what to do about this one, since the translation
        // tables won't exist by the time this seeder is running.
        /*
        $visitPage = \App\Models\Page::where('type', 3)->first();

        if ($visitPage) {
            foreach (config('translatable.locales') as $locale) {
                DB::table('page_translations')->insert([
                    'locale' => $locale,
                    'active' => true,
                    'page_id' => $visitPage->id,
                    'visit_intro' => $visitPage->visit_intro,
                    'visit_hour_header' => $visitPage->visit_hour_header,
                    'visit_hour_subheader' => $visitPage->visit_hour_subheader,
                    'visit_city_pass_title' => $visitPage->visit_city_pass_title,
                    'visit_city_pass_text' => $visitPage->visit_city_pass_text,
                    'visit_city_pass_button_label' => $visitPage->visit_city_pass_button_label,
                    'visit_admission_description' => $visitPage->visit_admission_description,
                    'visit_buy_tickets_label' => $visitPage->visit_buy_tickets_label,
                    'visit_become_member_label' => $visitPage->visit_become_member_label,
                ]);
            }
        }

        DB::update('update page_translations set visit_city_pass_link = (select visit_city_pass_link from pages where pages.id=page_translations.page_id)');

        if (env('APP_ENV') != 'testing') {
            // Copy content from the translatable field to the table
            $cols = DB::selectOne('select * from page_translations where page_id = ? and locale = ?', [6, 'en']);
            DB::update(
                'update pages set '
                    . 'visit_intro = ?, '
                    . 'visit_hour_header = ?, '
                    . 'visit_hour_subheader = ?, '
                    . 'visit_hour_intro = ?, '
                    . 'visit_city_pass_title = ?, '
                    . 'visit_city_pass_text = ?, '
                    . 'visit_city_pass_button_label = ?, '
                    . 'visit_city_pass_link = ?, '
                    . 'visit_admission_description = ?, '
                    . 'visit_buy_tickets_label = ?, '
                    . 'visit_become_member_label = ?, '
                    . 'visit_accessibility_text = ?, '
                    . 'visit_accessibility_link_text = ?, '
                    . 'visit_cta_module_header = ?, '
                    . 'visit_cta_module_body = ?, '
                    . 'visit_cta_module_button_text = ?, '
                    . 'visit_what_to_expect_more_text = ?, '
                    . 'visit_capacity_alt = ?, '
                    . 'visit_capacity_heading = ?, '
                    . 'visit_capacity_text = ?, '
                    . 'visit_capacity_btn_text_1 = ?, '
                    . 'visit_capacity_btn_text_2 = ?, '
                    . 'visit_hour_image_caption = ? '
                    . 'where id = ?',
                [$cols->visit_intro,
                    $cols->visit_hour_header,
                    $cols->visit_hour_subheader,
                    $cols->visit_hour_intro,
                    $cols->visit_city_pass_title,
                    $cols->visit_city_pass_text,
                    $cols->visit_city_pass_button_label,
                    $cols->visit_city_pass_link,
                    $cols->visit_admission_description,
                    $cols->visit_buy_tickets_label,
                    $cols->visit_become_member_label,
                    $cols->visit_accessibility_text,
                    $cols->visit_accessibility_link_text,
                    $cols->visit_cta_module_header,
                    $cols->visit_cta_module_body,
                    $cols->visit_cta_module_button_text,
                    $cols->visit_what_to_expect_more_text,
                    $cols->visit_capacity_alt,
                    $cols->visit_capacity_heading,
                    $cols->visit_capacity_text,
                    $cols->visit_capacity_btn_text_1,
                    $cols->visit_capacity_btn_text_2,
                    $cols->visit_hour_image_caption,
                    6]
            );
        }

        foreach (\App\Models\DiningHour::all() as $diningHour) {
            foreach (config('translatable.locales') as $locale) {
                DB::table('dining_hour_translations')->insert([
                    'locale' => $locale,
                    'active' => true,
                    'dining_hour_id' => $diningHour->id,
                    'name' => $diningHour->name,
                    'hours' => $diningHour->hours,
                ]);
            }
        }

        if (env('APP_ENV') != 'testing') {
            $rows = DB::select('select * from dining_hour_translations where locale = ?', ['en']);

            foreach ($rows as $cols) {
                DB::update(
                    'update dining_hours set '
                    . 'name = ?, '
                    . 'hours = ? '
                    . 'where id = ?',
                    [$cols->name,
                        $cols->hours,
                        $cols->dining_hour_id]
                );
            }
        }

        foreach (\App\Models\Family::all() as $family) {
            foreach (config('translatable.locales') as $locale) {
                DB::table('family_translations')->insert([
                    'locale' => $locale,
                    'active' => true,
                    'family_id' => $family->id,
                    'title' => $family->title,
                    'text' => $family->text,
                    'link_label' => $family->link_label,
                ]);
            }
        }

        if (env('APP_ENV') != 'testing') {
            $rows = DB::select('select * from family_translations where locale = ?', ['en']);

            foreach ($rows as $cols) {
                DB::update(
                    'update families set '
                    . 'title = ?, '
                    . 'text = ?, '
                    . 'link_label = ? '
                    . 'where id = ?',
                    [$cols->title,
                        $cols->text,
                        $cols->link_label,
                        $cols->family_id]
                );
            }
        }

        foreach (\App\Models\Faq::all() as $faq) {
            foreach (config('translatable.locales') as $locale) {
                DB::table('faq_translations')->insert([
                    'locale' => $locale,
                    'active' => true,
                    'faq_id' => $faq->id,
                    'title' => $faq->title,
                ]);
            }
        }

        if (env('APP_ENV') != 'testing') {
            $rows = DB::select('select * from faq_translations where locale = ?', ['en']);

            foreach ($rows as $cols) {
                DB::update(
                    'update faqs set '
                    . 'title = ? '
                    . 'where id = ?',
                    [$cols->title,
                        $cols->faq_id]
                );
            }
        }

        foreach (\App\Models\FeeAge::all() as $feeAge) {
            foreach (config('translatable.locales') as $locale) {
                DB::table('fee_age_translations')->insert([
                    'locale' => $locale,
                    'active' => true,
                    'fee_age_id' => $feeAge->id,
                    'title' => $feeAge->title,
                ]);
            }
        }

        if (env('APP_ENV') != 'testing') {
            $rows = DB::select('select * from fee_age_translations where locale = ?', ['en']);

            foreach ($rows as $cols) {
                DB::update(
                    'update fee_ages set '
                    . 'title = ? '
                    . 'where id = ?',
                    [$cols->title,
                        $cols->fee_age_id]
                );
            }
        }

        foreach (\App\Models\FeeCategory::all() as $feeCategory) {
            foreach (config('translatable.locales') as $locale) {
                DB::table('fee_category_translations')->insert([
                    'locale' => $locale,
                    'active' => true,
                    'fee_category_id' => $feeCategory->id,
                    'title' => $feeCategory->title,
                    'tooltip' => $feeCategory->tooltip,
                ]);
            }
        }

        if (env('APP_ENV') != 'testing') {
            $rows = DB::select('select * from fee_category_translations where locale = ?', ['en']);

            foreach ($rows as $cols) {
                DB::update(
                    'update fee_categories set '
                    . 'title = ?, '
                    . 'tooltip = ? '
                    . 'where id = ?',
                    [$cols->title,
                        $cols->tooltip,
                        $cols->fee_category_id]
                );
            }
        }

        foreach (\App\Models\Location::all() as $location) {
            foreach (config('translatable.locales') as $locale) {
                DB::table('location_translations')->insert([
                    'locale' => $locale,
                    'active' => true,
                    'location_id' => $location->id,
                    'name' => $location->name,
                ]);
            }
        }

        if (env('APP_ENV') != 'testing') {
            $rows = DB::select('select * from location_translations where locale = ?', ['en']);

            foreach ($rows as $cols) {
                DB::update(
                    'update locations set '
                    . 'name = ? '
                    . 'where id = ?',
                    [$cols->name,
                        $cols->location_id]
                );
            }
        }

        if (env('APP_ENV') != 'testing') {
            $rows = DB::select('select * from what_to_expect_translations where locale = ?', ['en']);

            foreach ($rows as $cols) {
                DB::update(
                    'update what_to_expects set '
                    . 'text = ? '
                    . 'where id = ?',
                    [$cols->text,
                        $cols->what_to_expect_id]
                );
            }
        }
        */
    }
}
