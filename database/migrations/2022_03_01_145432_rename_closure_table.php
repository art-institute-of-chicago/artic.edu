<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::rename('closures', 'building_closures');
    }

    public function down(): void
    {
        Schema::rename('building_closures', 'closures');
    }
};
