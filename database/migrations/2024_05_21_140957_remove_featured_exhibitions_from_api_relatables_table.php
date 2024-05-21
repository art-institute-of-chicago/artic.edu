<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('api_relatables', function (Blueprint $table) {
            $table->where('relation', 'exhibitionUpcomingListing')->delete();
            $table->where('relation', 'exhibitionExhibitions')->delete();
        });
    }

    public function down(): void
    {
        Schema::table('api_relatables', function (Blueprint $table) {
            //
        });
    }
};
