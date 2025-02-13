<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('research_guides', function (Blueprint $table) {
            createDefaultTableFields($table, true, true, true, true);
            $table->string('title', 200)->nullable();
            $table->text('short_description')->nullable();
        });

        Schema::create('research_guide_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'research_guide');
        });

        Schema::create('research_guide_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'research_guide');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('research_guide_revisions');
        Schema::dropIfExists('research_guide_slugs');
        Schema::dropIfExists('research_guides');
    }
};
