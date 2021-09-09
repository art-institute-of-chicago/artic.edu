<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteSegmentsTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('segment_slugs');
        Schema::dropIfExists('segmentables');
        Schema::dropIfExists('segments');
    }

    public function down()
    {
        Schema::create('segmentables', function (Blueprint $table) {
            $table->increments('id');
            $table->string('segmentable_type');
            $table->integer('segmentable_id')->unsigned();
            $table->integer('segment_id')->unsigned();
            $table->index(['segmentable_type', 'segmentable_id']);
        });

        Schema::create('segments', function (Blueprint $table) {
            createDefaultTableFields($table, true, false);
            $table->string('name');
        });

        Schema::create('segment_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'segment');
        });
    }
}
