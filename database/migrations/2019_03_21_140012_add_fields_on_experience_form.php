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
            if (!Schema::hasColumn('experiences', 'archived')) {
                $table->boolean('archived')->default(false);
            }

            if (!Schema::hasColumn('experiences', 'attract_title')) {
                $table->string('attract_title')->nullable();
            }

            if (!Schema::hasColumn('experiences', 'attract_subhead')) {
                $table->string('attract_subhead')->nullable();
            }

            if (!Schema::hasColumn('experiences', 'media_title')) {
                $table->string('media_title')->nullable();
            }

            if (!Schema::hasColumn('experiences', 'end_credit_subhead')) {
                $table->string('end_credit_subhead')->nullable();
            }

            if (!Schema::hasColumn('experiences', 'end_credit_copy')) {
                $table->string('end_credit_copy')->nullable();
            }
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
