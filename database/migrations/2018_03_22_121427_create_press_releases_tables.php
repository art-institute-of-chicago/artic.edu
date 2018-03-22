<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePressReleasesTables extends Migration
{
    public function up()
    {
        Schema::create('press_releases', function (Blueprint $table) {
            createDefaultTableFields($table, true, true, true, true);
            // add some fields
            $table->string('title', 200)->nullable();
            $table->text('short_description')->nullable();
        });

        // remove this if you're not going to use any translated field
        // Schema::create('press_release_translations', function (Blueprint $table) {
        //     createDefaultTranslationsTableFields($table, 'press_release');
        //     // add some translated fields
        //     // $table->string('title', 200)->nullable();
        //     // $table->text('description')->nullable();
        // });

        // remove this if you're not going to use slugs
        Schema::create('press_release_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'press_release');
        });

        // remove this if you're not going to use revisions
        Schema::create('press_release_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'press_release');
        });
    }

    public function down()
    {
        Schema::dropIfExists('press_release_revisions');
        // Schema::dropIfExists('press_release_translations');
        Schema::dropIfExists('press_release_slugs');
        Schema::dropIfExists('press_releases');
    }
}
