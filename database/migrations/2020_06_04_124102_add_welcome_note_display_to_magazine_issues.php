<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWelcomeNoteDisplayToMagazineIssues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('magazine_issues', function (Blueprint $table) {
            $table->text('welcome_note_display')->nullable()->after('hero_caption');
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
            $table->dropColumn('welcome_note_display');
        });
    }
}
