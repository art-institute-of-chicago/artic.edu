<?php

namespace App\Libraries\AIServices;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VectorEmbeddingService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('AZURE_EMBEDDINGS_API_KEY');
    }
    public function getEmbeddings($data)
    {
        $embeddingsEndpoint = env('AZURE_EMBEDDINGS_ENDPOINT');
        $apiKey = $this->apiKey;
        $url = "{$embeddingsEndpoint}/openai/deployments/aic-embedding/embeddings?api-version=2024-02-01";

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ',
            'api-key' => $apiKey,
        ])->post($url, ['input' => $data]);

        if ($response->successful()) {
            return $response->json();
        }
    
        Log::error('Error fetching data from Azure', [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);
        throw new \Exception('Error fetching data from Azure');
    }
}