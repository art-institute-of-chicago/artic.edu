<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('exhibition_press_rooms', function (Blueprint $table) {
            createDefaultTableFields($table, true, true, true, true);

            $table->string('title', 200)->nullable();
            $table->text('short_description')->nullable();
            $table->text('listing_description')->nullable();
        });

        Schema::create('exhibition_press_room_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'exhibition_press_room');
        });

        Schema::create('exhibition_press_room_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'exhibition_press_room');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exhibition_press_room_revisions');
        Schema::dropIfExists('exhibition_press_room_slugs');
        Schema::dropIfExists('exhibition_press_rooms');
    }
};
