<?php

use Illuminate\Database\Migrations\Migration;

class UpdateRelatedMorphMapTypeForExperiences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('related')->where('related_type', 'interactiveFeatures.experiences')->update(['related_type' => 'experiences']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('related')->where('related_type', 'experiences')->update(['related_type' => 'interactiveFeatures.experiences']);
    }
}
