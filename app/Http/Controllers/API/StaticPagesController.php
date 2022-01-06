<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Aic\Hub\Foundation\AbstractModel;

class StaticPagesController extends BaseController
{
    protected $model = \App\Models\Page::class;
    protected $transformer = \App\Http\Transformers\StaticPageTransformer::class;

    protected function paginate($limit)
    {
        $offset = ((Request::input('page') ?? 1) - 1) * $limit;
        $pages = $this->getPageCollection();

        return (new LengthAwarePaginator(
            $pages->slice($offset, $limit)->values(),
            $pages->count(),
            $limit,
            intdiv($offset, $limit) + 1
        ))->setPath(request()->url());
    }

    protected function find($ids)
    {
        return $this->getPageCollection()->whereIn('id', is_array($ids) ? $ids : [$ids])->values();
    }

    private function getPageCollection()
    {
        $collection = Collection::make();

        collect(
            $this->getPages()
        )->map(function ($item) {
            return new class($item) extends AbstractModel {
            }; // For transform()
        })->each(function ($item) use ($collection) {
            $collection->push($item);
        });

        return $collection;
    }

    private function getPages()
    {
        return [
            [
                'id' => 1,
                'title' => 'Visit',
                'url' => route('visit', [], false),
            ],
            [
                'id' => 2,
                'title' => 'Events',
                'url' => route('events', [], false),
            ],
            [
                'id' => 3,
                'title' => 'Exhibitions',
                'url' => route('exhibitions', [], false),
            ],
            [
                'id' => 4,
                'title' => 'Upcoming Exhibitions',
                'url' => route('exhibitions.upcoming', [], false),
            ],
            [
                'id' => 5,
                'title' => 'Exhibition History',
                'url' => route('exhibitions.history', [], false),
            ],
            [
                'id' => 6,
                'title' => 'Educator Resource Finder',
                'url' => route('collection.resources.educator-resources', [], false),
            ],
            [
                'id' => 7,
                'title' => 'Print Publications',
                'url' => route('collection.publications.printed-publications', [], false),
            ],
            [
                'id' => 8,
                'title' => 'Digital Publications',
                'url' => route('collection.publications.digital-publications', [], false),
            ],
            [
                'id' => 9,
                'title' => 'Press Releases',
                'url' => route('about.press', [], false),
            ],
            [
                'id' => 10,
                'title' => 'Press Release Archive',
                'url' => route('about.press.archive', [], false),
            ],
            [
                'id' => 11,
                'title' => 'Articles',
                'url' => route('articles', [], false),
            ],
        ];
    }
}
