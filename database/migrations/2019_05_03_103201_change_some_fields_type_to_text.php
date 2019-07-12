<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeSomeFieldsTypeToText extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slides', function (Blueprint $table) {
            $table->text('caption')->change();
            $table->text('body_copy')->change();
            $table->text('split_primary_copy')->change();
            $table->text('seamless_alt_text')->change();
        });

        Schema::table('experience_images', function (Blueprint $table) {
            $table->text('alt_text')->change();
            $table->text('credit_title')->change();
            $table->text('medium')->change();
            $table->text('credit_line')->change();
            $table->text('copyright_notice')->change();
        });

        Schema::table('experience_modals', function (Blueprint $table) {
            $table->text('image_sequence_caption')->change();
            $table->text('alt_text')->change();
            $table->text('medium')->change();
            $table->text('credit_line')->change();
            $table->text('copyright_notice')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
