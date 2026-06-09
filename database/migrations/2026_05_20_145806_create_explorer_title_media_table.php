<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('explorer_title_media', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->morphs('mediable');
            $table->integer('position')->unsigned()->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('explorer_title_media');
    }
};
