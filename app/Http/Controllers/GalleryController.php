<?php

namespace App\Http\Controllers;

use App\Repositories\Api\GalleryRepository;
use App\Libraries\SchemaOrg\SchemaMapper;

class GalleryController extends FrontController
{
    public const ARTWORKS_PER_PAGE = 50;

    protected $repository;

    public function __construct(GalleryRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    public function show($id, $slug = null)
    {
        $item = $this->repository->getById((int) $id);

        $canonicalPath = route('galleries.show', ['id' => $item->id, 'slug' => $item->titleSlug]);

        if ($canonicalRedirect = $this->getCanonicalRedirect($canonicalPath)) {
            return $canonicalRedirect;
        }

        $this->seo->setTitle($item->meta_title ?: $item->title);
        $this->seo->setDescription($item->meta_description ?: 'Gallery');
        $this->seo->setImage($item->imageFront('hero'));

        $artworks = $item->artworks(self::ARTWORKS_PER_PAGE);

        $this->addJsonLd($item);

        return view('site.tagDetail', [
            'item' => $item,
            'artworks' => $artworks,
            'canonicalUrl' => $canonicalPath,
        ]);
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
        return array_merge(
            parent::jsonLdDefinition($model),
            [
                '@type' => 'Place',
                'url' => SchemaMapper::canonical('galleries.show', 'titleSlug'),
                'containedInPlace' => SchemaMapper::orgRef(),
                'geo' => static function ($m) {
                    $latitude = $m->latitude ?? null;
                    $longitude = $m->longitude ?? null;

                    if (!is_numeric($latitude) || !is_numeric($longitude)) {
                        return null;
                    }

                    return [
                        '@type' => 'GeoCoordinates',
                        'latitude' => (float) $latitude,
                        'longitude' => (float) $longitude,
                    ];
                },
            ]
        );
    }
}
