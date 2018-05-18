<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateExhibitionPressRoomsTables extends Migration
{
    public function up()
    {
        Schema::create('exhibition_press_rooms', function (Blueprint $table) {
            createDefaultTableFields($table, true, true, true, true);

            $table->string('title', 200)->nullable();
            $table->text('short_description')->nullable();
            $table->text('listing_description')->nullable();
        });

        // remove this if you're not going to use slugs
        Schema::create('exhibition_press_room_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'exhibition_press_room');
        });

        // remove this if you're not going to use revisions
        Schema::create('exhibition_press_room_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'exhibition_press_room');
        });
    }

    public function down()
    {
        Schema::dropIfExists('exhibition_press_room_revisions');
        Schema::dropIfExists('exhibition_press_room_slugs');
        Schema::dropIfExists('exhibition_press_rooms');
    }
}
