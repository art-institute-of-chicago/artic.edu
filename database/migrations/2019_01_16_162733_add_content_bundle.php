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
        Schema::table('digital_labels', function (Blueprint $table) {
            $table->text('asset_library')->nullable();
            $table->text('content_bundle')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('digital_labels', function (Blueprint $table) {
            $table->dropColumn('asset_library');
            $table->dropColumn('content_bundle');
        });
    }
};
