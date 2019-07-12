<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeExperienceImageNameInExperienceModalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('experience_modals', function (Blueprint $table) {
            $table->renameColumn('experience_image', 'has_experience_image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('experience_modals', function (Blueprint $table) {
            $table->renameColumn('has_experience_image', 'experience_image');
        });
    }
}
