<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTranslationToVisitPageCitypassLink extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('page_translations', function (Blueprint $table) {
            $table->string('visit_city_pass_link')->nullable();
        });

        DB::update('update page_translations pt set visit_city_pass_link = (select visit_city_pass_link from pages p where p.id=pt.page_id)');

        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('visit_city_pass_link');
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
            $table->string('visit_city_pass_link')->nullable();
        });

        DB::update('update pages p set visit_city_pass_link = (select visit_city_pass_link from page_translations pt where p.id=pt.page_id)');

        Schema::table('page_translations', function (Blueprint $table) {
            $table->dropColumn('visit_city_pass_link');
        });
    }
}
