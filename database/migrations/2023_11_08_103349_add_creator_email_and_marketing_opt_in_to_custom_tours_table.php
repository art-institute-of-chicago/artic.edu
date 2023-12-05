<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    protected $connection;

    public function __construct()
    {
        $this->connection = 'tours';
    }

    public function up(): void
    {
        Schema::table('custom_tours', function (Blueprint $table) {
            $table->string('creator_email', 255)->default('default@example.com');
            $table->boolean('marketing_opt_in')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('custom_tours', function (Blueprint $table) {
            $table->dropColumn('creator_email');
            $table->dropColumn('marketing_opt_in');
        });
    }
};
