<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('exhibitions', function (Blueprint $table) {
            $table->dropColumn('sponsors_sub_copy');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('sponsors_sub_copy');
        });
    }

    public function down(): void
    {
        Schema::table('exhibitions', function (Blueprint $table) {
            $table->text('sponsors_sub_copy')->nullable();
        });

        Schema::table('events', function (Blueprint $table) {
            $table->text('sponsors_sub_copy')->nullable();
        });
    }
};
