<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHeroCaptionToMagazineIssues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('magazine_issues', function (Blueprint $table) {
            $table->text('hero_caption')->nullable()->after('list_description');
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
            $table->dropColumn('hero_caption');
        });
    }
}
