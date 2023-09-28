<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration
{
    public function up(): void
    {
        DB::statement("INSERT INTO landing_page_types (page_type) VALUES ('Pre-made Tours');");
    }

    public function down(): void
    {
        DB::statement("DELETE FROM landing_page_types WHERE page_type = 'Pre-made Tours';");
    }
};
