<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\AuthorRepository;
use App\Libraries\SchemaOrg\SchemaMapper;

class AuthorController extends FrontController
{
    protected $repository;

    public function __construct(AuthorRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }

    public function index(Request $request)
    {
        $items = $this->repository->published()->ordered()->paginate();

        $title = 'Authors';
        $titles = array_filter([
            $title,
            request('page') ? 'Page ' . request('page') : null,
        ]);
        $this->seo->setTitle(implode(', ', $titles));

        $subNav = [
            ['label' => $title, 'href' => route('authors.index'), 'active' => true]
        ];

        $nav = [
            ['label' => 'Publications', 'href' => '/publications', 'links' => $subNav]
        ];

        $view_data = [
            'title' => $title,
            'subNav' => $subNav,
            'nav' => $nav,
            'wideBody' => true,
            'filters' => null,
            'listingCountText' => 'Showing ' . $items->total() . ' authors',
            'listingItems' => $items,
        ];

        return view('site.genericPage.index', $view_data);
    }

    public function show($id, $slug = null)
    {
        $item = $this->repository->published()->where('id', (int) $id)->first();

        if (!$item) {
            abort(404);
        }

        $canonicalPath = route('authors.show', ['id' => $item->id, 'slug' => $item->getSlug()]);

        if ($canonicalRedirect = $this->getCanonicalRedirect($canonicalPath)) {
            return $canonicalRedirect;
        }

        $this->seo->setTitle($item->title);
        $this->seo->setDescription($item->list_description ?? $item->description); // Issues have no blocks
        $this->seo->setImage($item->imageFront('hero'));

        $breadcrumbs = [
            [
                'label' => 'The Collection',
                'href' => '/collection',
            ],
            [
                'label' => 'Publications',
                'href' => '/publications',
            ],
            [
                'label' => 'Authors',
                'href' => '/authors',
            ],
        ];

        $this->addJsonLd($item);

        return view('site.authorDetail', [
            'item' => $item,
            'breadcrumbs' => $breadcrumbs,
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
                '@type' => 'Person',
                'url' => SchemaMapper::canonical('authors.show'),
                'mainEntityOfPage' => SchemaMapper::canonical('authors.show'),
                'jobTitle' => 'job_title',
            ]
        );
    }
}
