<?php

namespace App\Http\Controllers;

use App\Repositories\Api\ArtworkRepository;
use App\Models\Api\Artwork;
use App\Models\Api\CategoryTerm;
use App\Helpers\GtmHelpers;
use App\Libraries\ArtworkSectionService;
use App\Libraries\ArtworkSizeComparisonService;
use App\Libraries\RecentlyViewedService;
use App\Libraries\Search\CollectionService;
use App\Libraries\ExploreFurther\ArtworkService as ExploreFurther;
use App\Models\DigitalPublicationArticle;
use App\Models\Hour;
use App\Libraries\SchemaOrg\SchemaMapper;
use App\Models\AdCampaign;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Response;

class ArtworkController extends BaseScopedController
{
    public const PER_PAGE = 20;

    private const EXPLORE_MORE_TAG_LIMIT = 30;

    protected $artworkRepository;

    public function __construct(ArtworkRepository $repository)
    {
        $this->artworkRepository = $repository;
        parent::__construct();
    }

    /**
     * Find an artwork, falling back to the deaccession endpoint when the default lookup misses.
     */
    private function findArtwork(int $id, array $include)
    {
        try {
            return Artwork::query()
                ->include($include)
                ->findOrFail((int) $id);
        } catch (\Throwable $e) {
            return Artwork::query()->forceEndpoint('deaccession')
                ->include($include)
                ->findOrFail((int) $id);
        }
    }

    public function show(int $id, $slug = null)
    {
        $item = $this->findArtwork($id, ['artist_pivots', 'place_pivots', 'dates']);

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

        $relatedContent = $this->buildRelatedContent($item);
        $publications = $this->buildSectionItems($item, 'manualPublications', 'autoPublications', 'toggle_autopublications', fn ($publication) => $this->normalizePublicationItem($publication));
        $exhibitions = $this->buildSectionItems($item, 'manualExhibitions', 'autoExhibitions', 'toggle_autoexhibitions', fn ($exhibition) => $this->normalizeExhibitionItem($exhibition));
        $educatorResources = $this->buildSectionItems($item, 'manualEducatorResources', 'autoEducatorResources', 'toggle_autoeducator_resources', fn ($resource) => $resource);

        // Curated Multimedia entries: interactive features and digital explorers
        // render as listing cards, while layered image viewer blocks keep their
        // inline viewer and are therefore excluded from the cards.
        $multimediaItems = $item->getAugmentedModel()?->multimediaItems() ?? collect();
        $multimediaCards = $multimediaItems
            ->filter(fn ($multimediaItem) => in_array($multimediaItem['type'] ?? null, ['experiences', 'digitalExplorers'], true))
            ->map(fn ($multimediaItem) => $this->normalizeRelatedContentItem($multimediaItem['model'] ?? null))
            ->filter()
            ->values();
        $videoBlocks = $item->getAugmentedModel()?->blocks()->whereNull('parent_id')->where('type', 'video')->get() ?? collect();

        $viewData = [
            'autoRelated' => $this->getAutoRelated($item),
            'featuredRelated' => $this->getFeatureRelated($item),
            'relatedArtistPage' => $this->getRelatedArtistPage(
                $item,
                isset($item->toggle_autorelated) && !$item->toggle_autorelated
            ),
            'relatedContentItems' => $relatedContent['items'],
            'relatedContentTotal' => $relatedContent['total'],
            'publicationItems' => $publications['items'],
            'publicationTotal' => $publications['total'],
            'exhibitionItems' => $exhibitions['items'],
            'exhibitionTotal' => $exhibitions['total'],
            'educatorResourceItems' => $educatorResources['items'],
            'educatorResourceTotal' => $educatorResources['total'],
            'multimediaItems' => $multimediaItems,
            'multimediaCards' => $multimediaCards,
            'multimediaCardsTotal' => $multimediaCards->count(),
            // AUDIO (not scaffolded yet): add 'audioItems' => … here once the audio source/browser exists.
            'videoBlocks' => $videoBlocks,
            'item' => $item,
            'model3d' => $item->model3d,
            'contrastHeader' => $item->present()->contrastHeader,
            'borderlessHeader' => $item->present()->borderlessHeader,
            'primaryNavCurrent' => 'collection',
            'canonicalUrl' => $canonicalPath,
            'pageMetaData' => $this->getPageMetaData($item),
            'hour' => Hour::today()->first(),
            'advertisement' => AdCampaign::findPriorityForArtwork($item),
        ];

        // Build Explore further module
        if (!$item->is_deaccessioned) {
            $viewData = array_merge($viewData, $this->buildExploreMoreData($item));
        }

        $this->addJsonLd($item);
        $this->addBreadcrumbs([
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Artworks', 'url' => route('collection')],
            ['label' => $item->title],
        ]);

        return view('site.artworkDetail', $viewData);
    }

