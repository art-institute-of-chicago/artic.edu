<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInterstitialFieldsToSlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slides', function (Blueprint $table) {
            $table->string('interstitial_headline')->nullable();
            $table->string('body_copy')->nullable();
            $table->string('section_title')->nullable();
            $table->string('object_title')->nullable();
            $table->string('compare_title')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('slides', function (Blueprint $table) {
            $table->dropColumn(['interstitial_headline', 'body_copy', 'section_title', 'object_title', 'compare_title']);
        });
    }
}
