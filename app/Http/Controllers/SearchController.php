<?php

namespace App\Http\Controllers;

use App\Models\Api\Artwork;
use App\Models\Api\Artist;
use App\Models\Api\Search as GeneralSearch;
use App\Models\Api\Exhibition;

use App\Repositories\Api\ArtworkRepository;
use App\Repositories\Api\ArtistRepository;
use App\Repositories\Api\SearchRepository;
use App\Repositories\Api\ExhibitionRepository;
use App\Repositories\ArticleRepository;
use App\Repositories\PublicationsRepository;
use App\Repositories\EventRepository;
use App\Repositories\GenericPageRepository;
use App\Repositories\PressReleaseRepository;
use App\Repositories\ResearchGuideRepository;
use App\Repositories\InteractiveFeatureRepository;

use App\Http\Controllers\StaticsController;

use App\Libraries\Search\CollectionService;

use Illuminate\Support\Str;

use LakeviewImageService;

class SearchController extends BaseScopedController
{
    const ALL_PER_PAGE = 5;
    const ALL_PER_PAGE_ARTWORKS = 8;
    const ALL_PER_PAGE_EXHIBITIONS = 4;
    const ALL_PER_PAGE_DIGITAL_LABELS = 4;
    const ALL_PER_PAGE_EVENTS = 4;
    const ALL_PER_PAGE_PAGES = 3;
    const ALL_PER_PAGE_ARTICLES = 4;
    const ALL_PER_PAGE_PUBLICATIONS = 4;

    const ARTWORKS_PER_PAGE = 20;
    const PAGES_PER_PAGE = 20;
    const EXHIBITIONS_PER_PAGE = 20;
    const DIGITAL_LABELS_PER_PAGE = 20;
    const ARTICLES_PER_PAGE = 20;
    const EVENTS_PER_PAGE = 20;
    const PUBLICATIONS_PER_PAGE = 20;
    const ARTISTS_PER_PAGE = 30;
    const AUTOCOMPLETE_PER_PAGE = 10;
    const ALL_PER_PAGE_INTERACTIVEFEATURES = 10;

    protected $artworksRepository;
    protected $artistsRepository;
    protected $searchRepository;
    protected $exhibitionsRepository;
    protected $articlesRepository;
    protected $interactiveFeatureRepository;

    public function __construct(
        ArtworkRepository $artworks,
        ArtistRepository $artists,
        SearchRepository $search,
        ExhibitionRepository $exhibitions,
        ArticleRepository $articles,
        PublicationsRepository $publications,
        EventRepository $events,
        GenericPageRepository $pages,
        ResearchGuideRepository $researchGuide,
        PressReleaseRepository $press,
        InteractiveFeatureRepository $interactiveFeature
    ) {
        $this->artworksRepository = $artworks;
        $this->artistsRepository = $artists;
        $this->searchRepository = $search;
        $this->exhibitionsRepository = $exhibitions;
        $this->articlesRepository = $articles;
        $this->eventsRepository = $events;
        $this->publicationsRepository = $publications;
        $this->pagesRepository = $pages;
        $this->researchGuideRepository = $researchGuide;
        $this->pressRepository = $press;
        $this->interactiveFeatureRespository = $interactiveFeature;

        parent::__construct();
    }


    public function index()
    {
        $this->seo->setTitle('Search');

        // General search to get featured elements and general metadata.
        $general = $this->searchRepository->forSearchQuery(request('q'), 0);
        $links = $this->buildSearchLinks($general, 'all');

        // Specific elements search. We run separate queries because we want to ensure elements
        // in all sections. A general search sorting might cause empty categories.
        $publications               = $this->publicationsRepository->searchApi(request('q'), self::ALL_PER_PAGE_PUBLICATIONS);
        $articles                   = $this->articlesRepository->searchApi(request('q'), self::ALL_PER_PAGE_ARTICLES);
        $artworks                   = $this->collection()->perPage(self::ALL_PER_PAGE_ARTWORKS)->results();
        $artists                    = $this->artistsRepository->forSearchQuery(request('q'), self::ALL_PER_PAGE);
        $exhibitions                = $this->exhibitionsRepository->searchApi(request('q'), self::ALL_PER_PAGE_EXHIBITIONS);
        $events                     = $this->eventsRepository->searchApi(request('q'), self::ALL_PER_PAGE_EVENTS);
        $pages                      = $this->pagesRepository->searchApi(request('q'), self::ALL_PER_PAGE_PAGES);
        $guides                     = $this->researchGuideRepository->searchApi(request('q'), self::ALL_PER_PAGE_EVENTS);
        $press                      = $this->pressRepository->searchApi(request('q'), self::ALL_PER_PAGE_EVENTS);
        $interactiveFeatures        = $this->interactiveFeatureRespository->searchIn(request('q'))->pagiante(self::ALL_PER_PAGE_INTERACTIVEFEATURES);

        return view('site.search.index', [
            'featuredResults' => $general->where('is_boosted', true),
            'artworks' => $artworks,
            'artists'  => $artists,
            'articles' => $articles,
            'events'   => $events,
            'pages'    => $pages,
            'exhibitions'  => $exhibitions,
            'interactiveFeature'  => $interactiveFeatures,
            'publications' => $publications,
            'pressReleases'  => $press,
            'researchGuides' => $guides,
            'allResultsView' => false,
            'searchResultsTypeLinks' => $links
        ]);
    }

