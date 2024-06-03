<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $models = [
        'artworks',
        'articles',
        'highlights',
        'events',
        'exhibitions',
        'experiences',
        'digital_publications',
        'videos',
        'generic_pages',
    ];

    public function up(): void
    {
        foreach ($this->models as $model) {
            Schema::table($model, function (Blueprint $table) {
                $table->boolean('toggle_autorelated')->default(false);
            });
        }
    }

    public function down(): void
    {
        foreach ($this->models as $model) {
            Schema::table($model, function (Blueprint $table) {
                $table->dropColumn('toggle_autorelated');
            });
        }
    }
};