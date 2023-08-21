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
        Schema::table('event_programs', function (Blueprint $table) {
            $table->boolean('is_event_host')->default(false)->after('is_affiliate_group');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->renameColumn('affiliate_group_id', 'event_host_id');
        });
        Schema::table('events', function (Blueprint $table) {
            $table->renameColumn('is_presented_by_affiliate', 'show_presented_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('event_programs', function (Blueprint $table) {
            $table->dropColumn('is_event_host');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->renameColumn('event_host_id', 'affiliate_group_id');
        });
        Schema::table('events', function (Blueprint $table) {
            $table->renameColumn('show_presented_by', 'is_presented_by_affiliate');
        });
    }
};
