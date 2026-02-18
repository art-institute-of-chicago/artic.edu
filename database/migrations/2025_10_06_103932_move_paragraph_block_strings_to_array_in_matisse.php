<?php

use App\Models\DigitalPublicationArticle;
use Illuminate\Database\Migrations\Migration;
use App\Models\Vendor\Block;

return new class () extends Migration {
    public function up(): void
    {
        // Get all articles for Matisse
        $articles = DigitalPublicationArticle::where('digital_publication_id', 46)->get();

        foreach ($articles as $article) {
            $paragraphBlocks = Block::where('type', 'paragraph')->where('blockable_id', $article->id)->where('blockable_type', 'digitalPublicationArticles')->get();

            foreach ($paragraphBlocks as $block) {
                if (!empty($block['content']['paragraph'] ?? '')) {
                    $content = $block['content'];
                    $fieldValue = $content['paragraph'];

                    // Check if the field is already an array (already translated)
                    if (is_array($fieldValue)) {
                        continue;
                    }

                    $translatedContent = [
                    'es' => null,
                    'en' => $fieldValue
                    ];
                    // Update the field in the content array
                    $content['paragraph'] = $translatedContent;
                    // Set the entire content attribute
                    $block['content'] = $content;
                    $block->save();
                }
            }
        }
    }
};
