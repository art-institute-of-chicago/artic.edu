<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('landing_page_types');
        Schema::table('landing_pages', function (Blueprint $table) {
            $table->renameColumn('type', 'type_id');
        });
    }

    public function down(): void
    {
        Schema::table('landing_pages', function (Blueprint $table) {
            $table->renameColumn('type_id', 'type');
        });
        Schema::create('landing_page_types', function (Blueprint $table) {
            createDefaultTableFields($table, softDeletes: false, published: false);
            $table->string('page_type');
        });
    }
};
