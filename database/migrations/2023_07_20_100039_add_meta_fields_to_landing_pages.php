<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMetaFieldsToLandingPages extends Migration
{
    public function up()
    {
        Schema::table('landing_pages', function (Blueprint $table) {
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('search_tags')->nullable();
        });
    }

    public function down()
    {
        Schema::table('landing_pages', function (Blueprint $table) {
            $table->dropColumn('meta_title');
            $table->dropColumn('meta_description');
            $table->dropColumn('search_tags');
        });
    }
}
