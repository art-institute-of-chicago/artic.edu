<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddListingDescriptionToPages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('generic_pages', function (Blueprint $table) {
            $table->text('listing_description')->nullable();
        });

        Schema::table('press_releases', function (Blueprint $table) {
            $table->text('listing_description')->nullable();
        });

        Schema::table('research_guides', function (Blueprint $table) {
            $table->text('listing_description')->nullable();
        });

        Schema::table('printed_catalogs', function (Blueprint $table) {
            $table->text('listing_description')->nullable();
        });

        Schema::table('digital_catalogs', function (Blueprint $table) {
            $table->text('listing_description')->nullable();
        });

        Schema::table('scholarly_journals', function (Blueprint $table) {
            $table->text('listing_description')->nullable();
        });

        Schema::table('educator_resources', function (Blueprint $table) {
            $table->text('listing_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('generic_pages', function (Blueprint $table) {
            $table->dropColumn('listing_description');
        });

        Schema::table('press_releases', function (Blueprint $table) {
            $table->dropColumn('listing_description');
        });

        Schema::table('research_guides', function (Blueprint $table) {
            $table->dropColumn('listing_description');
        });

        Schema::table('printed_catalogs', function (Blueprint $table) {
            $table->dropColumn('listing_description');
        });

        Schema::table('digital_catalogs', function (Blueprint $table) {
            $table->dropColumn('listing_description');
        });

        Schema::table('scholarly_journals', function (Blueprint $table) {
            $table->dropColumn('listing_description');
        });

        Schema::table('educator_resources', function (Blueprint $table) {
            $table->dropColumn('listing_description');
        });
    }
}
