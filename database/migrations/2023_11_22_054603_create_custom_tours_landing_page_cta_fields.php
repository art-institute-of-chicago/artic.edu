<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('landing_pages', function (Blueprint $table) {
            $table->string('tours_create_cta_module_header')->nullable();
            $table->text('tours_create_cta_module_body')->nullable();
            $table->string('tours_create_cta_module_button_text')->nullable();
            $table->string('tours_create_cta_module_action_url')->nullable();
            $table->string('tours_tickets_cta_module_header')->nullable();
            $table->text('tours_tickets_cta_module_body')->nullable();
            $table->string('tours_tickets_cta_module_button_text')->nullable();
            $table->string('tours_tickets_cta_module_action_url')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tours_create_cta_module_header');
        Schema::dropIfExists('tours_create_cta_module_body');
        Schema::dropIfExists('tours_create_cta_module_button_text');
        Schema::dropIfExists('tours_create_cta_module_action_url');
        Schema::dropIfExists('tours_tickets_cta_module_header');
        Schema::dropIfExists('tours_tickets_cta_module_body');
        Schema::dropIfExists('tours_tickets_cta_module_button_text');
        Schema::dropIfExists('tours_tickets_cta_module_action_url');
    }
};
