<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDigitalLabelsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('digital_labels', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->string('datahub_id');
            $table->string('title');
        });

        Schema::create('digital_label_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'digital_label');
        });

        Schema::create('digital_label_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'digital_label');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('digital_label_revisions');
        Schema::dropIfExists('digital_label_slugs');
        Schema::dropIfExists('digital_labels');
    }
}
