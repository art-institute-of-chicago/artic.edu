<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Vendor\Block;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Block::where('type', 'layered_image_viewer')
            ->get()
            ->each(function ($block) {
                $content = $block->content;

                if (is_array($content)) {
                    $content['size'] = 's';
                } else {
                    $contentArray = json_decode($content, true);
                    if ($contentArray !== null) {
                        $contentArray['size'] = 's';
                        $content = $contentArray;
                    }
                }

                $block->content = $content;
                $block->save();
            });
    }
};
