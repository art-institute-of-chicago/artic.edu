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
            $table->string('resource_target');
            $table->string('resource_title');
            $table->string('resource_description');
            $table->string('resource_link_label');
            $table->string('resource_link_url');
            $table->foreignId('landing_page_id')->constrained('landing_pages')->onDelete('CASCADE');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('publication_resources');
    }
};
