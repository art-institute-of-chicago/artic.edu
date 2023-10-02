<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {

    protected $connection;

    public function __construct()
    {
        if (env('APP_ENV') !== 'testing') {
            $this->connection = 'tours_db';
        }
        else {
            $this->connection = env('DB_CONNECTION');
        }
    }
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
        Schema::connection($this->connection)->dropIfExists('tours');
    }
};
