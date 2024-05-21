<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    public function up(): void
    {
        DB::table('api_relatables')->where('relation', 'exhibitionsUpcomingListing')->delete();
        DB::table('api_relatables')->where('relation', 'exhibitionsExhibitions')->delete();
    }

    public function down(): void
    {
        Schema::table('api_relatables', function (Blueprint $table) {
            //
        });
    }
};
