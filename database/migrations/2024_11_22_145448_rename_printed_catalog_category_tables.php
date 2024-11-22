<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First drop the foreign key constraints
        Schema::table('catalog_category_printed_catalog', function (Blueprint $table) {
            $table->dropForeign('catalog_category_printed_catalog_catalog_category_id_foreign');
            $table->dropForeign('catalog_category_printed_catalog_printed_catalog_id_foreign');
        });

        // Drop the index
        DB::statement('DROP INDEX IF EXISTS idx_catalog_category_printed_catalog_E0dSH');

        // Rename the sequence
        DB::unprepared('ALTER SEQUENCE catalog_category_printed_catalog_id_seq RENAME TO catalog_category_printed_publication_id_seq');

        // Rename the table
        Schema::rename('catalog_category_printed_catalog', 'catalog_category_printed_publication');

        // Update column name to match new convention
        Schema::table('catalog_category_printed_publication', function (Blueprint $table) {
            $table->renameColumn('printed_catalog_id', 'printed_publication_id');
        });

        // Recreate the index with new name
        DB::statement('CREATE INDEX idx_catalog_category_printed_publication ON catalog_category_printed_publication (printed_publication_id, catalog_category_id)');

        // Add back foreign key constraints with updated references
        Schema::table('catalog_category_printed_publication', function (Blueprint $table) {
            $table->foreign('catalog_category_id')
                ->references('id')
                ->on('catalog_categories')
                ->onDelete('cascade');

            $table->foreign('printed_publication_id')
                ->references('id')
                ->on('printed_publications')
                ->onDelete('cascade');
        });

        // Update the sequence default
        DB::unprepared('ALTER TABLE catalog_category_printed_publication ALTER COLUMN id SET DEFAULT nextval(\'catalog_category_printed_publication_id_seq\')');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign key constraints
        Schema::table('catalog_category_printed_publication', function (Blueprint $table) {
            $table->dropForeign(['catalog_category_id']);
            $table->dropForeign(['printed_publication_id']);
        });

        // Drop the index
        DB::statement('DROP INDEX IF EXISTS idx_catalog_category_printed_publication');

        // Rename the sequence back
        DB::unprepared('ALTER SEQUENCE catalog_category_printed_publication_id_seq RENAME TO catalog_category_printed_catalog_id_seq');

        // Rename column back to original
        Schema::table('catalog_category_printed_publication', function (Blueprint $table) {
            $table->renameColumn('printed_publication_id', 'printed_catalog_id');
        });

        // Rename the table back
        Schema::rename('catalog_category_printed_publication', 'catalog_category_printed_catalog');

        // Recreate the original index
        DB::statement('CREATE INDEX idx_catalog_category_printed_catalog_E0dSH ON catalog_category_printed_catalog (printed_catalog_id, catalog_category_id)');

        // Add back original foreign key constraints
        Schema::table('catalog_category_printed_catalog', function (Blueprint $table) {
            $table->foreign('catalog_category_id')
                ->references('id')
                ->on('catalog_categories')
                ->onDelete('cascade');

            $table->foreign('printed_catalog_id')
                ->references('id')
                ->on('printed_publications')
                ->onDelete('cascade');
        });

        // Update the sequence default
        DB::unprepared('ALTER TABLE catalog_category_printed_catalog ALTER COLUMN id SET DEFAULT nextval(\'catalog_category_printed_catalog_id_seq\')');
    }
};