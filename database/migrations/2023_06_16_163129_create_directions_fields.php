<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('landing_pages', function (Blueprint $table) {
            $table->string('visit_parking_label')->nullable();
            $table->string('visit_faqs_label')->nullable();
            $table->string('visit_faqs_link')->nullable();
        });
        Schema::table('menu_items', function (Blueprint $table) {
            $table->string('label')->nullable()->change();
            $table->string('link')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visit_parking_label');
        Schema::dropIfExists('visit_faqs_label');
        Schema::dropIfExists('visit_faqs_link');
    }
};
