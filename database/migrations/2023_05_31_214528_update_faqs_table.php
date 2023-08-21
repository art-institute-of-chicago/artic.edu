<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('faqs', function (Blueprint $table) {
            $table->text('question')->nullable();
            $table->text('answer')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropColumns('faqs', ['question', 'answer']);
    }
};
