<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGuidedTourTo3dModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('3d_models', function (Blueprint $table) {
            $table->boolean('guided_tour')->default(false);
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
            $table->dropColumn('guided_tour');
        });
    }
}
