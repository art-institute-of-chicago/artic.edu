<?php

namespace App\Libraries\AIServices;

use App\Libraries\AIServices\VectorEmbeddingService;
use App\Models\Embedding;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\DB;

class SemanticSearchService
{
    protected $vectorEmbeddingService;

    public function __construct(VectorEmbeddingService $vectorEmbeddingService)
    {
        $this->vectorEmbeddingService = $vectorEmbeddingService;
    }

    public function search($input)
    {
        // Get the vector for the input
        $vectorData = $this->vectorEmbeddingService->getEmbeddings($input);

        // Check if the vector data is valid and contains an embedding
        if (!isset($vectorData['data'][0]['embedding'])) {
            throw new \Exception('Invalid vector data');
        }

        $vector = $vectorData['data'][0]['embedding'];

        // Convert the vector to a string and enclose it in square brackets
        $vectorString = '[' . implode(',', $vector) . ']';

        // Query the Embeddings table for nearest neighbors
        $query = "SELECT * FROM Embeddings ORDER BY embedding <-> vector('{$vectorString}')";
        $results = DB::select($query);

        $items = [];
        foreach ($results as $result) {
            $morphedClass = $result->model_type;
            $modelClass = Relation::getMorphedModel($morphedClass);
            $modelId = $result->model_id;
            $model = $modelClass::find($modelId);
            if ($model) {
                $items[] = $model;
            }
        }
    
        return ['items' => $items, 'input' => $input];
    }
}