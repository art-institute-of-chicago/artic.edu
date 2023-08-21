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
        Schema::create('departments', function (Blueprint $table) {
            createDefaultTableFields($table, true, false);

            $table->text('intro')->nullable();
            $table->integer('datahub_id')->unsigned();
        });

        Schema::create('department_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'department');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('department_slugs');
        Schema::dropIfExists('departments');
    }
};
