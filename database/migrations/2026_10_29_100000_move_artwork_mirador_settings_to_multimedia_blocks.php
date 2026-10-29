<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class () extends Migration {
    // Mirador used to be configured directly on the artwork (`default_manifest_url`,
    // `upload_manifest_file`, `default_view`). It now lives in the artwork's
    // Multimedia section as a `multimedia_item` block, so this migration creates a
    // Mirador record per configured artwork, links it to a new block, and then
    // drops the obsolete artwork columns.

    private const ARTWORK_TYPE = 'App\\Models\\Artwork';

    private const MIRADOR_TYPE = 'App\\Models\\Mirador';

    private const SUBJECT_TYPE = 'blocks';

    private const BROWSER = 'multimedia_item';

    private const MANIFEST_ROLE = 'upload_manifest_file';

    private const TITLE_PREFIX = 'Artwork Mirador ';

    public function up(): void
    {
        $artworks = $this->artworksWithMirador();

        foreach ($artworks as $artwork) {
            $this->moveToMultimediaBlock($artwork);
        }

        Schema::table('artworks', function (Blueprint $table) {
            $table->dropColumn(['default_manifest_url', 'default_view']);
        });
    }

    public function down(): void
    {
        Schema::table('artworks', function (Blueprint $table) {
            $table->boolean('default_manifest_url')->default(false);
            $table->string('default_view')->default('single');
        });

        $miradorIds = DB::table('miradors')
            ->where('title', 'like', self::TITLE_PREFIX . '%')
            ->pluck('id');

        if ($miradorIds->isEmpty()) {
            return;
        }

        $blockIds = DB::table('related')
            ->where('related_type', self::MIRADOR_TYPE)
            ->whereIn('related_id', $miradorIds)
            ->where('browser_name', self::BROWSER)
            ->pluck('subject_id');

        DB::table('related')
            ->where('related_type', self::MIRADOR_TYPE)
            ->whereIn('related_id', $miradorIds)
            ->delete();

        DB::table('blocks')->whereIn('id', $blockIds)->delete();
        DB::table('fileables')
            ->where('fileable_type', self::MIRADOR_TYPE)
            ->whereIn('fileable_id', $miradorIds)
            ->delete();
        DB::table('mirador_slugs')->whereIn('mirador_id', $miradorIds)->delete();
        DB::table('miradors')->whereIn('id', $miradorIds)->delete();
    }

    /**
     * Artworks that still have Mirador data in the old form fields.
     */
    private function artworksWithMirador()
    {
        return DB::table('artworks as a')
            ->select('a.id', 'a.datahub_id', 'a.default_manifest_url', 'a.default_view', 'f.file_id')
            ->leftJoin('fileables as f', function ($join) {
                $join->on('f.fileable_id', '=', 'a.id')
                    ->where('f.fileable_type', '=', self::ARTWORK_TYPE)
                    ->where('f.role', '=', self::MANIFEST_ROLE);
            })
            ->whereNull('a.deleted_at')
            ->where(function ($query) {
                $query->where('a.default_manifest_url', true)
                    ->orWhereNotNull('f.file_id');
            })
            ->orderBy('a.id')
            ->get();
    }

    /**
     * Create the Mirador record + Multimedia block for one artwork.
     */
    private function moveToMultimediaBlock(object $artwork): void
    {
        if ($this->hasMiradorBlock($artwork->id)) {
            return;
        }

        $miradorId = $this->createMirador($artwork);

        $this->copyManifestFile($miradorId, $artwork->file_id);

        $blockId = DB::table('blocks')->insertGetId([
            'blockable_id' => $artwork->id,
            'blockable_type' => self::ARTWORK_TYPE,
            'position' => $this->nextBlockPosition($artwork->id),
            'content' => json_encode(['browsers' => [self::BROWSER => [$miradorId]]]),
            'type' => self::BROWSER,
            'child_key' => null,
            'parent_id' => null,
            'editor_name' => null,
        ]);

        DB::table('related')->insert([
            'subject_id' => $blockId,
            'subject_type' => self::SUBJECT_TYPE,
            'related_id' => $miradorId,
            'related_type' => self::MIRADOR_TYPE,
            'browser_name' => self::BROWSER,
            'position' => 1,
        ]);
    }

    /**
     * Skip artworks already curated with a Mirador in their Multimedia section.
     */
    private function hasMiradorBlock(int $artworkId): bool
    {
        return DB::table('blocks')
            ->join('related', function ($join) {
                $join->on('related.subject_id', '=', 'blocks.id')
                    ->where('related.subject_type', '=', self::SUBJECT_TYPE)
                    ->where('related.browser_name', '=', self::BROWSER)
                    ->where('related.related_type', '=', self::MIRADOR_TYPE);
            })
            ->where('blocks.blockable_type', self::ARTWORK_TYPE)
            ->where('blocks.blockable_id', $artworkId)
            ->exists();
    }

    private function createMirador(object $artwork): int
    {
        $title = self::TITLE_PREFIX . ($artwork->datahub_id ?: $artwork->id);
        $now = now();

        $miradorId = DB::table('miradors')->insertGetId([
            'published' => true,
            'title' => $title,
            'object_id' => $artwork->default_manifest_url ? $artwork->datahub_id : null,
            'default_view' => $artwork->default_view ?: 'single',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('mirador_slugs')->insert([
            'slug' => $this->uniqueSlug(Str::slug($title)),
            'locale' => 'en',
            'active' => true,
            'mirador_id' => $miradorId,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        return $miradorId;
    }

    private function uniqueSlug(string $slug): string
    {
        $candidate = $slug;
        $suffix = 1;

        while (DB::table('mirador_slugs')->where('slug', $candidate)->exists()) {
            $candidate = $slug . '-' . ++$suffix;
        }

        return $candidate;
    }

    /**
     * Reuse the artwork's uploaded manifest file on the Mirador record.
     */
    private function copyManifestFile(int $miradorId, ?int $fileId): void
    {
        if (empty($fileId)) {
            return;
        }

        $now = now();

        DB::table('fileables')->insert([
            'file_id' => $fileId,
            'fileable_id' => $miradorId,
            'fileable_type' => self::MIRADOR_TYPE,
            'role' => self::MANIFEST_ROLE,
            'locale' => 'en',
            'position' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    private function nextBlockPosition(int $artworkId): int
    {
        $max = DB::table('blocks')
            ->where('blockable_type', self::ARTWORK_TYPE)
            ->where('blockable_id', $artworkId)
            ->whereNull('parent_id')
            ->max('position');

        return (int) $max + 1;
    }
};
