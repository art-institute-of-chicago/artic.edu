<?php

use App\Models\LandingPage;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $pdfAvailableIds = [
            16, 17, 19, 21, 40, 42, 44, 60, 62, 68,
            73, 74, 81, 82, 83, 84, 85, 86, 87, 88,
            89, 90, 91, 92, 93, 94, 95, 96, 97, 98,
            99, 100, 101, 102, 103, 104, 105, 106, 107, 108,
            109, 110, 111, 112, 113, 114, 115, 116, 117, 118,
            119, 120, 121, 122, 123, 124, 125, 126, 127, 128,
            129, 132,
        ];

        $categoryName = 'PDF Available';
        $categoryId = DB::table('catalog_categories')->where('name', $categoryName)->value('id');

        if (!$categoryId) {
            $categoryId = DB::table('catalog_categories')->insertGetId([
                'name' => $categoryName,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        foreach ($pdfAvailableIds as $publicationId) {
            if (
                DB::table('catalog_category_printed_publication')->where('printed_publication_id', $publicationId)->where('catalog_category_id', $categoryId)->doesntExist() &&
                DB::table('printed_publications')->where('id', $publicationId)->exists()
            ) {
                DB::table('catalog_category_printed_publication')->insert([
                    'printed_publication_id' => $publicationId,
                    'catalog_category_id' => $categoryId,
                ]);
            }
        }

        $lp = LandingPage::published()->type('Publications')->firstOrNew([], ['labels' => ['filters' => []]]);
        if (!$lp->labels) {
            $lp->labels = collect(['filters' => []]);
        }
        $filters = $lp->labels->get('filters') ?? [];
        if (!in_array($categoryId, $filters)) {
            $filters[] = $categoryId;
        }
        $lp->labels->put('filters', $filters);
        $lp->save();
    }

    public function down(): void
    {
        // There's still no going back...
    }
};
