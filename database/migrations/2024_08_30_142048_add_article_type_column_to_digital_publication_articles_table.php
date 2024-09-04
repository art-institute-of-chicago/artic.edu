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
        $categories = array_map(fn ($category) => $category->value, DigitalPublicationArticleCategory::cases());
        Schema::table('digital_publication_articles', function (Blueprint $table) use ($categories) {
            $table->enum('category', $categories)->nullable(false)->default('text');
        });
        foreach (DigitalPublicationArticle::withTrashed()->get() as $article) {
            $article->category = $article->type;
            $article->save();
        }
        Schema::table('digital_publication_articles', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }

    public function down(): void
    {
        Schema::table('digital_publication_articles', function (Blueprint $table) {
            $table->string('type')->nullable(false)->default('text');
        });
        foreach (DigitalPublicationArticle::withTrashed()->get() as $article) {
            $article->type = $article->category;
            $article->save();
        }
        Schema::table('digital_publication_articles', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
};
