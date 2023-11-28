<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
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
        Schema::table('landing_pages', function (Blueprint $table) {
            $table->dropColumn('tours_create_cta_module_header');
            $table->dropColumn('tours_create_cta_module_body');
            $table->dropColumn('tours_create_cta_module_button_text');
            $table->dropColumn('tours_create_cta_module_action_url');
            $table->dropColumn('tours_tickets_cta_module_header');
            $table->dropColumn('tours_tickets_cta_module_body');
            $table->dropColumn('tours_tickets_cta_module_button_text');
            $table->dropColumn('tours_tickets_cta_module_action_url');
        });
    }
};
