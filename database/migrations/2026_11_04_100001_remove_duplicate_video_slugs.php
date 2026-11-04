<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    /**
     * The YouTube import saved every video on every run, and Twill inserts a
     * new slug row for videos whose title is shared with another video,
     * leaving millions of identical rows. Keep one row per video, slug, and
     * locale, preferring an undeleted and active one, then the oldest.
     */
    public function up(): void
    {
        DB::statement(<<<'SQL'
            DELETE FROM video_slugs
            WHERE id IN (
                SELECT id FROM (
                    SELECT id, row_number() OVER (
                        PARTITION BY video_id, locale, slug
                        ORDER BY deleted_at IS NULL DESC, active DESC, id
                    ) AS rank
                    FROM video_slugs
                ) AS ranked
                WHERE rank > 1
            )
            SQL);
    }

    public function down(): void
    {
        // Deleted duplicates are not restorable
    }
};
