<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Models\Page;

class MakePlanYourVisitLinksEditable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->string('home_plan_your_visit_link_1_text')->nullable();
            $table->text('home_plan_your_visit_link_1_url')->nullable();
            $table->string('home_plan_your_visit_link_2_text')->nullable();
            $table->text('home_plan_your_visit_link_2_url')->nullable();
            $table->string('home_plan_your_visit_link_3_text')->nullable();
            $table->text('home_plan_your_visit_link_3_url')->nullable();
            $table->dropColumn('home_plan_your_visit_link_text');
            $table->dropColumn('home_plan_your_visit_link_url');
        });

        $page = Page::forType('Home')->first();
        $page->home_plan_your_visit_link_1_text = 'Hours and admission fees';
        $page->home_plan_your_visit_link_1_url = '/visit#hours';
        $page->home_plan_your_visit_link_2_text = 'Directions and parking';
        $page->home_plan_your_visit_link_2_url = '/visit#directions';
        $page->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->string('home_plan_your_visit_link_text')->nullable();
            $table->text('home_plan_your_visit_link_url')->nullable();
            $table->dropColumn('home_plan_your_visit_link_1_text');
            $table->dropColumn('home_plan_your_visit_link_1_url');
            $table->dropColumn('home_plan_your_visit_link_2_text');
            $table->dropColumn('home_plan_your_visit_link_2_url');
            $table->dropColumn('home_plan_your_visit_link_3_text');
            $table->dropColumn('home_plan_your_visit_link_3_url');
        });
    }
}
