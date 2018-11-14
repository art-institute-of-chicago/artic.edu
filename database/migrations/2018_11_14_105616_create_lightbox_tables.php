<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLightboxTables extends Migration
{
    public function up()
    {
        Schema::create('lightbox', function (Blueprint $table) {
            createDefaultTableFields($table);
            // add some fields
            // $table->string('title', 200)->nullable();
            // $table->text('description')->nullable();
            // use those 2 for publication timeframe
            // $table->timestamp('publish_start_date')->nullable();
            // $table->timestamp('publish_end_date')->nullable();
            // use this one for public/private publication (private doesn't show in listing when using the appropriate scopes)
            // $table->boolean('public')->default(true);
            // use this one with the HasPosition trait
            // $table->integer('position')->unsigned()->nullable();
        });

        // remove this if you're not going to use any translated field
        Schema::create('lightbox_translations', function (Blueprint $table) {
            createDefaultTranslationsTableFields($table, 'lightbox');
            // add some translated fields
            // $table->string('title', 200)->nullable();
            // $table->text('description')->nullable();
        });

        // remove this if you're not going to use slugs
        Schema::create('lightbox_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'lightbox');
        });

        // remove this if you're not going to use revisions
        Schema::create('lightbox_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'lightbox');
        });
    }

    public function down()
    {
        Schema::dropIfExists('lightbox_revisions');
        Schema::dropIfExists('lightbox_translations');
        Schema::dropIfExists('lightbox_slugs');
        Schema::dropIfExists('lightbox');
    }
}
