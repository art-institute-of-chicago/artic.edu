<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    protected $connection;

    public function __construct()
    {
        if (config('app.env') !== 'testing') {
            $this->connection = 'tours';
        }
    }

    public function up(): void
    {
        Schema::create('custom_tours', function (Blueprint $table) {
            $table->id();
            $table->json('tour_json');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('custom_tours');
    }
};
