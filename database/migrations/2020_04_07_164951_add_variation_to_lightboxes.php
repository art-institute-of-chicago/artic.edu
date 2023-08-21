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
        Schema::table('lightboxes', function (Blueprint $table) {
            // \App\Models\Lightbox::VARIATION_DEFAULT
            $table->integer('variation')->default(1)->after('lightbox_button_text');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('lightboxes', function (Blueprint $table) {
            $table->dropColumn('variation');
        });
    }
};
