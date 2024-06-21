<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use App\Libraries\AIServices\VectorEmbeddingService as EmbeddingService;
use App\Libraries\AIServices\SemanticSearchService as SearchService;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Models\Vendor\Block;
use Pgvector\Laravel\Vector;
use App\Models\Embedding;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('embed', function () {
    $this->info(' --------------- ');
    $this->info('|               |');
    $this->info('|               |');
    $this->info('|               |');
    $this->info('|               |');
    $this->info('|               |');
    $this->info('|               |');
    $this->info('|        A I C  |');
    $this->info(' --------------- ');
    $modelClass = $this->ask('What is the model class?');

    $model = "\\App\\Models\\$modelClass";
    $morphedModel = app($model)->getMorphClass();

    if (!class_exists($model)) {
        $this->error("The class {$modelClass} does not exist.");
        return;
    }

    $allIds = $this->confirm('Do you want to process all IDs in the model?');
    $overwrite = $this->confirm('Do you want to overwrite all embeddings?');

    if ($allIds) {
        $ids = $model::pluck('id');
    } else {
        $ids = [$this->ask('What is the id of the item?')];
    }

    foreach ($ids as $id) {
        $textContent = "";

        $modelInstance = $model::find($id);

        if (!$modelInstance) {
            $this->error("No instance of {$modelClass} with id {$id} was found.");
            continue;
        } else {
            // Get the 'title' and 'list_description' properties
            $type = $modelInstance->type ? $modelInstance->subtype : '';
            $title = $modelInstance->title;
            $listDescription = $modelInstance->list_description ?? '';
            $short_description = $modelInstance->short_description ?? '';
            $short_intro_copy = $modelInstance->short_intro_copy ?? '';
            $hero_image_caption = $modelInstance->hero_image_caption ?? '';
            $textContent .= 'Content Type: ' .$type . ' Title: ' . $title . ' Description: ' . $listDescription. ' Short Description: ' . $short_description . ' Intro Copy: ' . $short_intro_copy . ' Image Caption: ' . $hero_image_caption;
        }

        $existingEmbedding = Embedding::where('model_type', $morphedModel)
        ->where('model_id', $id)
        ->first();

        if (!$overwrite && $existingEmbedding) {
            $this->info("An embedding already exists for model_type {$morphedModel} and model_id {$id}.");
            continue;
        }
        // Get all blocks associated with the model class and ID
        $blocks = Block::where('blockable_type', $morphedModel)
            ->where('blockable_id', $id)
            ->orderBy('position')
            ->get();

        if ($blocks->isEmpty()) {
            $this->error("No blocks associated with class {$modelClass} and id {$id} were found.");
            continue;
        }

        foreach ($blocks as $block) {
            // Get the 'content' field
            $content = $block->content;

            // Check if the 'paragraph' property exists in the 'content'
            if (isset($content['paragraph'])) {
                // Get the 'paragraph' property's content
                $paragraphBlock = $content['paragraph'];

                // Append the paragraph content to the allParagraphs string
                $textContent .= $paragraphBlock;
            }
        }

        // Dump the merged paragraph contents
        $textContent = strip_tags($textContent);

        // Add the model data to the data array
        $embeddingService = new EmbeddingService();
        $response = $embeddingService->getEmbeddings($textContent);

        if (isset($response['data'][0]['embedding'])) {
            $embeddingsData = $response['data'][0]['embedding'];
            $embeddings = new Vector($embeddingsData);

        } else {
            $this->error("The response does not have the expected structure.");
            continue;
        }

        Embedding::updateOrCreate(
            ['model_type' => $morphedModel, 'model_id' => $id], // Conditions to match
            ['embedding' => $embeddings] // Data to update or create with
        );
    
        $this->info("Embedding has been run on {$modelClass} with id {$id}.");
    }
});

Artisan::command('search', function () {
    $input = $this->ask('Enter search');
    $threshold = $this->ask('Enter threshold');

    $semanticSearchHelper = new SearchService(new EmbeddingService());

    $results = $semanticSearchHelper->search($input, $threshold);
    return $results;
});
