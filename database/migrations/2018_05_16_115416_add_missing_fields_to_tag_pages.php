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
        Schema::table('artists', function (Blueprint $table) {
            $table->text('caption')->nullable();
            $table->text('intro')->nullable();
            $table->dropColumn('intro_copy')->nullable();
        });

        Schema::table('departments', function (Blueprint $table) {
            $table->text('caption')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('artists', function (Blueprint $table) {
            $table->dropColumn('caption');
            $table->dropColumn('intro');
            $table->text('intro_copy')->nullable();
        });

        Schema::table('departments', function (Blueprint $table) {
            $table->dropColumn('caption');
        });
    }
};
