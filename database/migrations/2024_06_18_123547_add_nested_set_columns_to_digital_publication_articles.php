<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\DigitalPublicationArticle;

return new class () extends Migration {
    public function up()
    {
        Schema::table('digital_publication_articles', function (Blueprint $table) {
            $table->nestedSet();
        });

        // Get unique digital_publication_ids
        $digitalPublicationIds = DigitalPublicationArticle::select('digital_publication_id')
            ->distinct()
            ->pluck('digital_publication_id');

        foreach ($digitalPublicationIds as $digitalPublicationId) {
            // Get articles for this digital_publication_id, ordered by position
            $articles = DigitalPublicationArticle::where('digital_publication_id', $digitalPublicationId)
                ->orderBy('position')
                ->get();

            // Initialize the left value
            $lft = 1;

            foreach ($articles as $article) {
                // Set the left and right values for this article
                $article->_lft = $lft;
                $article->_rgt = $lft + 1;

                // Save the article
                $article->save();

                // Increment the left value for the next article
                $lft += 2;
            }
        }
    }

    public function down()
    {
        Schema::table('digital_publication_articles', function (Blueprint $table) {
            $table->dropNestedSet();
        });
    }
};
