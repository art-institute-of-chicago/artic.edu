<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOptionalPlanYourVisitLinkToHomepage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->string('home_plan_your_visit_link_text')->nullable();
            $table->text('home_plan_your_visit_link_url')->nullable();
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
            $table->dropColumn('home_plan_your_visit_link_text');
            $table->dropColumn('home_plan_your_visit_link_url');
        });
    }
}
