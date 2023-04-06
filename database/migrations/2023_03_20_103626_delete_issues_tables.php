<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class DeleteIssuesTables extends Migration
{
    /**
     * Run the migration.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('DROP TABLE IF EXISTS issues CASCADE');
        DB::statement('DROP TABLE IF EXISTS issue_articles CASCADE');

        Schema::dropIfExists('issue_article_revisions');
        Schema::dropIfExists('issue_article_slugs');
        Schema::dropIfExists('issue_revisions');
        Schema::dropIfExists('issue_slugs');
    }
    public function down()
    {
        // no need for reverse migration since all dependant code is deleted [WEB-2533]
    }
}
