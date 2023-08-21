<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('digital_publication_sections', function (Blueprint $table) {
            $table->renameColumn('bibliography', 'references');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('digital_publication_sections', function (Blueprint $table) {
            $table->renameColumn('references', 'bibliography');
        });
    }
};
