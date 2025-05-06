<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('educator_resource_translations', function (Blueprint $table) {
            createDefaultTranslationsTableFields($table, 'educator_resource');
            $table->string('title', 200)->nullable();
            $table->string('title_display')->nullable();
            $table->text('listing_description')->nullable();
            $table->text('short_description')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('educator_resource_translations');
    }
};
