<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

return new class () extends Migration {
    // Relocate artwork sidebar related rows that are now curated in dedicated
    // CMS browsers (`artwork_publications` and `artwork_exhibitions`) and
    // resequence the `position` of every affected browser.

    private const SUBJECT_TYPE = 'App\\Models\\Artwork';

    private const SIDEBAR_BROWSER = 'sidebar_items';

    private const PUBLICATION_BROWSER = 'artwork_publications';

    private const EXHIBITION_BROWSER = 'artwork_exhibitions';

    private const PUBLICATION_TYPES = [
        'digitalPublications',
        'printedPublications',
        'digitalPublicationArticles',
    ];

    private const EXHIBITION_TYPES = [
        'exhibitions',
    ];

    public function up(): void
    {
        $publications = $this->move(self::PUBLICATION_TYPES, self::SIDEBAR_BROWSER, self::PUBLICATION_BROWSER);
        $exhibitions = $this->move(self::EXHIBITION_TYPES, self::SIDEBAR_BROWSER, self::EXHIBITION_BROWSER);

        $this->resequence([
            self::PUBLICATION_BROWSER,
            self::EXHIBITION_BROWSER,
            self::SIDEBAR_BROWSER,
        ]);

        $this->report([
            self::PUBLICATION_BROWSER => $publications,
            self::EXHIBITION_BROWSER => $exhibitions,
        ]);
    }

    public function down(): void
    {
        $publications = $this->move(self::PUBLICATION_TYPES, self::PUBLICATION_BROWSER, self::SIDEBAR_BROWSER);
        $exhibitions = $this->move(self::EXHIBITION_TYPES, self::EXHIBITION_BROWSER, self::SIDEBAR_BROWSER);

        $this->resequence([self::SIDEBAR_BROWSER]);

        $this->report([
            self::SIDEBAR_BROWSER . ' (publications)' => $publications,
            self::SIDEBAR_BROWSER . ' (exhibitions)' => $exhibitions,
        ]);
    }

    /**
     * Move related rows of the given types from one browser into another.
     *
     * Safe to run repeatedly: once moved, no source rows match any more.
     */
    private function move(array $relatedTypes, string $fromBrowser, string $toBrowser): int
    {
        return DB::table('related')
            ->where('subject_type', self::SUBJECT_TYPE)
            ->where('browser_name', $fromBrowser)
            ->whereIn('related_type', $relatedTypes)
            ->update(['browser_name' => $toBrowser]);
    }

    /**
     * Renumber `position` to a gapless 1..N run per
     * (subject_type, subject_id, browser_name), preserving the current order.
     */
    private function resequence(array $browsers): void
    {
        $browserList = implode(', ', array_map(
            fn (string $browser): string => DB::getPdo()->quote($browser),
            $browsers
        ));

        $sql = <<<SQL
            WITH ranked AS (
                SELECT
                    subject_type,
                    subject_id,
                    browser_name,
                    related_type,
                    related_id,
                    ROW_NUMBER() OVER (
                        PARTITION BY subject_type, subject_id, browser_name
                        ORDER BY position, related_type, related_id
                    ) AS new_position
                FROM related
                WHERE browser_name IN ({$browserList})
            )
            UPDATE related AS r
            SET position = ranked.new_position
            FROM ranked
            WHERE r.browser_name = ranked.browser_name
                AND r.subject_type = ranked.subject_type
                AND r.subject_id IS NOT DISTINCT FROM ranked.subject_id
                AND r.related_type = ranked.related_type
                AND r.related_id IS NOT DISTINCT FROM ranked.related_id
                AND r.position IS DISTINCT FROM ranked.new_position
            SQL;

        DB::statement($sql);
    }

    private function report(array $counts): void
    {
        Log::info('Moved artwork sidebar related rows between curation browsers.', $counts);

        foreach ($counts as $browser => $count) {
            echo "{$browser}: {$count} row(s) moved" . PHP_EOL;
        }
    }
};
