<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToDigitalLabelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('digital_labels', function (Blueprint $table) {
            $table->boolean('archived')->default(false);
            $table->string('grouping_background_color')->nullable();
            $table->string('color')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('digital_labels', function (Blueprint $table) {
            $table->dropColumn(['archived', 'grouping_background_color', 'color']);
        });
    }
}
