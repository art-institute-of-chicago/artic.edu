<?php

use Illuminate\Database\Migrations\Migration;

class UpdateMorphMapTypeForExperiences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('mediables')->where('mediable_type', 'interactiveFeatures.experiences')->update(['mediable_type' => 'experiences']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('mediables')->where('mediable_type', 'experiences')->update(['mediable_type' => 'interactiveFeatures.experiences']);
    }
}