    public function collectionautocomplete()
    {
        $collection = GeneralSearch::search(request('q'))
            ->resources(['artworks', 'exhibitions', 'artists', 'agents', 'events', 'articles', 'digital-catalogs', 'printed-catalogs'])
            ->getSearch(self::AUTOCOMPLETE_PER_PAGE);

        foreach($collection as &$item) {
            switch ((new \ReflectionClass($item))->getShortName()) {
                case 'Artwork':
                    $item->url = route('artworks.show', $item);
                    $item->section = 'Artworks';
                    break;
                case 'Exhibition':
                    $item->url = route('exhibitions.show', $item);
                    $item->section = 'Exhibitions and Events';
                    break;
                case 'DigitalLabel':
                    $item->url = route('interactiveFeatures.show', $item);
                    $item->section = 'Interactive Features';
                    break;
                case 'Artist':
                    $item->url = route('artists.show', $item);
                    $item->section = 'Artists';
                    break;
                case 'Event':
                    $item->url = route('events.show', $item);
                    $item->section = 'Events';
                    break;
                case 'Article':
                    $item->url = route('articles.show', $item);
                    $item->section = 'Articles';
                    break;
                case 'DigitalPublication':
                    $item->url = route('collection.publications.digital-publications.show', $item);
                    $item->section = 'Digital Publications';
                    break;
                case 'PrintedPublication':
                    $item->url = route('collection.publications.printed-publications.show', $item);
                    $item->section = 'Print Publications';
                    break;
            }

            $item->text = $item->title;
        }

        return view('partials/_autocomplete', [
            'term' => request('q'),
            'resultCount' => $collection->total(),
            'items' => $collection,
            'seeAllUrl' => route('search', ['q' => request('q')])
        ]);
    }

    public function artworks()
    {
        $this->seo->setTitle('Search');

        $general  = $this->searchRepository->forSearchQuery(request('q'), 0);

        $artworks      = $this->collection()->perPage(self::ARTWORKS_PER_PAGE)->results();
        $filters       = $this->collection()->generateFilters();
        $activeFilters = $this->collection()->activeFilters();

        $links = $this->buildSearchLinks($general, 'artworks');

        return view('site.search.index', [
            'artworks' => $artworks,
            'allResultsView' => true,
            'searchResultsTypeLinks' => $links,
            'filterCategories' => $filters,
            'activeFilters'    => $activeFilters
        ]);
    }

    /**
     * Implementation for BaseScopedController.
     * This is the beginning for the chain of scoped results
     * The remaining scopes are applied following the $scopes
     * array defined at the controller
     *
     */
    protected function beginOfAssociationChain()
    {
        // Define base entity
        $collectionService = new CollectionService;

        // Implement default filters and scopes
        $collectionService->resources(['artworks'])
            ->allAggregations()
            ->forceEndpoint('search');

        return $collectionService;
    }

    public function exhibitions()
    {
        $this->seo->setTitle('Search');

        $general     = $this->searchRepository->forSearchQuery(request('q'), 0);
        $exhibitions = $this->exhibitionsRepository->searchApi(request('q'), self::EXHIBITIONS_PER_PAGE, request('time'));

        $links = $this->buildSearchLinks($general, 'exhibitions');

        return view('site.search.index', [
            'exhibitions' => $exhibitions,
            'allResultsView' => true,
            'searchResultsTypeLinks' => $links,
        ]);
    }

    public function interactiveFeatures()
    {
        $this->seo->setTitle('Search');

        $general = $this->searchRepository->forSearchQuery(request('q'), 0);

        $links = $this->buildSearchLinks($general, 'interactive-features');

        return view('site.search.index', [
            'digitalLabels' => $digitalLabels,
            'allResultsView' => true,
            'searchResultsTypeLinks' => $links,
        ]);
    }

    public function artists()
    {
        $this->seo->setTitle('Search');

        $general = $this->searchRepository->forSearchQuery(request('q'), 0);
        $artists = $this->artistsRepository->forSearchQuery(request('q'), self::ARTISTS_PER_PAGE);

        $links = $this->buildSearchLinks($general, 'artists');

        return view('site.search.index', [
            'artists' => $artists,
            'allResultsView' => true,
            'searchResultsTypeLinks' => $links,
        ]);
    }

    public function articles()
    {
        $this->seo->setTitle('Search');

        $general  = $this->searchRepository->forSearchQuery(request('q'), 0);
        $articles = $this->articlesRepository->searchApi(request('q'), self::ARTICLES_PER_PAGE);

        $links = $this->buildSearchLinks($general, 'articles');

        return view('site.search.index', [
            'articles' => $articles,
            'allResultsView' => true,
            'searchResultsTypeLinks' => $links,
        ]);
    }

