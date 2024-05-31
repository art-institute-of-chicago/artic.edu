<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('digital_publication_articles')->whereNull('type')->delete();
        Schema::table('digital_publication_articles', function (Blueprint $table) {
            $table->string('type')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('digital_publication_articles', function (Blueprint $table) {
            $table->string('type')->nullable()->change();
        });
    }
};
