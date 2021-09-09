<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveSponsorsSubCopy extends Migration
{
    public function up()
    {
        Schema::table('exhibitions', function (Blueprint $table) {
            $table->dropColumn('sponsors_sub_copy');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('sponsors_sub_copy');
        });
    }

    public function down()
    {
        Schema::table('exhibitions', function (Blueprint $table) {
            $table->text('sponsors_sub_copy')->nullable();
        });

        Schema::table('events', function (Blueprint $table) {
            $table->text('sponsors_sub_copy')->nullable();
        });
    }
}
