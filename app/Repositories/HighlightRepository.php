<?php

namespace App\Repositories;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use App\Models\Highlight;
use App\Models\Api\Search;
use App\Repositories\Behaviors\HandleApiRelations;
use App\Repositories\Behaviors\HandleApiBlocks;
use App\Repositories\Behaviors\HandleFeaturedRelated;
use App\Repositories\Behaviors\HandleMagazine;
use App\Repositories\Behaviors\HandleAuthors;
use Illuminate\Support\Collection;

class HighlightRepository extends ModuleRepository
{
    use HandleSlugs, HandleRevisions, HandleMedias, HandleBlocks, HandleApiBlocks, HandleApiRelations, HandleMagazine, HandleFeaturedRelated, HandleAuthors {
        HandleApiBlocks::getBlockBrowsers insteadof HandleBlocks;
    }

    protected $morphType = 'highlights';

    public function __construct(Highlight $model)
    {
        $this->model = $model;
    }

    public function getHighlightTypeList(): Collection
    {
        return collect($this->model::$highlightTypes);
    }

    public function hydrate(TwillModelContract $object, array $fields): TwillModelContract
    {
        $this->hydrateBrowser($object, $fields, 'events', 'position', 'Event');

        return parent::hydrate($object, $fields);
    }

    public function afterSave(TwillModelContract $object, array $fields): void
    {
        $object->siteTags()->sync($fields['siteTags'] ?? []);
        $object->categories()->sync($fields['categories'] ?? []);

        parent::afterSave($object, $fields);
    }

    /**
     * Show data, moved here to allow preview
     */
    public function getShowData($item, $slug = null, $previewPage = null): array
    {
        return [
            'contrastHeader' => $item->present()->contrastHeader,
            'item' => $item,
        ];
    }

    public function searchApi($string, $perPage = null)
    {
        $search = Search::query()->search($string)->published()->notUnlisted()->resources(['highlights']);

        $results = $search->getSearch($perPage);

        return $results;
    }

    public function getFurtherReadingTitle($item): string
    {
        if ($this->isInMagazine($item) && $item->is_unlisted) {
            return 'Also in this Issue';
        }

        return 'Further Reading';
    }

    public function getFurtherReadingItems($item)
    {
        if ($item->is_in_magazine && $item->is_unlisted) {
            return $this->getAlsoInThisIssue($item);
        }
    }
}
