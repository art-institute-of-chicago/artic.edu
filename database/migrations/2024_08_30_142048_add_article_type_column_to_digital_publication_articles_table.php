<?php

use App\Enums\DigitalPublicationArticleType;
use App\Models\DigitalPublicationArticle;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $types = array_map(fn($enum) => $enum->value, DigitalPublicationArticleType::cases());
        Schema::table('digital_publication_articles', function (Blueprint $table) use ($types) {
            $table->enum('article_type', $types)->default('text');
        });
        foreach (DigitalPublicationArticle::withTrashed()->get() as $article) {
            $article->article_type = $article->type;
            $article->save();
        }
        Schema::table('digital_publication_articles', function (Blueprint $table) use ($types) {
            $table->dropColumn('type');
        });
    }

    public function down(): void
    {
        Schema::table('digital_publication_articles', function (Blueprint $table) {
            $table->string('type')->nullable(false)->default('text');
        });
        foreach (DigitalPublicationArticle::withTrashed()->get() as $article) {
            $article->type = $article->article_type;
            $article->save();
        }
        Schema::table('digital_publication_articles', function (Blueprint $table) {
            $table->dropColumn('article_type');
        });
    }
};
