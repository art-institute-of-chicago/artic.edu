<?php

use A17\Twill\Models\Tag;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Tag::firstOrCreate([
            'namespace' => 'media',
            'slug' => 'ai-generated-alt-text'
        ], [
            'name' => 'AI Generated Alt Text',
        ]);
    }

    public function down(): void
    {
        Tag::where('slug', 'ai-generated-alt-text')->delete();
    }
};
