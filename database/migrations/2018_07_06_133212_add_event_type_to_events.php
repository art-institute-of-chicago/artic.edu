<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Models\Event;

class AddEventTypeToEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->integer('event_type')->unsigned()->default(1);
        });

        $dispatcher = Event::getEventDispatcher();
        Event::unsetEventDispatcher();

        foreach (Event::all() as $event) {
            $event->event_type = $event->type;
            $event->save();
        }

        Event::setEventDispatcher($dispatcher);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('event_type');
        });
    }
}
