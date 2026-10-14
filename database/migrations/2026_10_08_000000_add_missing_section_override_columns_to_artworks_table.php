<?php

/**
 * The section heading overrides were introduced by
 * 2026_10_06_100000_add_section_overrides_to_artworks_table, but some
 * databases recorded that migration as run while the columns are missing
 * (e.g. after restoring a database dump). Saving an artwork then fails with
 * "column override_publications_title does not exist".
 *
 * This re-adds whichever of those columns are absent, so it is safe to run on
 * a database that already has them.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Section keys that still have heading overrides in the CMS.
     */
    private const SECTIONS = [
        'related_content',
        'publications',
        'exhibitions',
        'educator_resources',
        'videos',
        'view_360',
        'view_3d',
    ];

    public function up(): void
    {
        foreach (self::SECTIONS as $section) {
            $this->addStringColumn("{$section}_title");
            $this->addTextColumn("{$section}_description");
            $this->addBooleanColumn("override_{$section}_title");
        }
    }

    /**
     * Destructive only for the columns this migration added, which the original
     * migration's down() also drops.
     */
    public function down(): void
    {
        foreach (self::SECTIONS as $section) {
            foreach (["{$section}_title", "{$section}_description", "override_{$section}_title"] as $column) {
                if (Schema::hasColumn('artworks', $column)) {
                    Schema::table('artworks', function (Blueprint $table) use ($column) {
                        $table->dropColumn($column);
                    });
                }
            }
        }
    }

    private function addStringColumn(string $column): void
    {
        if (Schema::hasColumn('artworks', $column)) {
            return;
        }

        Schema::table('artworks', function (Blueprint $table) use ($column) {
            $table->string($column)->nullable();
        });
    }

    private function addTextColumn(string $column): void
    {
        if (Schema::hasColumn('artworks', $column)) {
            return;
        }

        Schema::table('artworks', function (Blueprint $table) use ($column) {
            $table->text($column)->nullable();
        });
    }

    private function addBooleanColumn(string $column): void
    {
        if (Schema::hasColumn('artworks', $column)) {
            return;
        }

        Schema::table('artworks', function (Blueprint $table) use ($column) {
            $table->boolean($column)->default(false);
        });
    }
};
