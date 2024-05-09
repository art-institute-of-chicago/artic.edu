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

    $modelClass = $this->ask('What is the item\'s model?');
    $modelClass = Str::ucfirst(Str::singular($modelClass));
    $model = "\\App\\Models\\$modelClass";
    $morphedModel = app($model)->getMorphClass();
    
    if (!class_exists($model)) {
        $this->error("The class {$modelClass} does not exist.");
        return;
    }
    
    $id = $this->ask('What is the id of the item?');
    
    // Get the morph map key for the model class

    // Get all blocks associated with the model class and ID
    $blocks = Block::where('blockable_type', $morphedModel)
        ->where('blockable_id', $id)
        ->orderBy('position')
        ->get();

    if ($blocks->isEmpty()) {
        $this->error("No blocks associated with class {$modelClass} and id {$id} were found.");
        return;
    }

    $textContent = "";

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

    // Check if the response has the expected structure
    if (isset($response['data'][0]['embedding'])) {
        $embeddingsData = $response['data'][0]['embedding'];
        $embeddings = new Vector($embeddingsData);
    } else {
        $this->error("The response does not have the expected structure.");
        return;
    }
    
    // Save the embeddings to the Embeddings table
    $embedding = new Embedding();
    $embedding->model_id = $id;
    $embedding->model_type = $morphedModel;
    $embedding->embedding = $embeddings;
    $embedding->save();

    $this->info("Embedding has been run on {$modelClass} with id {$id}.");
});

Artisan::command('search', function () {
    $input = $this->ask('Enter search');
    $threshold = $this->ask('Enter threshold');

    $semanticSearchHelper = new SearchService(new EmbeddingService());

    $results = $semanticSearchHelper->search($input, $threshold);
    return $results;
});