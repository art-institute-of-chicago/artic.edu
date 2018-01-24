<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToEventsTableCmsMod extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('datahub_id');
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
            $table->dropColumn('price');
            $table->integer('type')->index()->default(0);
            $table->string('short_description')->nullable();
            $table->string('hero_caption')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_private')->default(false);
            $table->boolean('is_ticketed')->default(false);
            $table->boolean('is_after_hours')->default(false);
            $table->boolean('is_free')->default(false);
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('datahub_id');
            $table->dropColumn('type');
            $table->dropColumn('short_description');
            $table->dropColumn('description');
            $table->dropColumn('hero_caption');
            $table->dropColumn('is_private');
            $table->dropColumn('is_ticketed');
            $table->dropColumn('is_after_hours');
            $table->dropColumn('is_free');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('price')->nullable();
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
        });
    }
}
