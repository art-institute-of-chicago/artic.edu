<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Models\Vendor\Block;
use App\Models\EducatorResource;

return new class () extends Migration {
    public function up(): void
    {
        $resources = EducatorResource::all();

        foreach ($resources as $resource) {
            $linkBlocks = Block::where('type', 'link')
                ->where('blockable_id', $resource->id)
                ->where(function ($query) {
                    $query->where('blockable_type', 'educatorResources')
                          ->orWhere('blockable_type', EducatorResource::class);
                })
                ->get();

            foreach ($linkBlocks as $block) {
                $fileRefs = DB::table('fileables')
                    ->where('fileable_id', $block->id)
                    ->where(function ($query) {
                        $query->where('fileable_type', 'blocks')
                              ->orWhere('fileable_type', Block::class);
                    })
                    ->get();

                foreach ($fileRefs as $fileRef) {
                    DB::table('fileables')
                        ->where('id', $fileRef->id)
                        ->update([
                            'fileable_id' => $resource->id,
                            'fileable_type' => 'educatorResources',
                            'role' => 'pdf',
                            'updated_at' => now()
                        ]);
                }

                $block->delete();
            }
        }
    }

    public function down(): void
    {
        // Can't go back..
    }
};
