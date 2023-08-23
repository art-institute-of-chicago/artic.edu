<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('event_exhibition');
    }

    public function down(): void
    {
        Schema::create('event_exhibition', function (Blueprint $table) {
            $table->increments('id');

            createDefaultRelationshipTableFields($table, 'event', 'exhibition');
            $table->integer('position')->unsigned()->index();

            $table->timestamps();
        });
    }
};
