<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DigitalPublication;
use App\Repositories\DigitalPublicationRepository;
use App\Helpers\NavHelpers;
use App\Libraries\SchemaOrg\SchemaMapper;

class DigitalPublicationsController extends BaseScopedController
{
    protected $repository;

    public function __construct(DigitalPublicationRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }

    public function index(Request $request)
    {
        $items = DigitalPublication::published()->notUnlisted()->ordered()->paginate();

        $title = 'Digital Publications';

        $navElements = NavHelpers::get_nav_for_publications($title);

        $view_data = [
            'wideBody' => true,
            'filters' => null,
            'listingCountText' => 'Showing ' . $items->total() . ' digital publications',
            'listingItems' => $items,
        ] + $navElements;

        return view('site.genericPage.index', $view_data);
    }

    public function show($id)
    {
        return $this->showDetail($id);
    }

    public function showListing($id)
    {
        return $this->showDetail($id, true);
    }

    private function showDetail($id, bool $showAll = false)
    {
        $item = $this->repository->published()->find((int) $id);

        if (empty($item)) {
            $item = $this->repository->forSlug($id);
        }

        if (!$item) {
            abort(404);
        }

        $canonicalPath = $item->present()->getCanonicalUrl() . ($showAll ? '/content' : '');

        if ($canonicalRedirect = $this->getCanonicalRedirect($canonicalPath)) {
            return $canonicalRedirect;
        }

        $this->seo->setTitle($item->meta_title ?: $item->title);
        $this->seo->setDescription($item->meta_description ?? $item->listing_description);
        $this->seo->setImage($item->imageFront('listing'));
        if ($item->is_unlisted) {
            $this->seo->nofollow = true;
            $this->seo->noindex = true;
        }

        $this->addJsonLd($item);

        if ($item->is_dsc_stub) {
            return $this->showDscStub($item);
        }

        return view('site.digitalPublicationDetail', [
            'item' => $item,
            'contrastHeader' => false,
            'borderlessHeader' => false,
            'unstickyHeader' => true,
            'canonicalUrl' => $canonicalPath,
            'welcomeNote' => $this->repository->getWelcomeNote($item),
            'showAll' => $showAll,
        ]);
    }

    private function showDscStub($item)
    {
        $crumbs = [
            ['label' => 'The Collection', 'href' => route('collection')],
            ['label' => 'Digital Publications', 'href' => route('collection.publications.digital-publications')],
            ['label' => $item->title, 'href' => '']
        ];

        return view('site.genericPage.show', [
            'borderlessHeader' => !(empty($item->imageFront('banner'))),
            'headerImage' => $item->imageFront('banner'),
            'title' => $item->title,
            'breadcrumb' => $crumbs,
            'page' => $item,
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
            $date = $m->publication_date ?? $m->publish_start_date ?? null;

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

        $digitalPublicationUrl = $publicationUrl('collection.publications.digital-publications.show');

        return array_merge(
            parent::jsonLdDefinition($model),
            [
                '@type' => ['Book', 'DigitalDocument'],
                'publisher' => SchemaMapper::orgRef(),
                'author' => $bookAuthor,
                'datePublished' => $bookDatePublished,
                'isbn' => $optionalField('isbn'),
                'numberOfPages' => $optionalField('number_of_pages'),
                'url' => $digitalPublicationUrl,
                'mainEntityOfPage' => $digitalPublicationUrl,
                'encodingFormat' => SchemaMapper::literal('text/html'),
                '@id' => static function ($m) use ($digitalPublicationUrl) {
                    $url = $digitalPublicationUrl($m);

                    return is_string($url) && $url !== '' ? $url : null;
                },
            ]
        );
    }
}
