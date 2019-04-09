<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExperienceImageFieldsToExperienceModalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('experience_modals', function (Blueprint $table) {
            $table->boolean('experience_image')->default(false);
            $table->string('title')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('alt_text')->nullable();
            $table->string('inline_credits')->default('off');
            $table->string('credits_input')->default('datahub');
            $table->string('object_id')->nullable();
            $table->string('artist')->nullable();
            $table->string('credit_title')->nullable();
            $table->string('credit_date')->nullable();
            $table->string('medium')->nullable();
            $table->string('dimensions')->nullable();
            $table->string('credit_line')->nullable();
            $table->string('main_reference_number')->nullable();
            $table->string('copyright_notice')->nullable();
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
            $table->dropColumn(['experience_image', 'title', 'youtube_url', 'alt_text',
                'inline_credits', 'credits_input', 'object_id',
                'artist', 'credit_title', 'credit_date',
                'medium', 'dimensions', 'credit_line',
                'main_reference_number', 'copyright_notice']);
        });
    }
}
