<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('issue_articles', function (Blueprint $table) {
            $table->text('cite_as')->nullable()->after('author_display');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('issue_articles', function (Blueprint $table) {
            $table->dropColumn('cite_as');
        });
    }
};
