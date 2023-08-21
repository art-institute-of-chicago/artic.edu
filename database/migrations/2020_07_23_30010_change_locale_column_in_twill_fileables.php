<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('fileables') && Schema::hasColumn('fileables', 'locale')) {
            Schema::table('fileables', function (Blueprint $table) {
                $table->string('locale', 7)->change();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('fileables') && Schema::hasColumn('fileables', 'locale')) {
            Schema::table('fileables', function (Blueprint $table) {
                $table->string('locale', 6)->change();
            });
        }
    }
};