    private function buildExploreMoreData($item): array
    {
        $exploreFurther = new ExploreFurther($item);

        $styleTitle = $item->style_title ?: ($item->style_titles[0] ?? null);

        return [
            // Updating language based on FE - can update later
            'exploreMoreByArtist' => $this->exploreMore($exploreFurther, $item->artist_title, 'ef-artist_ids'),
            'exploreMoreByStyle' => $this->exploreMore($exploreFurther, $styleTitle, 'ef-style_ids'),
            'exploreMoreStyleTitle' => $styleTitle,
            'exploreMoreByGallery' => $this->exploreMore($exploreFurther, ($item->is_on_view && !empty($item->gallery_id)) ? $item->gallery_id : null, 'ef-gallery_ids'),
            'exploreMoreByVisuallySimilar' => $item->present()->nearestNeighbors,
            'exploreMoreTags' => $this->buildExploreMoreTags($item),
        ];
    }

    private function buildRelatedContent($item): array
    {
        $autoRelatedEnabled = empty($item->getAugmentedModel()?->toggle_autorelated);

        $relatedItems = collect();

        if ($autoRelatedEnabled && ($artistPage = $this->getRelatedArtistPage($item, true))) {
            $relatedItems->push($artistPage);
        }

        foreach ($this->getFeatureRelated($item) as $featured) {
            $relatedItems->push(is_array($featured) ? ($featured['item'] ?? null) : $featured);
        }

        if ($autoRelatedEnabled) {
            $relatedItems = $relatedItems->concat($this->getAutoRelated($item));
        }

        $items = $relatedItems
            ->map(function ($model) {
                return $this->normalizeRelatedContentItem($model);
            })
            ->filter()
            ->values();

        return [
            'items' => $items,
            'total' => $items->count(),
        ];
    }

    private function normalizeRelatedContentItem($model): ?array
    {
        if (!$model) {
            return null;
        }

        $eyebrow = [
            'Article' => 'Article',
            'Highlight' => 'Highlight',
            'Video' => 'Video',
            'Experience' => 'Interactive Feature',
            'DigitalExplorer' => 'Digital Explorer',
            'Exhibition' => 'Exhibition',
            'DigitalPublication' => 'Digital Publication',
            'DigitalPublicationArticle' => 'Digital Publication Article',
            'Event' => 'Event',
            'Artist' => 'About the artist',
        ][class_basename($model)] ?? null;

        if ($eyebrow === null) {
            return null;
        }

        $href = $this->itemHref($model);

        // Artists have no getUrl()/url_without_slug accessor; their tag page is
        // the only canonical destination.
        if (empty($href) && ($model instanceof \App\Models\Api\Artist || $model instanceof \App\Models\Artist)) {
            $href = route('artists.show', ['id' => $model->id, 'slug' => $model->titleSlug ?? null]);
        }

        // Digital explorers have no getUrl()/url_without_slug accessor either;
        // their detail route is the only canonical destination.
        if (empty($href) && $model instanceof \App\Models\DigitalExplorer) {
            $href = route('digitalExplorer.show', array_filter([
                'id' => $model->id,
                'slug' => method_exists($model, 'getSlug') ? $model->getSlug() : null,
            ]));
        }

        if (empty($href)) {
            return null;
        }

        return [
            'href' => $href,
            'title' => $this->itemTitle($model),
            'eyebrow' => $eyebrow,
            'image' => $this->itemImage($model, ['listing', 'hero']),
            'is_video' => $model instanceof \App\Models\Video || $model instanceof \App\Models\Api\Video,
        ];
    }

    /**
     * Preferred URL for a related model, following its getUrl() when it has one.
     */
    private function itemHref($model, $fallbackKey = 'url_without_slug')
    {
        return method_exists($model, 'getUrl') ? $model->getUrl() : ($model->{$fallbackKey} ?? null);
    }

    private function itemTitle($model): ?string
    {
        $title = null;

        if (method_exists($model, 'present')) {
            try {
                $title = $model->present()->title;
            } catch (\Throwable $e) {
                $title = null;
            }
        }

        if (empty($title)) {
            $title = $model->title ?? null;
        }

        return $title;
    }

    private function itemImage($model, array $variants)
    {
        if (!method_exists($model, 'imageFront')) {
            return null;
        }

        foreach ($variants as $variant) {
            $image = $model->imageFront($variant);

            if (!empty($image)) {
                return $image;
            }
        }

        return null;
    }

    /**
     * Shared builder for manual + auto sections, de-duplicated and normalized.
     */
    private function buildSectionItems($item, string $manualMethod, string $autoMethod, string $toggleProperty, callable $normalizer): array
    {
        if (!$item || empty($item->id)) {
            return ['items' => collect(), 'total' => 0];
        }

        $augmented = method_exists($item, 'getAugmentedModel') ? $item->getAugmentedModel() : null;

        $manual = ($augmented && method_exists($augmented, $manualMethod))
            ? $augmented->{$manualMethod}()
            : collect();

        $auto = ($augmented && !empty($augmented->{$toggleProperty}))
            ? collect()
            : ArtworkSectionService::{$autoMethod}((int) $item->id);

        // Manual selections override all, drop auto items already selected by hand.
        $manualKeys = collect($manual)
            ->map(fn ($model) => $model && !empty($model->id) ? get_class($model) . ':' . $model->id : null)
            ->filter()
            ->all();

        $items = $manual
            ->concat(collect($auto)->reject(fn ($model) => in_array($model && !empty($model->id) ? get_class($model) . ':' . $model->id : null, $manualKeys, true)))
            ->map($normalizer)
            ->filter()
            ->values();

        return [
            'items' => $items,
            'total' => $items->count(),
        ];
    }

