<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('slides', function (Blueprint $table) {
            $table->text('caption')->nullable()->change();
            $table->text('body_copy')->nullable()->change();
            $table->text('split_primary_copy')->nullable()->change();
            $table->text('seamless_alt_text')->nullable()->change();
        });

        Schema::table('experience_images', function (Blueprint $table) {
            $table->text('alt_text')->nullable()->change();
            $table->text('credit_title')->nullable()->change();
            $table->text('medium')->nullable()->change();
            $table->text('credit_line')->nullable()->change();
            $table->text('copyright_notice')->nullable()->change();
        });

        Schema::table('experience_modals', function (Blueprint $table) {
            $table->text('image_sequence_caption')->nullable()->change();
            $table->text('alt_text')->nullable()->change();
            $table->text('medium')->nullable()->change();
            $table->text('credit_line')->nullable()->change();
            $table->text('copyright_notice')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
    }
};
