<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('slides', function (Blueprint $table) {
            if (!Schema::hasColumn('slides', 'background_color')) {
                $table->string('background_color', 9)->nullable()->after('seamless_alt_text');
            }
            if (!Schema::hasColumn('slides', 'seamless_background_color')) {
                $table->string('seamless_background_color', 9)->nullable()->after('background_color');
            }
        });
    }

    public function down(): void
    {
        Schema::table('slides', function (Blueprint $table) {
            if (Schema::hasColumn('slides', 'seamless_background_color')) {
                $table->dropColumn('seamless_background_color');
            }
            if (Schema::hasColumn('slides', 'background_color')) {
                $table->dropColumn('background_color');
            }
        });
    }
};
