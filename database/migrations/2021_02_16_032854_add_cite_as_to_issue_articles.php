<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCiteAsToIssueArticles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('issue_articles', function (Blueprint $table) {
            $table->text('cite_as')->nullable()->after('author_display');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('issue_articles', function (Blueprint $table) {
            $table->dropColumn('cite_as');
        });
    }
}
