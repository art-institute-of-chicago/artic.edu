<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Article;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('subtype')->nullable();
        });

        $dispatcher = Article::getEventDispatcher();
        Article::unsetEventDispatcher();

        foreach (Article::all() as $article) {
            $article->subtype = $article->getOriginal('type');
            $article->save();
        }

        Article::setEventDispatcher($dispatcher);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('subtype');
        });
    }
};
