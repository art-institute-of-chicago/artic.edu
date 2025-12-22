<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('mediables')
            ->where('role', 'image')
            ->where('crop', 'desktop')
            ->update([
                'crop' => 'flexible',
                'ratio' => 'free',
                'updated_at' => now(),
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('mediables')
            ->where('role', 'image')
            ->where('crop', 'free')
            ->update([
                'crop' => 'desktop',
                'ratio' => 'desktop',
                'updated_at' => now(),
            ]);
    }
};
