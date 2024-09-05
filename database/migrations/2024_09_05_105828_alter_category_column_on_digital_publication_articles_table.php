<?php

use App\Enums\DigitalPublicationArticleCategory;
use App\Models\DigitalPublicationArticle;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('digital_publication_articles', function (Blueprint $table) {
            $table->enum('category', $this->categories())->default('text');
        });
        foreach (DigitalPublicationArticle::withTrashed()->get() as $article) {
            $article->category = $article->article_type;
            $article->save();
        }
        Schema::table('digital_publication_articles', function (Blueprint $table) {
            $table->dropColumn('article_type');
        });
    }

    public function down(): void
    {
        Schema::table('digital_publication_articles', function (Blueprint $table) {
            $table->enum('article_type', $this->categories())->nullable(false)->default('text');
        });
        foreach (DigitalPublicationArticle::withTrashed()->get() as $article) {
            $article->article_type = $article->category;
            $article->save();
        }
        Schema::table('digital_publication_articles', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }

    private function categories(): array
    {
        return array_map(fn ($enum) => $enum->value, DigitalPublicationArticleCategory::cases());
    }
};
