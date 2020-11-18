<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVisitButtonFieldsToHomePage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->text('home_visit_button_text')->nullable()->after('visit_dining_link');
            $table->text('home_visit_button_url')->nullable()->after('home_visit_button_text');
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
            $table->dropColumn([
                'home_visit_button_text',
                'home_visit_button_url',
            ]);
        });
    }
}
