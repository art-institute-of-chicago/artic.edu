<?php

namespace App\Http\Controllers;

use App\Repositories\GenericPageRepository;
use App\Http\Controllers\LandingPagesController;
use App\Models\Hour;
use App\Models\Slugs\LandingPageSlug;
use App\Libraries\SchemaOrg\SchemaMapper;
use Illuminate\Http\Request;

class GenericPagesController extends FrontController
{
    protected $genericPageRepository;
    protected $landingPageController;

    public function __construct(
        GenericPageRepository $genericPageRepository,
        LandingPagesController $landingPageController
    ) {
        $this->genericPageRepository = $genericPageRepository;
        $this->landingPageController = $landingPageController;

        parent::__construct();
    }

    public function show($slug, Request $request)
    {
        if ($slug === 'press/art-institute-images') {
            if ($auth = $this->authorize($request)) {
                return $auth;
            }
        }

        $landingPageSlugs = LandingPageSlug::where('active', true)->whereNull('deleted_at')->get()->pluck('slug')->toArray() ?: ['home'];
        if (in_array($slug, $landingPageSlugs)) {
            request()->merge(['LandingPageController' => LandingPagesController::class . '@show']);
            return $this->landingPageController->slug($slug);
        }

        $page = $this->getPage($slug);
        // Redirect the user if "Redirect URL" is defined
        if ($page->redirect_url) {
            return redirect($page->redirect_url);
        }

        $item = $this->genericPageRepository->published()->find((int) $page->id);

        $crumbs = $page->present()->breadCrumb($page);
        $navigation = $page->present()->navigation();

        $this->seo->setTitle($page->meta_title ?: $page->title);
        $this->seo->setDescription($page->meta_description ?? $page->short_description ?? $page->listing_description);
        $this->seo->setImage($page->imageFront('listing'));

        // Add Farharbor JS to "Visit with my Students" page.
        // @see instructions here: https://fareharbor.com/artic/dashboard/settings/embeds/
        $addFareHarborJS = false;

        if ($page->id == 126) {
            $addFareHarborJS = true;
        }

        $this->addJsonLd($item);

        return view('site.genericPage.show', [
            'autoRelated' => $this->getAutoRelated($item),
            'featuredRelated' => $this->getFeatureRelated($item),
            'borderlessHeader' => !(empty($page->imageFront('banner'))),
            'nav' => $navigation,
            'intro' => $page->short_description, // WEB-2253: Add different field here to prevent SEO pollution?
            'headerImage' => $page->imageFront('banner'),
            'title' => $page->title,
            'title_display' => $page->title_display,
            'breadcrumb' => $crumbs,
            'blocks' => null,
            'page' => $page,
            'addFareHarborJS' => $addFareHarborJS,
            'hour' => Hour::today()->first(),
        ]);
    }

    protected function getPage($slug)
    {
        $idSlug = collect(explode('/', $slug))->last();
        $page = $this->genericPageRepository->forSlug($idSlug);

        if (empty($page)) {
            $page = $this->genericPageRepository->getById((int) $idSlug);

            if (!$page) {
                abort(404);
            }
        }

        return $page;
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
        $genericPageUrl = static function ($m) {
            try {
                $url = $m->url ?? null;
            } catch (\Throwable $e) {
                $url = null;
            }

            if (!is_string($url) || $url === '' || str_starts_with($url, 'http')) {
                return is_string($url) && $url !== '' ? $url : null;
            }

            try {
                return route('pages.slug', ['slug' => ltrim($url, '/')]);
            } catch (\Throwable $e) {
                return url($url);
            }
        };

        return array_merge(
            parent::jsonLdDefinition($model),
            [
                '@type' => 'WebPage',
                'description' => SchemaMapper::text('meta_description', 'short_description', 'listing_description', 'description'),
                'dateModified' => SchemaMapper::iso('updated_at'),
                'url' => $genericPageUrl,
                'mainEntityOfPage' => $genericPageUrl,
            ]
        );
    }
}
