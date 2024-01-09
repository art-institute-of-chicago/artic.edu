<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    /**
     * Run the migration.
     *
     * @return void
     */
    public function up(): void
    {
        DB::statement('DROP TABLE IF EXISTS issues CASCADE');
        DB::statement('DROP TABLE IF EXISTS issue_articles CASCADE');

        Schema::dropIfExists('issue_article_revisions');
        Schema::dropIfExists('issue_article_slugs');
        Schema::dropIfExists('issue_revisions');
        Schema::dropIfExists('issue_slugs');
    }
    public function down(): void
    {
        // no need for reverse migration since all dependant code is deleted [WEB-2533]
    }
};
