<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('publication_resources', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->string('position');
            $table->string('resource_target')->nullable();
            $table->string('resource_title')->nullable();
            $table->string('resource_description')->nullable();
            $table->string('resource_link_label')->nullable();
            $table->string('resource_link_url')->nullable();
            $table->foreignId('landing_page_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('publication_resources');
    }
};
