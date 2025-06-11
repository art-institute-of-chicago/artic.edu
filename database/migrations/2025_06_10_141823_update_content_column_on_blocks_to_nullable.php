<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
      Schema::table('blocks', function (Blueprint $table) {
          $table->json('content')->nullable()->change();
      });
    }

    public function down(): void
    {
      Schema::table('blocks', function (Blueprint $table) {
          $table->json('content')->change();
      });
    }
};
