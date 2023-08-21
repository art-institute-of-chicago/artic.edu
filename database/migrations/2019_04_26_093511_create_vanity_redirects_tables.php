<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('vanity_redirects', function (Blueprint $table) {
            createDefaultTableFields($table);

            $table->string('path', 200)->nullable();
            $table->text('destination')->nullable();
        });

        Schema::create('vanity_redirect_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'vanity_redirect');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vanity_redirect_revisions');
        Schema::dropIfExists('vanity_redirects');
    }
};
