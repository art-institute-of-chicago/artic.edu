<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (config('app.env') === 'testing') {
            DB::statement('ALTER TABLE custom_tours CONNECTION = "tours"');
        }
    }

    public function down(): void
    {
        if (config('app.env') === 'testing') {
            DB::statement('ALTER TABLE custom_tours CONNECTION = "pgsql"');
        }
    }
};
