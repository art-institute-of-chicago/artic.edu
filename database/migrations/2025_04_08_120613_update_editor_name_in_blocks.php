<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::update("UPDATE blocks SET editor_name='default' WHERE editor_name is null");
    }

    public function down(): void
    {
    }
};
