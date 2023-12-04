<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (config('app.env') === 'testing') {
            DB::statement('ALTER TABLE public.custom_tours SET SCHEMA tours');
        }
    }

    public function down(): void
    {
        if (config('app.env') === 'testing') {
            DB::statement('ALTER TABLE tours.custom_tours SET SCHEMA public');
        }
    }
};
