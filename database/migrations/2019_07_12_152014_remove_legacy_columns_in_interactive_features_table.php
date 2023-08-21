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
        Schema::table('interactive_features', function (Blueprint $table) {
            $table->dropColumn(['datahub_id', 'asset_library', 'content_bundle']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('interactive_features', function (Blueprint $table) {
        });
    }
};
