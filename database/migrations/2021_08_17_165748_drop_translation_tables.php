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
        Schema::dropIfExists('dining_hour_translations');
        Schema::dropIfExists('experience_translations');
        Schema::dropIfExists('family_translations');
        Schema::dropIfExists('faq_translations');
        Schema::dropIfExists('featured_hour_translations');
        Schema::dropIfExists('fee_age_translations');
        Schema::dropIfExists('fee_category_translations');
        Schema::dropIfExists('generic_page_translations');
        Schema::dropIfExists('location_translations');
        Schema::dropIfExists('page_translations');
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
        //
    }
}
