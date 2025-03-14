<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create pivot table between catalog_categories and digital_publications
        Schema::create('catalog_category_digital_publication', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('catalog_category_id');
            $table->unsignedBigInteger('digital_publication_id');
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->foreign('catalog_category_id')
                ->references('id')
                ->on('catalog_categories')
                ->onDelete('cascade');

            $table->foreign('digital_publication_id')
                ->references('id')
                ->on('digital_publications')
                ->onDelete('cascade');

            $table->index(['digital_publication_id', 'catalog_category_id'], 'idx_catalog_category_digital_publication');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalog_category_digital_publication');
    }
};
