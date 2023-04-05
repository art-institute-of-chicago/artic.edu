<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocalTitleAndLocalSubtypeToCategoryTerms extends Migration
{
    public function up()
    {
        Schema::table('category_terms', function (Blueprint $table) {
            $table->string('local_title', 150)->nullable();
            $table->string('local_subtype', 150)->nullable();
        });
    }

    public function down()
    {
        Schema::table('category_terms', function (Blueprint $table) {
            $table->dropColumn(['local_title', 'local_subtype']);
        });
    }
}
