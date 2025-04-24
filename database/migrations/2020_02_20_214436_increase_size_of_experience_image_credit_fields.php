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
        Schema::table('experience_images', function (Blueprint $table) {
            $table->text('artist')->nullable()->change();
            $table->text('credit_date')->nullable()->change();
            $table->text('dimensions')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('experience_images', function (Blueprint $table) {
            $table->string('artist')->nullable()->change();
            $table->string('credit_date')->nullable()->change();
            $table->string('dimensions')->nullable()->change();
        });
    }
};
