<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsOnExperienceForm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('experiences', function (Blueprint $table) {
            $table->boolean('archived')->default(false);
            $table->string('attract_title')->nullable();
            $table->string('attract_subhead')->nullable();
            $table->string('media_title')->nullable();
            $table->string('end_credit_subhead')->nullable();
            $table->string('end_credit_copy')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('experiences', function (Blueprint $table) {
            $table->dropColumn(['archived', 'attract_title', 'attract_subhead', 'media_title', 'end_credit_subhead', 'end_credit_copy']);
        });
    }
}
