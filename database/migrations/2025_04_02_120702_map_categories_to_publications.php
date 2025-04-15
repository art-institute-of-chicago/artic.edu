<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    public function up(): void
    {
        $printedPublicationsCategories = [
            ['name' => 'On the Collection', 'ids' => [222, 221, 207, 200, 197, 195, 191, 173, 174, 172, 169, 162, 158, 142, 138, 133, 130, 76, 77, 67, 66, 63, 59, 58, 53, 23, 20, 14, 10, 4]],
            ['name' => 'Painting', 'ids' => [222, 220, 218, 217, 216, 214, 208, 205, 195, 194, 189, 188, 187, 186, 184, 178, 172, 163, 159, 161, 156, 142, 141, 140, 138, 134, 130, 75, 72, 70, 67, 66, 54, 65, 63, 61, 59, 57, 58, 53, 52, 46, 43, 34, 30, 27, 24, 14, 10, 5]],
            ['name' => 'Exhibition Catalogues', 'ids' => [221, 220, 219, 218, 217, 216, 214, 213, 212, 211, 210, 209, 208, 206, 205, 204, 203, 202, 201, 200, 199, 198, 196, 195, 194, 191, 190, 188, 187, 186, 185, 184, 182, 181, 178, 177, 179, 176, 171, 170, 167, 163, 160, 159, 161, 157, 156, 152, 147, 146, 144, 141, 143, 137, 135, 134, 133, 131, 75, 72, 70, 65, 63, 57, 56, 54, 52, 49, 51, 50, 47, 39, 41, 37, 35, 34, 31, 29, 30, 27, 28, 25, 24, 22, 15, 12, 9, 11, 8, 6, 5]],
            ['name' => 'American Art', 'ids' => [221, 216, 214, 209, 204, 200, 199, 198, 187, 186, 184, 174, 162, 163, 157, 140, 134, 130, 75, 72, 56, 53, 55, 54, 51, 50, 48, 39, 38, 35, 34, 28, 20, 15, 14, 10, 6]],
            ['name' => 'Contemporary Art', 'ids' => [221, 218, 214, 211, 210, 209, 207, 204, 203, 200, 199, 198, 196, 193, 190, 188, 187, 170, 158, 157, 144, 136, 135, 75, 72, 70, 69, 71, 53, 32, 34, 26, 22, 9, 6, 5]],
            ['name' => 'Sculpture', 'ids' => [221, 219, 218, 213, 212, 202, 197, 181, 176, 162, 157, 142, 139, 133, 130, 56, 53, 54, 13, 12]],
            ['name' => 'Modern Art', 'ids' => [220, 218, 217, 216, 212, 208, 207, 206, 201, 193, 192, 190, 184, 178, 179, 167, 163, 161, 146, 142, 143, 138, 134, 131, 65, 63, 53, 52, 51, 50, 30, 27, 28, 24, 14, 8]],
            ['name' => 'Ancient Art', 'ids' => [219, 181, 133]],
            ['name' => 'African Art', 'ids' => [218, 211, 203, 202, 197, 196, 13, 12]],
            ['name' => 'Decorative and Applied Arts', 'ids' => [218, 210, 190, 185, 182, 174, 147, 130, 45, 23, 20, 15]],
            ['name' => 'Photography and Media', 'ids' => [218, 211, 207, 201, 179, 170, 167, 161, 144, 137, 135, 131, 49, 51, 50, 47, 9, 8, 6]],
            ['name' => 'European Art', 'ids' => [217, 213, 212, 205, 201, 195, 194, 191, 188, 185, 182, 179, 176, 169, 167, 160, 159, 161, 152, 147, 146, 145, 142, 141, 138, 131, 67, 66, 54, 65, 63, 61, 59, 57, 58, 52, 49, 48, 47, 33, 31, 27, 25, 24, 23, 11, 8]],
            ['name' => 'Asian Art', 'ids' => [210, 189, 181, 170, 167, 164, 156, 76, 46, 43]],
            ['name' => 'Prints and Drawings', 'ids' => [209, 206, 204, 200, 199, 192, 191, 184, 171, 160, 157, 145, 143, 139, 136, 138, 76, 69, 71, 36, 38, 32, 33, 26, 27, 25, 24, 11]],
            ['name' => 'Architecture and Design', 'ids' => [190, 185, 182, 177, 161, 152, 151, 147, 77, 51, 39, 41, 37, 29, 28, 15, 7]],
            ['name' => 'Indigenous Art', 'ids' => [162, 56, 55]],
            ['name' => 'Kids\' Books', 'ids' => [79, 80, 54, 55]],
            ['name' => 'Medieval Art', 'ids' => [67, 59, 45]]
        ];

        $digitalPublicationsCategories = [
            ['name' => 'Modern Art', 'ids' => [34, 6, 3]],
            ['name' => 'American Art', 'ids' => [33, 32, 30, 13, 2]],
            ['name' => 'European Art', 'ids' => [31, 13, 12, 11, 10, 9, 8, 7, 5, 4]],
            ['name' => 'Decorative and Applied Arts', 'ids' => [2]]
        ];

        foreach ($printedPublicationsCategories as $category) {
            $categoryId = DB::table('catalog_categories')->where('name', $category['name'])->value('id');

            if (!$categoryId) {
                $categoryId = DB::table('catalog_categories')->insertGetId([
                    'name' => $category['name'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            foreach ($category['ids'] as $publicationId) {
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
        }

        foreach ($digitalPublicationsCategories as $category) {
            $categoryId = DB::table('catalog_categories')->where('name', $category['name'])->value('id');

            if (!$categoryId) {
                $categoryId = DB::table('catalog_categories')->insertGetId([
                    'name' => $category['name'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            foreach ($category['ids'] as $publicationId) {
                if (
                    DB::table('catalog_category_digital_publication')->where('digital_publication_id', $publicationId)->where('catalog_category_id', $categoryId)->doesntExist() &&
                    DB::table('digital_publications')->where('id', $publicationId)->exists()
                ) {
                    DB::table('catalog_category_digital_publication')->insert([
                        'digital_publication_id' => $publicationId,
                        'catalog_category_id' => $categoryId,
                    ]);
                }
            }
        }
    }

    public function down(): void
    {
        // There's no going back...
    }
};
