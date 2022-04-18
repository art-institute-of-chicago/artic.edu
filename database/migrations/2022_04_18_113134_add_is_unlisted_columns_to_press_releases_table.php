<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsUnlistedColumnsToPressReleasesTable extends Migration
{
    public function up()
    {
        Schema::table('press_releases', function (Blueprint $table) {
            $table->boolean('is_unlisted')->default(false);
        });
    }

    public function down()
    {
        Schema::table('press_releases', function (Blueprint $table) {
            $table->dropColumn('is_unlisted');
        });
    }
}
