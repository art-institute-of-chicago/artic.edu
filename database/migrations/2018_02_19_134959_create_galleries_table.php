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
        Schema::create('galleries', function (Blueprint $table) {
            createDefaultTableFields($table, true, false);

            $table->text('intro')->nullable();
            $table->integer('datahub_id')->unsigned();
        });

        Schema::create('gallery_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'gallery');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery_slugs');
        Schema::dropIfExists('galleries');
    }
};
