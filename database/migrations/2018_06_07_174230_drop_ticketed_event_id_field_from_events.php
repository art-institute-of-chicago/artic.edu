<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            if (env('APP_ENV') != 'testing') {
                $table->dropForeign('events_ticketed_event_id_foreign');
            }
            $table->dropColumn('ticketed_event_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->integer('ticketed_event_id')->unsigned()->nullable()->after('is_admission_required');
            $table->foreign('ticketed_event_id')->references('id')->on('ticketed_events')->onDelete('CASCADE');
        });
    }
};
