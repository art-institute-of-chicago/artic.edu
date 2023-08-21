<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('experience_images', function (Blueprint $table) {
            $table->text('artist')->change();
            $table->text('credit_date')->change();
            $table->text('dimensions')->change();
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
            $table->string('artist')->change();
            $table->string('credit_date')->change();
            $table->string('dimensions')->change();
        });
    }
};
