<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use App\Libraries\AIServices\VectorEmbeddingService as EmbeddingService;

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
    if (!class_exists("\\App\\Models\\$modelClass")) {
        $this->error("The class {$modelClass} does not exist.");
        return;
    }
    $id = $this->ask('What is the id of the item?');

    $model = $modelClass::find($id);

    if (!$model) {
        $this->error("No model of class {$modelClass} with id {$id} was found.");
        return;
    }

    $data = [];

    // Add the model data to the data array
    $embeddingService = new EmbeddingService();
    $response = $embeddingService->getEmbeddings($data);

    $embeddings = json_decode($response->getContent())->data[0]->embedding;

    // Save the embeddings to the Embeddings table
    $embedding = new \App\Models\Embedding();
    $embedding->model_id = $id;
    $embedding->model_type = $modelClass;
    $embedding->embeddings = $embeddings;
    $embedding->save();

    $this->info("Embedding has been run on {$modelClass} with id {$id}.");
});