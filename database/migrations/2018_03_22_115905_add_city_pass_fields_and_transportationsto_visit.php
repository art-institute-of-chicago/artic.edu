<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCityPassFieldsAndTransportationstoVisit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->string('visit_city_pass_title')->nullable();
            $table->text('visit_city_pass_text')->nullable();
            $table->string('visit_city_pass_button_label')->nullable();
            $table->string('visit_city_pass_link')->nullable();
            $table->string('visit_transportation_link')->nullable();
            $table->string('visit_parking_link')->nullable();
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
            $table->dropColumn('visit_city_pass_title');
            $table->dropColumn('visit_city_pass_text');
            $table->dropColumn('visit_city_pass_button_label');
            $table->dropColumn('visit_city_pass_link');
            $table->dropColumn('visit_transportation_link');
            $table->dropColumn('visit_parking_link');
        });
    }
}
