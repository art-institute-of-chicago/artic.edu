<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'tours_db';

    public function up(): void
    {
        Schema::connection($this->connection)->create('tours', function (Blueprint $table) {
            $table->id();
            $table->json('tour_json');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
