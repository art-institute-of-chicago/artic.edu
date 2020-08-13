<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHideAnnotationTitleTo3dModels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('3d_models', function (Blueprint $table) {
            $table->boolean('hide_annotation_title')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('3d_models', function (Blueprint $table) {
            $table->dropColumn('hide_annotation_title');
        });
    }
}
