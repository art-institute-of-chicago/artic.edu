<?php

use App\Models\Vendor\Block;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    public function up(): void
    {
        Block::where([
                ['type', '=', 'custom_banner'],
                ['content->theme', '=', 'editorial'],
                ['content->variation', '=', 'cloud'],
            ])
            ->update([
                'type' => 'tag_banner',
                'content->variation' => 'categories',
            ]);
    }

    public function down(): void
    {
        Block::where([
                ['type', '=', 'tag_banner'],
                ['content->theme', '=', 'editorial'],
                ['content->variation', '=', 'categories'],
            ])
            ->update([
                'type' => 'custom_banner',
                'content->variation' => 'cloud',
            ]);
    }
};
