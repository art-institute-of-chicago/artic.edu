<?php

namespace App\Http\Controllers;

use App\Repositories\Api\DepartmentRepository;
use App\Libraries\SchemaOrg\SchemaMapper;

class DepartmentController extends FrontController
{
    public const ARTWORKS_PER_PAGE = 24;

    protected $repository;

    public function __construct(DepartmentRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    public function show($id, $slug = null)
    {
        $item = $this->repository->getById($id);

        $canonicalPath = route('departments.show', ['id' => $item->id, 'slug' => $item->titleSlug]);

        if ($canonicalRedirect = $this->getCanonicalRedirect($canonicalPath)) {
            return $canonicalRedirect;
        }

        $this->seo->setTitle($item->meta_title ?: $item->title);
        $this->seo->setDescription($item->meta_description ?: 'Department');
        $this->seo->setImage($item->imageFront('hero'));

        $artworks = $this->repository->getRelatedArtworks($item);
        $relatedItems = $this->repository->getRelatedItems($item);

        $this->addJsonLd($item);

        return view('site.tagDetail', [
            'item' => $item,
            'artworks' => $artworks,
            'relatedItems' => $relatedItems->count() > 0 ? $relatedItems : null,
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
                '@type' => 'CollectionPage',
                'inLanguage' => SchemaMapper::inLanguage(),
                'description' => SchemaMapper::text('description', 'short_copy', 'list_description'),
                'url' => SchemaMapper::canonical('departments.show', 'titleSlug'),
                'mainEntityOfPage' => SchemaMapper::canonical('departments.show', 'titleSlug'),
                'isPartOf' => SchemaMapper::orgRef(),
            ]
        );
    }
}
