<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('experience_modals', function (Blueprint $table) {
            $table->renameColumn('experience_image', 'has_experience_image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('experience_modals', function (Blueprint $table) {
            $table->renameColumn('has_experience_image', 'experience_image');
        });
    }
};
