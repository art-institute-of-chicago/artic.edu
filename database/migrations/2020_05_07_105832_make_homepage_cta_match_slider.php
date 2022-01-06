<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeHomepageCtaMatchSlider extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->renameColumn('home_cta_module_headline', 'home_cta_module_header');
            $table->renameColumn('home_cta_module_short_copy', 'home_cta_module_body');
            $table->renameColumn('home_cta_module_url', 'home_cta_module_action_url');
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->text('home_cta_module_header')->nullable()->change();
            $table->text('home_cta_module_body')->nullable()->change();
            $table->text('home_cta_module_action_url')->nullable()->change();
            $table->integer('home_cta_module_variation')->default(1);
            $table->text('home_cta_module_form_id')->nullable();
            $table->text('home_cta_module_form_token')->nullable();
            $table->text('home_cta_module_form_tlc_source')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->renameColumn('home_cta_module_header', 'home_cta_module_headline');
            $table->renameColumn('home_cta_module_body', 'home_cta_module_short_copy');
            $table->renameColumn('home_cta_module_action_url', 'home_cta_module_url');
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->string('home_cta_module_headling')->nullable()->change();
            $table->string('home_cta_module_short_copy')->nullable()->change();
            $table->string('home_cta_module_url')->nullable()->change();
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('home_cta_module_variation');
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('home_cta_module_form_id');
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('home_cta_module_form_token');
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('home_cta_module_form_tlc_source');
        });
    }
}
