<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Vendor\Block;

// select * From blocks where child_key='accordion_items' and blockable_type != 'digitalPublicationArticles';

return new class () extends Migration {
    public function up(): void
    {
        $blocks = Block::where('child_key', 'accordion_items')
            ->where('blockable_type', '!=', 'digitalPublicationArticles')
            ->get();

        foreach ($blocks as $block) {
            $block['child_key'] = null;
            $block['parent_id'] = null;
            $block->save();
        }
    }

    public function down(): void
    {
        //
    }
};
