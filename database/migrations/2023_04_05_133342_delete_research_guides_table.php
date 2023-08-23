<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    public function up(): void
    {
        DB::statement('DROP TABLE IF EXISTS research_guides CASCADE');

        Schema::dropIfExists('research_guide_revisions');
        Schema::dropIfExists('research_guide_slugs');
    }
    public function down(): void
    {
        // no need for reverse migration since all dependant code is deleted [WEB-1282]
    }
};