    public function events()
    {
        $this->seo->setTitle('Search');

        $general = $this->searchRepository->forSearchQuery(request('q'), 0);
        $events  = $this->eventsRepository->searchApi(request('q'), self::EVENTS_PER_PAGE);

        $links = $this->buildSearchLinks($general, 'events');

        return view('site.search.index', [
            'events' => $events,
            'allResultsView' => true,
            'searchResultsTypeLinks' => $links,
        ]);
    }

    public function pages()
    {
        $this->seo->setTitle('Search');

        $general = $this->searchRepository->forSearchQuery(request('q'), 0);
        $pages   = $this->pagesRepository->searchApi(request('q'), self::PAGES_PER_PAGE);

        $links = $this->buildSearchLinks($general, 'pages');

        return view('site.search.index', [
            'pages' => $pages,
            'allResultsView' => true,
            'searchResultsTypeLinks' => $links,
        ]);
    }

    public function researchGuides()
    {
        $this->seo->setTitle('Search');

        $general = $this->searchRepository->forSearchQuery(request('q'), 0);
        $guides  = $this->researchGuideRepository->searchApi(request('q'), self::ALL_PER_PAGE_EVENTS);

        $links = $this->buildSearchLinks($general, 'research-guides');

        return view('site.search.index', [
            'researchGuides' => $guides,
            'allResultsView' => true,
            'searchResultsTypeLinks' => $links,
        ]);
    }

    public function pressReleases()
    {
        $this->seo->setTitle('Search');

        $general = $this->searchRepository->forSearchQuery(request('q'), 0);
        $press   = $this->pressRepository->searchApi(request('q'), self::ALL_PER_PAGE_EVENTS);

        $links = $this->buildSearchLinks($general, 'press-releases');

        return view('site.search.index', [
            'pressReleases' => $press,
            'allResultsView' => true,
            'searchResultsTypeLinks' => $links,
        ]);
    }

    public function publications()
    {
        $this->seo->setTitle('Search');

        $general = $this->searchRepository->forSearchQuery(request('q'), 0);
        $publications = $this->publicationsRepository->searchApi(request('q'), self::PUBLICATIONS_PER_PAGE);

        $links = $this->buildSearchLinks($general, 'publications');

        return view('site.search.index', [
            'publications' => $publications,
            'allResultsView' => true,
            'searchResultsTypeLinks' => $links,
        ]);
    }

    protected function buildSearchLinks($all, $active = 'all')
    {
        $links = [];
        $aggregations = $all->getMetadata('aggregations')->types->buckets;

        array_push($links, $this->buildLabel('All', $all->getMetadata('pagination')->total, route('search', ['q' => request('q')]), $active == 'all'));

        if (extractAggregation($aggregations, 'agents')) {
            array_push($links, $this->buildLabel('Artist', extractAggregation($aggregations, 'agents'), route('search.artists', ['q' => request('q')]), $active == 'artists'));
        }
        if (extractAggregation($aggregations, 'generic-pages')) {
            array_push($links, $this->buildLabel('Pages', extractAggregation($aggregations, 'generic-pages'), route('search.pages', ['q' => request('q')]), $active == 'generic-pages'));
        }
        if (extractAggregation($aggregations, 'artworks')) {
            array_push($links, $this->buildLabel('Artwork', extractAggregation($aggregations, 'artworks'), route('search.artworks', ['q' => request('q')]), $active == 'artworks'));
        }
        if (extractAggregation($aggregations, 'exhibitions')) {
            array_push($links, $this->buildLabel('Exhibitions', extractAggregation($aggregations, 'exhibitions'), route('search.exhibitions', ['q' => request('q')]), $active == 'exhibitions'));
        }
        if (extractAggregation($aggregations, 'events')) {
            array_push($links, $this->buildLabel('Events', extractAggregation($aggregations, 'events'), route('search.events', ['q' => request('q')]), $active == 'events'));
        }
        if (extractAggregation($aggregations, 'articles')) {
            array_push($links, $this->buildLabel('Articles', extractAggregation($aggregations, 'articles'), route('search.articles', ['q' => request('q')]), $active == 'articles'));
        }
        if (extractAggregation($aggregations, ['digital-catalogs', 'printed-catalogs'])) {
            array_push($links, $this->buildLabel('Publications', extractAggregation($aggregations, ['digital-catalogs', 'printed-catalogs']), route('search.publications', ['q' => request('q')]), $active == 'publications'));
        }
        if (extractAggregation($aggregations, ['research-guides','educator-resources'])) {
            array_push($links, $this->buildLabel('Resources', extractAggregation($aggregations, ['research-guides', 'educator-resources']), route('search.research-guides', ['q' => request('q')]), $active == 'research-guides'));
        }
        if (extractAggregation($aggregations, 'press-releases')) {
            array_push($links, $this->buildLabel('Press Releases', extractAggregation($aggregations, 'press-releases'), route('search.press-releases', ['q' => request('q')]), $active == 'press-releases'));
        }

        return $links;
    }

    protected function buildLabel($name, $total, $href, $active) {
        return [
            'label' => ($name == 'All' ? 'All' : Str::plural($name, $total)),
            'href' => $href,
            'active' => $active
        ];
    }

}
