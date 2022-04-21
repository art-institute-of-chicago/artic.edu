<?php

use Illuminate\Database\Migrations\Migration;

class UpdateMemberVisitHours extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (env('APP_ENV') != 'testing') {
            $visitPage = \App\Models\Page::where('type', 3)->first();
            $visitPage->visit_hour_subheader = '<p>Monday 10&ndash;11 a.m.<br/>Thursday&ndash;Sunday 10-11 a.m.</p>';
            $visitPage->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (env('APP_ENV') != 'testing') {
            $visitPage = \App\Models\Page::where('type', 3)->first();
            $visitPage->visit_hour_subheader = '<p>Monday 10&ndash;11 a.m.<br/>Thursday&ndash;Friday 12-1 p.m.<br/>Saturday&ndash;Sunday 10&ndash;11 a.m.</p>';
            $visitPage->save();
        }
    }
}
