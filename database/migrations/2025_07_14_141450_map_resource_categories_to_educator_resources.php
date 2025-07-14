<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\EducatorResource;
use App\Models\ResourceCategory;

return new class () extends Migration {
    public function up(): void
    {
        ResourceCategory::query()->delete();

        $resourceCategories = [
          ['name' => 'Student Activities', 'type' => 'category', 'resource_ids' => [151, 150, 149, 148, 144, 143, 123, 121, 114, 110, 109, 107, 105, 101, 99, 40, 34]],
          ['name' => 'Artmaking Activities', 'type' => 'category', 'resource_ids' => [156, 155, 154, 153, 152, 143, 141, 139, 138, 137, 136, 135, 134, 132, 131, 130, 129, 128, 127, 126, 124, 123, 122, 120, 119, 118, 110, 109, 107, 105, 40, 36, 33, 23, 17, 13, 12, 160, 161, 158, 159]],
          ['name' => 'Lessons/Teaching Plans', 'type' => 'category', 'resource_ids' => [125, 123, 122, 120, 119, 118, 117]],
          ['name' => 'Artwork Spotlight', 'type' => 'category', 'resource_ids' => [156, 155, 154, 153, 152, 141, 139, 138, 137, 136, 135, 134, 132, 131, 130, 129, 128, 127, 126, 124, 125, 123, 122, 121, 120, 119, 118, 113, 112, 111, 110, 109, 107, 105, 101, 48, 46, 40, 36, 34, 33, 32, 23, 17, 13, 12, 160, 161, 158, 159]],
          ['name' => 'Tips & Tutorials', 'type' => 'category', 'resource_ids' => [142, 111, 102, 99]],
          ['name' => 'STEAM', 'type' => 'category', 'resource_ids' => [155, 154, 126, 124, 125, 122, 121, 120, 119, 117, 46, 40, 36, 34, 13]],
          ['name' => 'Language Arts', 'type' => 'category', 'resource_ids' => [156, 151, 148, 141, 139, 138, 123, 114, 102, 46, 34, 32, 17, 13]],
          ['name' => 'History', 'type' => 'category', 'resource_ids' => [156, 155, 154, 153, 152, 141, 139, 138, 137, 136, 135, 134, 132, 131, 130, 129, 128, 127, 126, 124, 125, 123, 122, 120, 119, 118, 117, 113, 112, 48, 36, 34, 33, 32, 23, 17, 13, 12, 160, 161, 158, 159]],
          ['name' => 'Elementary', 'type' => 'audience', 'resource_ids' => [150, 149, 144, 142, 130, 129, 128, 127, 126, 124, 121, 114, 110, 109, 107, 105, 99, 36, 32, 17]],
          ['name' => 'Middle School', 'type' => 'audience', 'resource_ids' => [156, 155, 154, 153, 152, 151, 150, 149, 148, 144, 143, 142, 141, 139, 138, 137, 136, 135, 134, 132, 131, 130, 129, 128, 127, 126, 124, 125, 123, 122, 121, 120, 119, 118, 117, 114, 113, 112, 111, 102, 101, 99, 48, 46, 40, 36, 34, 33, 32, 23, 17, 13, 12]],
          ['name' => 'High School', 'type' => 'audience', 'resource_ids' => [157, 156, 155, 154, 153, 152, 151, 150, 149, 148, 144, 143, 142, 141, 139, 138, 137, 136, 135, 134, 132, 131, 130, 129, 128, 127, 126, 124, 125, 123, 122, 121, 120, 119, 118, 117, 113, 112, 111, 102, 101, 99, 48, 46, 40, 36, 34, 33, 32, 23, 17, 13, 12]],
          ['name' => 'Chicago', 'type' => 'topic', 'resource_ids' => [155, 154, 153, 152, 128, 127, 113, 110, 33, 23, 17, 13, 160, 161, 158]],
          ['name' => 'Latine Art', 'type' => 'topic', 'resource_ids' => [157, 156, 135, 134, 132, 131, 117, 101]],
          ['name' => 'Black Art', 'type' => 'topic', 'resource_ids' => [137, 136, 128, 127, 126, 124, 123, 113, 36, 33, 23, 12, 160, 161, 158]],
          ['name' => 'A/AAPI Art', 'type' => 'topic', 'resource_ids' => [119, 118, 107]],
          ['name' => 'Indigenous Art', 'type' => 'topic', 'resource_ids' => [155, 154, 132, 131, 117]],
          ['name' => 'Landscape', 'type' => 'topic', 'resource_ids' => [130, 129, 126, 124, 113, 17]],
          ['name' => 'Portrait', 'type' => 'topic', 'resource_ids' => [157, 156, 153, 152, 142, 135, 134, 132, 131, 123, 113, 111, 105, 33, 23, 12]],
          ['name' => 'Community', 'type' => 'topic', 'resource_ids' => [139, 138, 137, 136, 135, 134, 132, 131, 128, 127, 123, 113, 107, 101, 40, 32, 23, 12, 160, 161, 158]],
          ['name' => 'Identity', 'type' => 'topic', 'resource_ids' => [157, 156, 153, 152, 142, 137, 136, 135, 134, 132, 131, 128, 127, 123, 118, 117, 113, 107, 33, 23, 12, 160, 158]],
          ['name' => 'Migration/Immigration', 'type' => 'topic', 'resource_ids' => [153, 152, 128, 127, 122, 120, 119, 118, 117, 113, 33, 13, 160, 161, 158]],
          ['name' => 'Activism', 'type' => 'topic', 'resource_ids' => [155, 154, 137, 136, 132, 131, 128, 127, 123, 113, 107, 101, 48, 23, 13, 12, 160, 161]],
          ['name' => 'Woman Artist', 'type' => 'topic', 'resource_ids' => [155, 154, 132, 131, 130, 129, 128, 127, 123, 119, 113, 112, 107, 48, 46, 36, 17, 160, 161]]
        ];

        $position = 1;
        foreach ($resourceCategories as $categoryData) {
            $category = ResourceCategory::firstOrCreate(
                [
                    'name' => $categoryData['name'],
                    'type' => $categoryData['type']
                ],
                [
                    'position' => $position++
                ]
            );

            foreach ($categoryData['resource_ids'] as $resourceId) {
                $educatorResource = EducatorResource::find($resourceId);

                if ($educatorResource) {
                    if (!$educatorResource->categories()->where('resource_category_id', $category->id)->exists()) {
                        $educatorResource->categories()->attach($category->id);
                    }
                }
            }
        }
    }
};
