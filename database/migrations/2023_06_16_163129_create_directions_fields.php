<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectionsFields extends Migration
{
    public function up()
    {
        Schema::table('landing_pages', function (Blueprint $table) {
            $table->string('visit_parking_label')->nullable();
            $table->string('visit_faqs_label')->nullable();
            $table->string('visit_faqs_link')->nullable();
            $table->dropUnique('landing_pages_type_unique');
        });
        Schema::table('menu_items', function(Blueprint $table) {
            $table->string('label')->nullable()->change();
            $table->string('link')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::dropIfExists('visit_parking_label');
        Schema::dropIfExists('visit_faqs_label');
        Schema::dropIfExists('visit_faqs_link');
    }
}
