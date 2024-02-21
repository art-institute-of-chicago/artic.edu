<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function __construct()
    {
        $this->connection = 'tours';
    }

    public function up(): void
    {
        Schema::table('custom_tours', function (Blueprint $table) {
            $table->string('pdf_download_path')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('custom_tours', function (Blueprint $table) {
            $table->dropColumn('pdf_download_path');
        });
    }
};
