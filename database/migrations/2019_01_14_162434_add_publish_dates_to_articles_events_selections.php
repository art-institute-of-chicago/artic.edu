<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    private $tableNames = [
        'articles',
        'events',
        'selections',
    ];

    public function up(): void
    {
        $this->down();

        foreach ($this->tableNames as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->timestamp('publish_start_date')->nullable()->after('published');
                $table->timestamp('publish_end_date')->nullable()->after('publish_start_date');
            });
        }
    }

    public function down(): void
    {
        foreach ($this->tableNames as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                if (Schema::hasColumn($tableName, 'publish_start_date')) {
                    $table->dropColumn('publish_start_date');
                }

                if (Schema::hasColumn($tableName, 'publish_end_date')) {
                    $table->dropColumn('publish_end_date');
                }
            });
        }
    }
};
