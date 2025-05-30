<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class () extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('mediables') && !Schema::hasColumn('mediables', 'locale')) {
            Schema::table('mediables', function (Blueprint $table) {
                $table->string('locale', 7)->default($this->getCurrentLocale())->index();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('mediables') && Schema::hasColumn('mediables', 'locale')) {
            Schema::table('mediables', function (Blueprint $table) {
                $table->dropIndex('mediables_locale_index');
                $table->dropColumn('locale');
            });
        }
    }

    public function getCurrentLocale()
    {
        return getLocales()[0] ?? config('app.locale');
    }
};
