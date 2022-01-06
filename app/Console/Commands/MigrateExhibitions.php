<?php

namespace App\Console\Commands;

use App\Models\Api\Search;
use App\Models\Exhibition;
use App\Models\Api\Exhibition as ApiExhibition;
use App\Repositories\ExhibitionRepository as AugmentedRepository;
use App\Repositories\Api\ExhibitionRepository as ApiRepository;

use Illuminate\Console\Command;

class MigrateExhibitions extends Command
{
    protected $signature = 'migrate:exhibitions';

    protected $description = 'Copy `short_description` to new website';

    private $apiRepository;
    private $augmentedRepository;

    public function handle()
    {
        ini_set('memory_limit', '-1');

        $ids = Search::query()->resources(['exhibitions'])->rawSearch([
            'exists' => [
                'field' => 'short_description',
            ],
        ])->limit(500)->get(['id'])->pluck('id');

        foreach ($ids as $id) {
            $this->handleItem($id);
        }
    }

    /**
     * Handle item to migrate
     * @see BaseApiController::augment
     */
    private function handleItem($id)
    {
        $item = $this->getRepository()->where('datahub_id', '=', $id)->first();

        if (!isset($item) || isset($item->list_description)) {
            return;
        }

        // Load data from the API
        $apiItem = $this->getApiRepository('Exhibition')->getById($id);

        if (!method_exists($apiItem, 'toArray')) {
            $this->error('Errored: ' . $id);

            return;
        }

        // Force the datahub_id field
        $data = $apiItem->toArray() + ['datahub_id' => $id];

        // Find if we have an existing model before creating an augmented one
        $item = $this->getRepository()->firstOrCreate(['datahub_id' => $id], $data);

        if (empty($item->list_description)) {
            $item->list_description = trim($item->getApiModelFilled()->short_description);
            $item->published = 1;
            $item->save();
            $this->info($item->list_description);
        } else {
            $this->warn($item->list_description);
        }

        usleep(4000000);
    }

    /**
     * Get API repository
     * @see BaseApiController::augment
     */
    private function getApiRepository()
    {
        return $apiRepository ?? $apiRepository = (new ApiRepository(new ApiExhibition()));
    }

    private function getRepository()
    {
        return $augmentedRepository ?? $augmentedRepository = (new AugmentedRepository(new Exhibition()));
    }
}
