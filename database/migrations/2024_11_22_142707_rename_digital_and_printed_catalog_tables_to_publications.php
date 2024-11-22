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
        // Instead of trying to drop specific constraints, we'll query the system tables
        // to find and drop the existing constraints
        $this->dropSequenceConstraints();

        // Rename digital sequences
        DB::unprepared('ALTER SEQUENCE digital_catalog_page_id_seq RENAME TO digital_publication_page_id_seq');
        DB::unprepared('ALTER SEQUENCE digital_catalog_revisions_id_seq RENAME TO digital_publication_revisions_id_seq');
        DB::unprepared('ALTER SEQUENCE digital_catalog_slugs_id_seq RENAME TO digital_publication_slugs_id_seq');
        DB::unprepared('ALTER SEQUENCE digital_catalogs_id_seq RENAME TO digital_publications_id_seq');

        // Rename printed sequences
        DB::unprepared('ALTER SEQUENCE printed_catalog_revisions_id_seq RENAME TO printed_publication_revisions_id_seq');
        DB::unprepared('ALTER SEQUENCE printed_catalog_slugs_id_seq RENAME TO printed_publication_slugs_id_seq');
        DB::unprepared('ALTER SEQUENCE printed_catalogs_id_seq RENAME TO printed_publications_id_seq');

        // Update sequence defaults
        DB::unprepared('ALTER TABLE digital_publication_page ALTER COLUMN id SET DEFAULT nextval(\'digital_publication_page_id_seq\')');
        DB::unprepared('ALTER TABLE digital_publication_revisions ALTER COLUMN id SET DEFAULT nextval(\'digital_publication_revisions_id_seq\')');
        DB::unprepared('ALTER TABLE digital_publication_slugs ALTER COLUMN id SET DEFAULT nextval(\'digital_publication_slugs_id_seq\')');
        DB::unprepared('ALTER TABLE digital_publications ALTER COLUMN id SET DEFAULT nextval(\'digital_publications_id_seq\')');

        DB::unprepared('ALTER TABLE printed_publication_revisions ALTER COLUMN id SET DEFAULT nextval(\'printed_publication_revisions_id_seq\')');
        DB::unprepared('ALTER TABLE printed_publication_slugs ALTER COLUMN id SET DEFAULT nextval(\'printed_publication_slugs_id_seq\')');
        DB::unprepared('ALTER TABLE printed_publications ALTER COLUMN id SET DEFAULT nextval(\'printed_publications_id_seq\')');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop existing sequence defaults
        $this->dropSequenceConstraints();

        // Rename digital sequences back
        DB::unprepared('ALTER SEQUENCE digital_publication_page_id_seq RENAME TO digital_catalog_page_id_seq');
        DB::unprepared('ALTER SEQUENCE digital_publication_revisions_id_seq RENAME TO digital_catalog_revisions_id_seq');
        DB::unprepared('ALTER SEQUENCE digital_publication_slugs_id_seq RENAME TO digital_catalog_slugs_id_seq');
        DB::unprepared('ALTER SEQUENCE digital_publications_id_seq RENAME TO digital_catalogs_id_seq');

        // Rename printed sequences back
        DB::unprepared('ALTER SEQUENCE printed_publication_revisions_id_seq RENAME TO printed_catalog_revisions_id_seq');
        DB::unprepared('ALTER SEQUENCE printed_publication_slugs_id_seq RENAME TO printed_catalog_slugs_id_seq');
        DB::unprepared('ALTER SEQUENCE printed_publications_id_seq RENAME TO printed_catalogs_id_seq');

        // Update sequence defaults
        DB::unprepared('ALTER TABLE digital_publication_page ALTER COLUMN id SET DEFAULT nextval(\'digital_catalog_page_id_seq\')');
        DB::unprepared('ALTER TABLE digital_publication_revisions ALTER COLUMN id SET DEFAULT nextval(\'digital_catalog_revisions_id_seq\')');
        DB::unprepared('ALTER TABLE digital_publication_slugs ALTER COLUMN id SET DEFAULT nextval(\'digital_catalog_slugs_id_seq\')');
        DB::unprepared('ALTER TABLE digital_publications ALTER COLUMN id SET DEFAULT nextval(\'digital_catalogs_id_seq\')');

        DB::unprepared('ALTER TABLE printed_publication_revisions ALTER COLUMN id SET DEFAULT nextval(\'printed_catalog_revisions_id_seq\')');
        DB::unprepared('ALTER TABLE printed_publication_slugs ALTER COLUMN id SET DEFAULT nextval(\'printed_catalog_slugs_id_seq\')');
        DB::unprepared('ALTER TABLE printed_publications ALTER COLUMN id SET DEFAULT nextval(\'printed_catalogs_id_seq\')');
    }

    /**
     * Drop sequence constraints for all relevant tables
     */
    private function dropSequenceConstraints(): void
    {
        $tables = [
            'digital_publication_page',
            'digital_publication_revisions',
            'digital_publication_slugs',
            'digital_publications',
            'printed_publication_revisions',
            'printed_publication_slugs',
            'printed_publications'
        ];

        foreach ($tables as $table) {
            // Get all constraints for the id column of the table
            $constraints = DB::select("
                SELECT con.conname as constraint_name
                FROM pg_constraint con
                INNER JOIN pg_class rel ON rel.oid = con.conrelid
                INNER JOIN pg_namespace nsp ON nsp.oid = rel.relnamespace
                WHERE rel.relname = ?
                AND con.conname LIKE '%id%'
            ", [$table]);

            // Drop each constraint found
            foreach ($constraints as $constraint) {
                DB::statement("ALTER TABLE {$table} DROP CONSTRAINT IF EXISTS {$constraint->constraint_name}");
            }

            // Also drop the default constraint if it exists
            DB::statement("ALTER TABLE {$table} ALTER COLUMN id DROP DEFAULT");
        }
    }
};