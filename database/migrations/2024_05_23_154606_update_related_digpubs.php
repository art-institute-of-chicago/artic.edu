<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("UPDATE blocks SET blockable_type='digitalPublicationArticles' where blockable_type='digitalPublicationSections'");
        DB::statement("UPDATE related SET subject_type='digitalPublicationArticles' where subject_type='digitalPublicationSections'");
        DB::statement("UPDATE related SET related_type='digitalPublicationArticles' where related_type='digitalPublicationSections'");
        DB::statement("UPDATE api_relatables SET api_relatable_type='digitalPublicationArticles' where api_relatable_type='digitalPublicationSections'");
        DB::statement("UPDATE mediables SET mediable_type='digitalPublicationArticles' where mediable_type='digitalPublicationSections'");
    }

    public function down(): void
    {
        DB::statement("UPDATE blocks SET blockable_type='digitalPublicationSections' where blockable_type='digitalPublicationArticles'");
        DB::statement("UPDATE related SET subject_type='digitalPublicationSections' where subject_type='digitalPublicationArticles'");
        DB::statement("UPDATE related SET related_type='digitalPublicationSections' where related_type='digitalPublicationArticles'");
        DB::statement("UPDATE api_relatables SET api_relatable_type='digitalPublicationSections' where api_relatable_type='digitalPublicationArticles'");
        DB::statement("UPDATE mediables SET mediable_type='digitalPublicationSections' where mediable_type='digitalPublicationArticles'");
    }
};
