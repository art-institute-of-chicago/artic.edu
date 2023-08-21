<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_programs', function (Blueprint $table) {
            createDefaultTableFields($table, true, false);
            $table->string('name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_programs');
    }
};
