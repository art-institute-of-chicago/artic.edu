<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Api\ExhibitionRepository;
use App\Libraries\Search\ExhibitionHistoryService;
use App\Models\Api\Exhibition;
use App\Models\Page;
use App\Libraries\SchemaOrg\SchemaMapper;

class ExhibitionHistoryController extends FrontController
{
    public const PER_PAGE = 20;
    protected $apiRepository;

    public function __construct(ExhibitionRepository $repository)
    {
        $this->apiRepository = $repository;

        parent::__construct();
    }

    public function index(Request $request, ExhibitionHistoryService $service)
    {
        $page = Page::forType('Exhibition History')->firstOrFail();

        $activeYear = $service->activeYear();
        $decades = $service->decades();
        $years = $service->years();

        $exhibitions = $this->apiRepository->history($activeYear, request()->get('q'), self::PER_PAGE);

        // If we have no results, try to find them across the entire archive
        if ($exhibitions->isEmpty()) {
            $extraResults = $this->apiRepository->searchApi(request('q'), self::PER_PAGE);
        }

        $titles = array_filter([
            'Exhibition History',
            request('year'),
            request('page') ? 'Page ' . request('page') : null,
        ]);

        $this->seo->setTitle(implode(', ', $titles));

        if (request('q')) {
            $this->seo->nofollow = true;
            $this->seo->noindex = true;
        }

        $viewData = [
            'page' => $page,
            'years' => $years,
            'decades' => $decades,
            'activeYear' => $activeYear,
            'decade_prompt' => $service->getDecadePrompt(),
            'exhibitions' => $exhibitions,
            'extraResults' => $extraResults ?? null
        ];

        return view('site.exhibitionHistory', $viewData);
    }

    public function show($idSlug)
    {
        $resource = Exhibition::with('artworks')->find((int) $idSlug);

        $this->addJsonLd($resource);
    }

    /**
     * The schema.org definition for the given model.
     *
     * Shared defaults (e.g. inLanguage) come from the parent; page-specific
     * properties defined here are merged over them.
     *
     * @param mixed $model The model to map.
     *
     * @return array<string, mixed>
     */
    protected function jsonLdDefinition(mixed $model): array
    {
        $literal = static fn (mixed $value) => static fn () => $value;

        return array_merge(
            parent::jsonLdDefinition($model),
            [
                '@type' => 'ExhibitionEvent',
                'startDate' => SchemaMapper::iso('date_start'),
                'endDate' => SchemaMapper::iso('date_end'),
                'eventStatus' => $literal('https://schema.org/EventScheduled'),
                'eventAttendanceMode' => $literal('https://schema.org/OfflineEventAttendanceMode'),
                'url' => SchemaMapper::canonical('exhibitions.show', 'titleSlug'),
                'organizer' => SchemaMapper::orgRef(),
                'location' => static function ($m, $mapper) {
                    try {
                        $gallery = $m->gallery_title ?? null;
                    } catch (\Throwable $e) {
                        $gallery = null;
                    }

                    if (empty($gallery)) {
                        return null;
                    }

                    return [
                        '@type' => 'Place',
                        'name' => $gallery,
                        'address' => $mapper->museumAddress(),
                        'containedInPlace' => ['@id' => 'https://www.artic.edu/#organization'],
                    ];
                },
            ]
        );
    }
}
