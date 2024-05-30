<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    public function up(): void
    {
        // Drop existing foreign key constraints

        Schema::table('digital_publication_sections', function (Blueprint $table) {
            $table->dropForeign('digital_publication_sections_digital_publication_id_foreign');
        });

        Schema::table('digital_publication_section_revisions', function (Blueprint $table) {
            $table->dropForeign('digital_publication_section_revisions_digital_publication_secti');
        });

        Schema::table('digital_publication_section_slugs', function (Blueprint $table) {
            $table->dropForeign('fk_digital_publication_section_slugs_digital_publication_sectio');
        });

        // Rename the sections table to articles
        Schema::rename('digital_publication_sections', 'digital_publication_articles');
        Schema::rename('digital_publication_section_revisions', 'digital_publication_article_revisions');
        Schema::rename('digital_publication_section_slugs', 'digital_publication_article_slugs');

        DB::statement('ALTER SEQUENCE digital_publication_sections_id_seq RENAME TO digital_publication_articles_id_seq');
        DB::statement('ALTER SEQUENCE digital_publication_section_revisions_id_seq RENAME TO digital_publication_article_revisions_id_seq');
        DB::statement('ALTER SEQUENCE digital_publication_section_slugs_id_seq RENAME TO digital_publication_article_slugs_id_seq');

        // Drop foreign key constraints and re-attach them to the new table names


        Schema::table('digital_publication_articles', function (Blueprint $table) {
            $table->foreign('digital_publication_id')->references('id')->on('digital_publications')->onDelete('cascade');
        });

        Schema::table('digital_publication_article_revisions', function (Blueprint $table) {
            $table->renameColumn('digital_publication_section_id', 'digital_publication_article_id');
            $table->foreign('digital_publication_article_id')->references('id')->on('digital_publication_articles')->onDelete('cascade');
        });

        Schema::table('digital_publication_article_slugs', function (Blueprint $table) {
            $table->renameColumn('digital_publication_section_id', 'digital_publication_article_id');
            $table->foreign('digital_publication_article_id')->references('id')->on('digital_publication_articles')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        // Drop the foreign key constraints before renaming the tables back
        Schema::table('digital_publication_article_revisions', function (Blueprint $table) {
            $table->dropForeign('digital_publication_article_revisions_digital_publication_article_id_foreign');
            $table->renameColumn('digital_publication_article_id', 'digital_publication_section_id');
        });

        Schema::table('digital_publication_article_slugs', function (Blueprint $table) {
            $table->dropForeign('digital_publication_article_slugs_digital_publication_article_id_foreign');
            $table->renameColumn('digital_publication_article_id', 'digital_publication_section_id');
        });

        Schema::table('digital_publication_articles', function (Blueprint $table) {
            $table->dropForeign('digital_publication_articles_digital_publication_id_foreign');
        });

        // Rename the tables back
        Schema::rename('digital_publication_article_revisions', 'digital_publication_section_revisions');
        Schema::rename('digital_publication_article_slugs', 'digital_publication_section_slugs');
        Schema::rename('digital_publication_articles', 'digital_publication_sections');

        // Rename the sequences back
        DB::statement('ALTER SEQUENCE digital_publication_article_revisions_id_seq RENAME TO digital_publication_section_revisions_id_seq');
        DB::statement('ALTER SEQUENCE digital_publication_article_slugs_id_seq RENAME TO digital_publication_section_slugs_id_seq');
        DB::statement('ALTER SEQUENCE digital_publication_articles_id_seq RENAME TO digital_publication_sections_id_seq');

        // Re-attach the foreign keys to the original table names
        Schema::table('digital_publication_section_revisions', function (Blueprint $table) {
            $table->foreign('digital_publication_section_id')->references('id')->on('digital_publication_sections')->onDelete('cascade');
        });

        Schema::table('digital_publication_section_slugs', function (Blueprint $table) {
            $table->foreign('digital_publication_section_id')->references('id')->on('digital_publication_sections')->onDelete('cascade');
        });

        Schema::table('digital_publication_sections', function (Blueprint $table) {
            $table->foreign('digital_publication_id')->references('id')->on('digital_publications')->onDelete('cascade');
        });
    }
};
