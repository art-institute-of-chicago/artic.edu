<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePressReleasesTables extends Migration
{
    public function up()
    {
        Schema::create('press_releases', function (Blueprint $table) {
            createDefaultTableFields($table, true, true, true, true);
            $table->string('title', 200)->nullable();
            $table->text('short_description')->nullable();
        });

        Schema::create('press_release_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'press_release');
        });

        Schema::create('press_release_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'press_release');
        });
    }

    public function down()
    {
        Schema::dropIfExists('press_release_revisions');
        Schema::dropIfExists('press_release_slugs');
        Schema::dropIfExists('press_releases');
    }
}
