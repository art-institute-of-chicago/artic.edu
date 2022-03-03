<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropTranslationTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        // Pages

        // Add the columns to the main table
        Schema::table('pages', function (Blueprint $table) {
            $table->string('visit_intro')->nullable();
            $table->string('visit_hour_header')->nullable();
            $table->text('visit_hour_subheader')->nullable();
            $table->text('visit_hour_intro')->nullable();
            $table->string('visit_city_pass_title')->nullable();
            $table->text('visit_city_pass_text')->nullable();
            $table->string('visit_city_pass_button_label')->nullable();
            $table->string('visit_city_pass_link')->nullable();
            $table->text('visit_admission_description')->nullable();
            $table->string('visit_buy_tickets_label')->nullable();
            $table->string('visit_become_member_label')->nullable();
            $table->text('visit_accessibility_text')->nullable();
            $table->text('visit_accessibility_link_text')->nullable();
            $table->text('visit_cta_module_header')->nullable();
            $table->text('visit_cta_module_body')->nullable();
            $table->text('visit_cta_module_button_text')->nullable();
            $table->text('visit_what_to_expect_more_text')->nullable();
            $table->text('visit_capacity_alt')->nullable();
            $table->text('visit_capacity_heading')->nullable();
            $table->text('visit_capacity_text')->nullable();
            $table->text('visit_capacity_btn_text_1')->nullable();
            $table->text('visit_capacity_btn_text_2')->nullable();
            $table->text('visit_hour_image_caption')->nullable();
        });

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

        //
        // Dining hours
        Schema::table('dining_hours', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->text('hours')->nullable();
        });

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

        //
        // Families
        Schema::table('families', function (Blueprint $table) {
            $table->string('title')->nullable();
            $table->text('text')->nullable();
            $table->string('link_label')->nullable();
        });

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

        //
        // FAQs
        Schema::table('faqs', function (Blueprint $table) {
            $table->string('title')->nullable();
        });

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

        //
        // Featured hours
        Schema::table('featured_hours', function (Blueprint $table) {
            $table->string('title')->nullable();
            $table->text('copy')->nullable();
        });

        if (env('APP_ENV') != 'testing') {
            $rows = DB::select('select * from featured_hour_translations where locale = ?', ['en']);
            foreach ($rows as $cols) {
                DB::update(
                    'update featured_hours set '
                    . 'title = ?, '
                    . 'copy = ? '
                    . 'where id = ?',
                    [$cols->title,
                        $cols->copy,
                        $cols->featured_hour_id]
                );
            }
        }

        //
        // Fee ages
        Schema::table('fee_ages', function (Blueprint $table) {
            $table->string('title')->nullable();
        });

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

        //
        // Fee category
        Schema::table('fee_categories', function (Blueprint $table) {
            $table->string('title')->nullable();
            $table->string('tooltip')->nullable();
        });

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

        //
        // Locations
        Schema::table('locations', function (Blueprint $table) {
            $table->string('name')->nullable();
        });

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

        //
        // What to expects
        Schema::table('what_to_expects', function (Blueprint $table) {
            $table->text('text')->nullable();
        });

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

        Schema::dropIfExists('page_translations');
        Schema::dropIfExists('dining_hour_translations');
        Schema::dropIfExists('experience_translations');
        Schema::dropIfExists('family_translations');
        Schema::dropIfExists('faq_translations');
        Schema::dropIfExists('featured_hour_translations');
        Schema::dropIfExists('fee_age_translations');
        Schema::dropIfExists('fee_category_translations');
        Schema::dropIfExists('generic_page_translations');
        Schema::dropIfExists('location_translations');
        Schema::dropIfExists('press_release_translations');
        Schema::dropIfExists('research_guide_translations');
        Schema::dropIfExists('slide_translations');
        Schema::dropIfExists('what_to_expect_translations');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
