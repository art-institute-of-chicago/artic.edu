<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table(table: 'exhibitions', callback: function (Blueprint $table): void {
            $table->string(column: 'type_override')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table(table: 'exhibitions', callback: function (Blueprint $table): void {
            $table->dropColumn(columns: 'type_override');
        });
    }
};
