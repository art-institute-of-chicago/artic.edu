<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('issues', function (Blueprint $table) {
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
        });

        Schema::table('issue_articles', function (Blueprint $table) {
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('issues', function (Blueprint $table) {
            $table->dropColumn('meta_title');
            $table->dropColumn('meta_description');
        });

        Schema::table('issue_articles', function (Blueprint $table) {
            $table->dropColumn('meta_title');
            $table->dropColumn('meta_description');
        });
    }
};
