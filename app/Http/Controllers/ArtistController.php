<?php

namespace App\Http\Controllers;

use App\Repositories\Api\ArtistRepository;
use App\Libraries\ExploreFurther\BaseService as ExploreArtists;
use App\Libraries\SchemaOrg\SchemaMapper;

class ArtistController extends FrontController
{
    public const ARTWORKS_PER_PAGE = 12;

    protected $repository;

    public function __construct(ArtistRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    public function show($id, $slug = null)
    {
        $item = $this->repository->getById((int) $id);

        $canonicalPath = route('artists.show', ['id' => $item->id, 'slug' => $item->titleSlug]);

        if ($canonicalRedirect = $this->getCanonicalRedirect($canonicalPath)) {
            return $canonicalRedirect;
        }

        $this->seo->setTitle($item->meta_title ?: $item->title);
        $this->seo->setDescription($item->meta_description ?: 'Artist');

        $artworks = $item->artworks(self::ARTWORKS_PER_PAGE);
        $exploreFurther = new ExploreArtists($item, $artworks->getMetadata('aggregations'));
        $this->seo->setImage($item->imageFront('hero') ?? ($artworks && $artworks->isNotEmpty() ? $artworks->first()->imageFront('hero') : null));

        $relatedItems = $this->repository->getRelatedItems($item);

        $this->addJsonLd($item);

        return view('site.tagDetail', [
            'item' => $item,
            'artworks' => $artworks,
            'exploreFurtherTags' => $exploreFurther->tags(),
            'exploreFurther' => $exploreFurther->collection(request()->all()),
            'exploreFurtherCollectionUrl' => $exploreFurther->collectionUrl(request()->all()),
            'relatedItems' => $relatedItems->count() > 0 ? $relatedItems : null,
            'canonicalUrl' => $canonicalPath,
            'pageMetaData' => $this->getPageMetaData($item),
        ]);
    }

    protected function setPageMetaData($item)
    {
        return [
            'type' => 'artist',
        ];
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
        $artistIsCorporate = static fn ($m): bool => SchemaMapper::isGroupAgent($m);

        return array_merge(
            parent::jsonLdDefinition($model),
            [
                '@type' => static fn ($m) => $artistIsCorporate($m) ? 'Organization' : 'Person',
                'url' => SchemaMapper::canonical('artists.show', 'titleSlug'),
                'mainEntityOfPage' => SchemaMapper::canonical('artists.show', 'titleSlug'),
                'additionalType' => static fn ($m) => $artistIsCorporate($m) && !empty($m->ulan_id)
                    ? 'https://vocab.getty.edu/ulan/' . $m->ulan_id
                    : null,
                'birthDate' => static fn ($m) => $artistIsCorporate($m) ? null : ($m->birth_date ?? null),
                'deathDate' => static fn ($m) => $artistIsCorporate($m) ? null : ($m->death_date ?? null),
                'birthPlace' => static fn ($m) => $artistIsCorporate($m) ? null : ($m->birth_place ?? null),
                'nationality' => static fn ($m) => $artistIsCorporate($m) ? null : ($m->nationality ?? null),
            ]
        );
    }
}
