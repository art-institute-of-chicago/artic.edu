<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function __construct()
    {
        $this->connection = 'tours';
    }

    public function up(): void
    {
        Schema::table('my_museum_tours', function (Blueprint $table) {
            $table->boolean('confirmation_sent')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('my_museum_tours', function (Blueprint $table) {
            $table->dropColumn('confirmation_sent');
        });
    }
};
