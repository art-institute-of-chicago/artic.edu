<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVisitParkingAccessibilityLinkToPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->string('visit_parking_accessibility_link')->nullable();
        });

        $visitPage = \App\Models\Page::where('type', 3)->first();

        $visitPage->visit_parking_accessibility_link = '/visit/accessibility/visitors-with-mobility-needs';
        $visitPage->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('visit_parking_accessibility_link');
        });
    }
}
