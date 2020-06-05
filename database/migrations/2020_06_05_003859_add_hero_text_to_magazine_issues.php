<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHeroTextToMagazineIssues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('magazine_issues', function (Blueprint $table) {
            $table->text('hero_text')->nullable()->after('hero_caption');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('magazine_issues', function (Blueprint $table) {
            $table->dropColumn('hero_text');
        });
    }
}
