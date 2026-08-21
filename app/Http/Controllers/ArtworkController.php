<?php

namespace App\Http\Controllers;

use App\Repositories\Api\ArtworkRepository;
use App\Models\Api\Artwork;
use App\Helpers\GtmHelpers;
use App\Libraries\ArtworkSizeComparisonService;
use App\Libraries\RecentlyViewedService;
use App\Libraries\Search\CollectionService;
use App\Libraries\ExploreFurther\ArtworkService as ExploreFurther;
use App\Models\Hour;
use App\Libraries\SchemaOrg\SchemaMapper;
use Illuminate\Support\Facades\Response;

class ArtworkController extends BaseScopedController
{
    public const PER_PAGE = 20;

    protected $artworkRepository;

    public function __construct(ArtworkRepository $repository)
    {
        $this->artworkRepository = $repository;
        parent::__construct();
    }

    public function show($id, $slug = null)
    {
        try {
            $item = Artwork::query()
                ->include(['artist_pivots', 'place_pivots', 'dates'])
                ->findOrFail((int) $id);
        } catch (\Throwable $e) {
            $item = Artwork::query()->forceEndpoint('deaccession')
                ->include(['artist_pivots', 'place_pivots', 'dates'])
                ->findOrFail((int) $id);
        }

        $canonicalPath = route('artworks.show', ['id' => $item->id, 'slug' => $item->titleSlug]);

        if ($canonicalRedirect = $this->getCanonicalRedirect($canonicalPath)) {
            return $canonicalRedirect;
        }

        $this->seo->setTitle($item->meta_title ?: $item->title);
        $this->seo->setDescription($item->meta_description ?: $item->fullArtist);
        $this->seo->setImage($item->imageFront('hero'), 843);
        $this->seo->usesImgix = false;

        if ($item->mainArtist && $item->mainArtist->isNotEmpty()) {
            $this->seo->citationAuthor[] = $item->mainArtist->first()->title;
        }

        if ($item->artists && $item->artists->isNotEmpty()) {
            $item->artists->each(function ($artist) {
                $this->seo->citationAuthor[] = $artist->title;
            });
        }

        // Start building data for output to view
        $viewData = [
            'autoRelated' => $this->getAutoRelated($item),
            'featuredRelated' => $this->getFeatureRelated($item),
            'item' => $item,
            'model3d' => $item->model3d,
            'contrastHeader' => $item->present()->contrastHeader,
            'borderlessHeader' => $item->present()->borderlessHeader,
            'primaryNavCurrent' => 'collection',
            'canonicalUrl' => $canonicalPath,
            'pageMetaData' => $this->getPageMetaData($item),
            'hour' => Hour::today()->first(),
        ];

        // Build Explore further module
        if (!$item->is_deaccessioned) {
            $exploreFurther = new ExploreFurther($item);

            $viewData = array_merge($viewData, [
                'exploreFurtherTags' => $exploreFurther->tags(),
                'exploreFurther' => $exploreFurther->collection(request()->all()),
                'exploreFurtherAllTags' => $exploreFurther->allTags(request()->all()),
                'exploreFurtherCollectionUrl' => $exploreFurther->collectionUrl(request()->all()),
            ]);
        }

        $this->addJsonLd($item);
        $this->addBreadcrumbs([
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Artworks', 'url' => route('collection')],
            ['label' => $item->title],
        ]);

        return view('site.artworkDetail', $viewData);
    }

    public function size($id)
    {
        $item = Artwork::query()->findOrFail((int) $id);

        $dimension = collect($item->dimensions_detail)
            ->map(fn ($detail) => (array) $detail)
            ->first(fn ($detail) => !empty($detail['width']) && !empty($detail['height']));

        if (!$dimension) {
            abort(404);
        }

        $image = (new ArtworkSizeComparisonService())->generate($dimension['width'], $dimension['height']);

        return Response::make($image, 200, ['Content-Type' => 'image/jpeg']);
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
        $collectionService = new CollectionService();

        // Implement default filters and scopes
        $collectionService->resources(['artworks'])
            ->allAggregations()
            ->forceEndpoint('search');

        return $collectionService;
    }

    public function recentlyViewed(RecentlyViewedService $service)
    {
        $recentlyViewed = $service->getArtworks();
        $suggestedThemes = $service->getThemes();

        $view['html'] = view('site.shared._recentlyViewed', [
            'artworks' => $recentlyViewed,
            'interestedThemes' => $suggestedThemes
        ])->render();

        return $view;
    }

    public function clearRecentlyViewed(RecentlyViewedService $service)
    {
        $service->clear();

        return redirect()->back();
    }

    public function addRecentlyViewed(RecentlyViewedService $service, $idSlug, $slug = null)
    {
        $item = Artwork::query()->findOrFail((int) $idSlug);

        if (empty($item)) {
            abort(404);
        } else {
            // Add artwork to the Recently Viewed collection
            $service->addArtwork($item);
        }

        return response()->json();
    }

    public function exploreFurther($id)
    {
        try {
            $item = Artwork::query()
                ->include(['artist_pivots'])
                ->findOrFail((int) $id);
        } catch (\Throwable $e) {
            $item = Artwork::query()->forceEndpoint('deaccession')
                ->include(['artist_pivots'])
                ->findOrFail((int) $id);
        }

        $exploreFurther = new ExploreFurther($item);

        if (request()->has('ef-all_ids')) {
            $view['html'] = view('site.shared._exploreFurtherTags', [
                'tags' => $exploreFurther->allTags(request()->all()),
            ])->render();
        } else {
            $view['html'] = view('site.shared._exploreFurther', [
                'artworks' => $exploreFurther->collection(request()->all()),
            ])->render();
        }

        return $view;
    }

