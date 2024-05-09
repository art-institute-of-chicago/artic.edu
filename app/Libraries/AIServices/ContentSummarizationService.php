<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ContentSummarizationService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('AZURE_SUMMARIZATION_API_KEY');
    }

    public function getSummarization($data)
    {
        $embeddingsEndpoint = env('AZURE_SUMMARIZATION_ENDPOINT');
        $response = Http::post($embeddingsEndpoint, $data);

        if ($response->successful()) {
            return $response->json();
        }

        // Handle error
        throw new \Exception('Error fetching data from Azure');
    }
}
