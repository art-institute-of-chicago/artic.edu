<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Find all image blocks of digitalPublicationArticles
        $digiPubImageBlocks = DB::table(table: 'blocks')
            ->where(column: 'type', operator: 'image')
            ->where(column: 'blockable_type', operator: 'digitalPublicationArticles')
            ->get();

        // Update the size in the content JSON column to 'l'
        foreach ($digiPubImageBlocks as $block) {
            $content = json_decode($block->content, associative: true);

            $content['size'] = 'l';
            $content['use_alt_background'] = true;
            $content['use_contain'] = true;

            // Update the block with the new JSON
            DB::table(table: 'blocks')
                ->where(column: 'id', operator: $block->id)
                ->update(values: ['content' => json_encode(value: $content)]);
        }
    }

    public function down(): void
    {
        // There's no going back...
    }
};