    protected function setPageMetaData($item)
    {
        return GtmHelpers::getMetaDataForArtwork($item);
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
        $artworkDimensions = static function ($m) {
            $details = $m?->dimensions_detail ?? null;

            if (!is_array($details) || empty($details)) {
                return null;
            }

            foreach ($details as $detail) {
                $detail = is_array($detail) ? $detail : (array) $detail;

                $unitCode = match (strtolower((string) ($detail['unit'] ?? ''))) {
                    'cm' => 'CMT',
                    'in' => 'INH',
                    default => null,
                };

                $dimensions = [];

                foreach (['width', 'height', 'depth'] as $key) {
                    $value = $detail[$key] ?? null;

                    if (!is_numeric($value)) {
                        continue;
                    }

                    $quantitativeValue = [
                        '@type' => 'QuantitativeValue',
                        'value' => (float) $value,
                    ];

                    if ($unitCode !== null) {
                        $quantitativeValue['unitCode'] = $unitCode;
                    }

                    $dimensions[$key] = $quantitativeValue;
                }

                if (!empty($dimensions)) {
                    return $dimensions;
                }
            }

            return null;
        };

        $quantitativeValue = static function (string $key) use ($artworkDimensions) {
            return static fn ($m) => ($artworkDimensions($m) ?? [])[$key] ?? null;
        };

        // URI from ULAN (agent-specific) or Getty AAT (generic cultures).
        $creators = static function ($m) {
            $artists = $m->artists ?? null;

            $nodes = [];

            if ($artists) {
                foreach ($artists as $artist) {
                    $name = $artist->title ?? null;

                    if (empty($name)) {
                        continue;
                    }

                    if (!SchemaMapper::isGroupAgent($artist)) {
                        $nodes[] = ['@type' => 'Person', 'name' => $name];
                        continue;
                    }

                    $node = ['@type' => 'Organization', 'name' => $name];
                    $node['additionalType'] = !empty($artist->ulan_id)
                        ? 'https://vocab.getty.edu/ulan/' . $artist->ulan_id
                        : 'http://vocab.getty.edu/aat/300387177';
                    $nodes[] = $node;
                }
            }

            if (empty($nodes)) {
                $artistTitle = $m->artist_title ?? null;

                if (empty($artistTitle)) {
                    return null;
                }

                $nodes[] = ['@type' => 'Person', 'name' => $artistTitle];
            }

            return $nodes;
        };

        return array_merge(
            parent::jsonLdDefinition($model),
            [
                '@type' => 'VisualArtwork',
                'alternateName' => 'main_reference_number',
                'dateCreated' => 'date_display',
                'artMedium' => 'medium_display',
                'size' => 'dimensions',
                'artform' => 'artwork_type_title',
                'locationCreated' => 'place_of_origin',
                'displayLocation' => 'gallery_title',
                'creditText' => 'credit_line',
                'url' => SchemaMapper::canonical('artworks.show', 'titleSlug'),
                'mainEntityOfPage' => SchemaMapper::canonical('artworks.show', 'titleSlug'),
                'thumbnailUrl' => static fn ($m, $mapper) => $mapper->thumbnailUrl(),
                'identifier' => static function ($m) {
                    $number = $m->main_reference_number ?? null;

                    if (!is_string($number) || $number === '') {
                        return null;
                    }

                    return [
                        '@type' => 'PropertyValue',
                        'propertyID' => 'main_reference_number',
                        'value' => $number,
                    ];
                },
                'artist' => $creators,
                'width' => $quantitativeValue('width'),
                'height' => $quantitativeValue('height'),
                'depth' => $quantitativeValue('depth'),
                'copyrightNotice' => 'copyright_notice',
                'license' => 'license',
                'keywords' => static function ($m) {
                    $keywords = collect(['subject_titles', 'style_titles', 'category_titles'])
                        ->flatMap(function ($field) use ($m) {
                            $values = $m->{$field} ?? null;

                            return is_array($values) ? $values : [];
                        })
                        ->filter(static fn ($value) => is_string($value) && $value !== '')
                        ->unique()
                        ->values();

                    return $keywords->isEmpty() ? null : $keywords->implode(', ');
                },
                'genre' => static function ($m) {
                    $genre = $m->classification_title ?? null;

                    if (empty($genre)) {
                        $titles = $m->classification_titles ?? null;

                        $genre = is_array($titles) ? ($titles[0] ?? null) : null;
                    }

                    return is_string($genre) && $genre !== '' ? $genre : null;
                },
                'isPartOf' => static function ($m) {
                    $department = $m->department_title ?? null;

                    if (!is_string($department) || $department === '') {
                        return null;
                    }

                    return [
                        '@type' => 'Collection',
                        'name' => $department,
                    ];
                },
                'encoding' => static function ($m) {
                    $id = $m->id ?? null;

                    if (empty($id)) {
                        return null;
                    }

                    return [
                        '@type' => 'DigitalDocument',
                        '@id' => 'https://api.artic.edu/api/v1/artworks/' . $id . '/manifest.json',
                        'encodingFormat' => 'application/ld+json',
                    ];
                },
                'creator' => $creators,
                'sameAs' => static function ($m) {
                    $id = $m->id ?? null;

                    if (empty($id)) {
                        return null;
                    }

                    return 'https://api.artic.edu/api/v1/artworks/' . $id;
                },
            ]
        );
    }
}
