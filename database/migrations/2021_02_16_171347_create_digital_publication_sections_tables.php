<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDigitalPublicationSectionsTables extends Migration
{
    public function up()
    {
        Schema::create('digital_publication_sections', function (Blueprint $table) {
            createDefaultTableFields($table);

            $table->text('title')->nullable();
            $table->text('title_display')->nullable();
            $table->text('short_title_display')->nullable();
            $table->text('list_description')->nullable();
            $table->dateTime('date')->nullable();
            $table->string('type')->nullable();
            $table->text('author_display')->nullable();
            $table->timestamp('publish_start_date')->nullable();
            $table->string('pdf_download_path')->nullable();
            $table->text('cite_as')->nullable();
            $table->integer('digital_publication_id')->unsigned()->nullable();
            $table->foreign('digital_publication_id')->references('id')->on('digital_publications')->onDelete('cascade');

            $table->integer('position')->unsigned()->nullable();
        });

        Schema::create('digital_publication_section_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'digital_publication_section');
        });

        Schema::create('digital_publication_section_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'digital_publication_section');
        });
    }

    public function down()
    {
        Schema::dropIfExists('digital_publication_section_revisions');
        Schema::dropIfExists('digital_publication_section_slugs');
        Schema::dropIfExists('digital_publication_sections');
    }
}
