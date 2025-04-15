<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('digital_publications', function (Blueprint $table) {
            $table->date('publication_date')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('digital_publications', function (Blueprint $table) {
            $table->dropColumn('publication_date');
        });
    }
};
