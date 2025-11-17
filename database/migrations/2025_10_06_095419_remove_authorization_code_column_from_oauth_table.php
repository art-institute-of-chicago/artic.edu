<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('oauth', function (Blueprint $table) {
            $table->timestamp('updated_at')->nullable();
            $table->dropColumn('authorization_code');
        });
    }

    public function down(): void
    {
        Schema::table('oauth', function (Blueprint $table) {
            $table->string('authorization_code', 256)->unique();
            $table->dropColumn('updated_at');
        });
    }
};
