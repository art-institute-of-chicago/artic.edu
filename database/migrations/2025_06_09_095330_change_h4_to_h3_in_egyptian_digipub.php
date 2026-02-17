<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Vendor\Block;
use App\Models\DigitalPublicationArticle;

return new class () extends Migration {
    public function up(): void
    {
        $articles = DigitalPublicationArticle::where('digital_publication_id', 42)->get();

        foreach ($articles as $article) {
            $blocks = Block::where('type', 'paragraph')
                ->where('blockable_type', 'digitalPublicationArticles')
                ->where('blockable_id', $article->id)
                ->get();

            foreach ($blocks as $block) {
                $content = is_array($block->content) ? $block->content : json_decode($block->content, true);

                if (isset($content['paragraph'])) {
                    $originalParagraph = $content['paragraph'];

                    // Replace h4 opening and closing tags with h3
                    $updatedParagraph = preg_replace(
                        ['/<h4(\s[^>]*)?>/i', '/<\/h4>/i'],
                        ['<h3$1>', '</h3>'],
                        $originalParagraph
                    );

                    if ($originalParagraph !== $updatedParagraph) {
                        $content['paragraph'] = $updatedParagraph;

                        $block->update([
                            'content' => $content
                        ]);
                    }
                }
            }
        }
    }

    public function down(): void
    {
        $articles = DigitalPublicationArticle::where('digital_publication_id', 42)->get();

        foreach ($articles as $article) {
            $blocks = Block::where('type', 'paragraph')
                ->where('blockable_type', 'digitalPublicationArticles')
                ->where('blockable_id', $article->id)
                ->get();

            foreach ($blocks as $block) {
                $content = is_array($block->content) ? $block->content : json_decode($block->content, true);

                if (isset($content['paragraph'])) {
                    $originalParagraph = $content['paragraph'];

                    $updatedParagraph = preg_replace(
                        ['/<h3(\s[^>]*)?>/i', '/<\/h3>/i'],
                        ['<h4$1>', '</h4>'],
                        $originalParagraph
                    );

                    if ($originalParagraph !== $updatedParagraph) {
                        $content['paragraph'] = $updatedParagraph;

                        $block->update([
                            'content' => json_encode($content)
                        ]);
                    }
                }
            }
        }
    }
};
