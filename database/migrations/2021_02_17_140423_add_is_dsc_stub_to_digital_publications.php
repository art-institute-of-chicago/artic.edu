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
        Schema::table('digital_publications', function (Blueprint $table) {
            $table->boolean('is_dsc_stub')->default(true)->after('publish_end_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('digital_publications', function (Blueprint $table) {
            $table->dropColumn('is_dsc_stub');
        });
    }
};
