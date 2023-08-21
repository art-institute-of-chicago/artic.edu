<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('event_event', function (Blueprint $table) {
            if (env('APP_ENV') != 'testing') {
                $table->dropForeign('event_event_related_event_id_foreign');
            }
            $table->dropColumn('related_event_id')->unsigned();
            $table->integer('datahub_id')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('event_event', function (Blueprint $table) {
            $table->dropColumn('datahub_id');
            $table->integer('related_event_id')->unsigned();
            $table->foreign('related_event_id')->references('id')->on('events')->onDelete('cascade');
            $table->index(['related_event_id', 'event_id']);
        });
    }
};
