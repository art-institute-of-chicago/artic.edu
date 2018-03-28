<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateResearchGuidesTables extends Migration
{
    public function up()
    {
        Schema::create('research_guides', function (Blueprint $table) {
            createDefaultTableFields($table, true, true, true, true);
            // add some fields
            $table->string('title', 200)->nullable();
            $table->text('short_description')->nullable();
        });

        // remove this if you're not going to use any translated field
        // Schema::create('research_guide_translations', function (Blueprint $table) {
        //     createDefaultTranslationsTableFields($table, 'research_guide');
        //     // add some translated fields
        //     // $table->string('title', 200)->nullable();
        //     // $table->text('description')->nullable();
        // });

        // remove this if you're not going to use slugs
        Schema::create('research_guide_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'research_guide');
        });

        // remove this if you're not going to use revisions
        Schema::create('research_guide_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'research_guide');
        });
    }

    public function down()
    {
        Schema::dropIfExists('research_guide_revisions');
        // Schema::dropIfExists('research_guide_translations');
        Schema::dropIfExists('research_guide_slugs');
        Schema::dropIfExists('research_guides');
    }
}
