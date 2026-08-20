<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PrintedPublicationRepository;
use App\Models\CatalogCategory;
use App\Helpers\NavHelpers;
use App\Libraries\SchemaOrg\SchemaMapper;

class PrintedPublicationsController extends BaseScopedController
{
    protected $repository;

    protected $entity = \App\Models\PrintedPublication::class;

    protected $scopes = [
        'category' => 'byCategory',
    ];

    public function __construct(PrintedPublicationRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }

    protected function beginOfAssociationChain()
    {
        // Apply default scopes to the beginning of the chain
        return parent::beginOfAssociationChain()
            ->published();
    }

    public function index(Request $request)
    {
        $items = $this->collection()->ordered()->paginate();

        $title = 'Print Publications';
        $cat = CatalogCategory::where('id', request('category'))->first();

        $titles = array_filter([
            $title,
            $cat?->name,
            request('page') ? 'Page ' . request('page') : null,
        ]);
        $this->seo->setTitle(implode(', ', $titles));

        $navElements = NavHelpers::get_nav_for_publications($title);

        $view_data = [
            'wideBody' => true,
            'filters' => $this->getFilters(),
            'listingCountText' => 'Showing ' . $items->total() . ' print publications',
            'listingItems' => $items,
        ] + $navElements;

        return view('site.genericPage.index', $view_data);
    }

    public function show($id)
    {
        $item = $this->repository->published()->find((int) $id);

        if (empty($item)) {
            $item = $this->repository->forSlug($id);
        }

        if (!$item) {
            abort(404);
        }

        $canonicalPath = $item->present()->getCanonicalUrl();

        if ($canonicalRedirect = $this->getCanonicalRedirect($canonicalPath)) {
            return $canonicalRedirect;
        }

        $this->seo->setTitle($item->meta_title ?: $item->title);
        $this->seo->setDescription($item->meta_description ?? $item->short_description ?? $item->listing_description);
        $this->seo->setImage($item->imageFront('listing'));

        $this->addJsonLd($item);

        $crumbs = [
            ['label' => 'The Collection', 'href' => route('collection')],
            ['label' => 'Print Publications', 'href' => route('collection.publications.printed-publications')],
            ['label' => $item->title, 'href' => '']
        ];

        return view('site.genericPage.show', [
            'canonicalUrl' => $canonicalPath,
            'borderlessHeader' => !(empty($item->imageFront('banner'))),
            'nav' => null,
            'intro' => $item->short_description,
            'headerImage' => $item->imageFront('banner'),
            'title' => $item->title,
            'breadcrumb' => $crumbs,
            'page' => $item,
        ]);
    }

    protected function getFilters()
    {
        $categoryLinks[] = [
            'label' => 'All',
            'href' => route('collection.publications.printed-publications'),
            'active' => empty(request('category', null))
        ];

        foreach (CatalogCategory::all() as $category) {
            $categoryLinks[] = [
                'href' => route('collection.publications.printed-publications', request()->except('category') + ['category' => $category->id]),
                'label' => $category->name,
                'active' => request('category') == $category->id
            ];
        }

        return [
            [
                'prompt' => 'Subject',
                'links' => collect($categoryLinks)
            ]
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
        $optionalField = static function (string $field) {
            return static function ($m) use ($field) {
                $value = $m->{$field} ?? null;

                if (is_numeric($value) || (is_string($value) && $value !== '')) {
                    return (string) $value;
                }

                return null;
            };
        };

        $bookAuthor = static function ($m) {
            $author = $m->author ?? null;

            return is_string($author) && $author !== '' ? $author : null;
        };

        $bookDatePublished = static function ($m, $mapper) {
            // publication_date is the book's actual publication date;
            // publish_start_date is when the web page went live and must not
            // be used as datePublished for the book.
            $date = $m->publication_date ?? null;

            return $mapper->toIso8601($date);
        };

        $publicationUrl = static function (string $routeName) {
            return static function ($m) use ($routeName) {
                if (empty($m->id)) {
                    return null;
                }

                $slug = method_exists($m, 'getSlug') ? $m->getSlug() : null;

                return route($routeName, ['id' => $m->id, 'slug' => $slug]);
            };
        };

        return array_merge(
            parent::jsonLdDefinition($model),
            [
                '@type' => 'Book',
                'publisher' => SchemaMapper::orgRef(),
                'author' => $bookAuthor,
                'datePublished' => $bookDatePublished,
                'isbn' => $optionalField('isbn'),
                'numberOfPages' => $optionalField('number_of_pages'),
                'url' => $publicationUrl('collection.publications.printed-publications.show'),
                'mainEntityOfPage' => $publicationUrl('collection.publications.printed-publications.show'),
            ]
        );
    }
}
