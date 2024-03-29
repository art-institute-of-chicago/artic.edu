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
        Schema::table('exhibitions', function (Blueprint $table) {
            $table->string('exhibition_message')->nullable();
            $table->text('sponsors_description')->nullable();
            $table->integer('cms_exhibition_type')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('exhibitions', function (Blueprint $table) {
            $table->dropColumn('exhibition_message');
            $table->dropColumn('sponsors_description');
            $table->dropColumn('cms_exhibition_type');
        });
    }
};