    private function normalizePublicationItem($publication): ?array
    {
        if (!$publication) {
            return null;
        }

        $href = $this->itemHref($publication, 'url');

        if (empty($href)) {
            return null;
        }

        $date = $publication->publication_date ?? null;

        // Digital Publication Articles have no publication_date; use their own
        // date, then their parent publication's.
        if (empty($date) && $publication instanceof DigitalPublicationArticle) {
            $date = $publication->date ?: optional($publication->digitalPublication)->publication_date;
        }

        return [
            'href' => $href,
            'title' => $this->itemTitle($publication),
            'year' => $this->itemYear($date),
            'image' => $this->itemImage($publication, ['listing', 'hero', 'banner']),
        ];
    }

    private function normalizeExhibitionItem($exhibition): ?array
    {
        $href = $this->itemHref($exhibition);

        if (empty($href)) {
            return null;
        }

        $title = $this->itemTitle($exhibition);

        return [
            'href' => $href,
            'title' => $title,
            'year' => $this->itemYear($exhibition->aic_start_at ?? null),
            'description' => $exhibition->short_description ?? $exhibition->list_description ?? '',
        ];
    }

    /**
     * Year of a date-ish value, or null when missing or unparsable.
     */
    private function itemYear($date): ?string
    {
        if (empty($date)) {
            return null;
        }

        try {
            return Carbon::parse($date)->format('Y');
        } catch (\Throwable $e) {
            return null;
        }
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
        $item = $this->findArtwork($id, ['artist_pivots']);

        if (!$item) {
            abort(404);
        }

        $exploreFurther = new ExploreFurther($item);

        $view['html'] = request()->has('ef-all_ids')
            ? view('site.shared._exploreFurtherTags', [
                'tags' => $exploreFurther->allTags(request()->all()),
            ])->render()
            : view('site.shared._exploreFurther', [
                'artworks' => $exploreFurther->collection(request()->all()),
            ])->render();

        return $view;
    }

    private function exploreMore(ExploreFurther $exploreFurther, $value, string $filter)
    {
        if (empty($value)) {
            return collect([]);
        }

        $results = $exploreFurther->collection([$filter => $value]);

        return $results->count() > 1 ? $results : collect([]);
    }

    private function buildExploreMoreTags($item)
    {
        $ids = collect([
            $item->category_ids,
            $item->style_ids,
            $item->classification_ids,
            $item->subject_ids,
            $item->material_ids,
            $item->technique_ids,
        ])
            ->flatten()
            ->filter()
            ->unique()
            ->values()
            ->all();

        if (empty($ids)) {
            return collect();
        }

        return CategoryTerm::query()
            ->ids($ids)
            ->get(['id', 'title', 'subtype', 'usage_count'])
            ->sortByDesc('usage_count')
            ->take(self::EXPLORE_MORE_TAG_LIMIT)
            ->map(function ($term) {
                return (object) [
                    'url' => route('collection', [$term->getParameterName() => $term->title]),
                    'label' => $term->title,
                ];
            })
            ->values();
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

            $unitCode = 'CMT';
            $unitText = 'cm';

            foreach ($details as $detail) {
                $detail = is_array($detail) ? $detail : (array) $detail;

                $dimensions = [];

                foreach (['width', 'height', 'depth'] as $key) {
                    $value = $detail[$key] ?? null;

                    if (!is_numeric($value)) {
                        continue;
                    }

                    $dimensions[$key] = [
                        '@type' => 'QuantitativeValue',
                        'value' => (float) $value,
                        'unitCode' => $unitCode,
                        'unitText' => $unitText,
                    ];
                }

                if (!empty($dimensions)) {
                    return $dimensions;
                }
            }

            return null;
        };

        // Canonical API URL for the artwork, shared by the encoding/sameAs nodes.
        $artworkApiUrl = static fn ($m) => empty($m->id ?? null)
            ? null
            : config('api.public_uri'). $m->id;

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
                'inLanguage' => SchemaMapper::inLanguage(),
                'dateCreated' => static fn ($m) => ($m->date_start ?? $m->date_end) !== null ? (string) ($m->date_start ?? $m->date_end) : null,
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
                    $style = $m->style_titles ?? null;
                    $genre = is_array($style) ? ($style[0] ?? null) : null;

                    if (empty($genre)) {
                        $genre = $m->classification_title ?? null;
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
                'encoding' => static function ($m) use ($artworkApiUrl) {
                    $url = $artworkApiUrl($m);

                    if (empty($url)) {
                        return null;
                    }

                    return [
                        '@type' => 'MediaObject',
                        '@id' => $url . '/manifest.json',
                        'encodingFormat' => 'application/ld+json',
                    ];
                },
                'sameAs' => static fn ($m) => $artworkApiUrl($m),
            ]
        );
    }
}
