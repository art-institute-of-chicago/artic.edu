<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    protected $connection;

    public function __construct()
    {
        $this->connection = 'tours';
    }

    public function up(): void
    {
        Schema::rename('my_museum_tour', 'my_museum_tours');
    }

    public function down(): void
    {
        Schema::rename('my_museum_tours', 'my_museum_tour');
    }
};
