<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MoveAttractEndColumnsToSlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('experiences', function (Blueprint $table) {
            $table->dropColumn(['attract_title', 'attract_subhead', 'end_credit_subhead', 'end_credit_copy', 'end_copy', 'end_headline']);
        });

        Schema::table('slides', function (Blueprint $table) {
            $table->string('attract_title')->nullable();
            $table->string('attract_subhead')->nullable();
            $table->string('end_credit_subhead')->nullable();
            $table->string('end_credit_copy')->nullable();
            $table->string('end_copy')->nullable();
            $table->string('end_headline')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('slides', function (Blueprint $table) {
            $table->dropColumn(['attract_title', 'attract_subhead', 'end_credit_subhead', 'end_credit_copy', 'end_copy', 'end_headline']);
        });

        Schema::table('experiences', function (Blueprint $table) {
            $table->string('attract_title')->nullable();
            $table->string('attract_subhead')->nullable();
            $table->string('end_credit_subhead')->nullable();
            $table->string('end_credit_copy')->nullable();
            $table->string('end_copy')->nullable();
            $table->string('end_headline')->nullable();
        });
    }
}
