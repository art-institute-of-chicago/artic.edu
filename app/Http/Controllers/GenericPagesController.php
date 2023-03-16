<?php

namespace App\Http\Controllers;

use App\Repositories\GenericPageRepository;
use Illuminate\Http\Request;

class GenericPagesController extends FrontController
{
    protected $genericPageRepository;

    public function __construct(GenericPageRepository $genericPageRepository)
    {
        $this->genericPageRepository = $genericPageRepository;

        parent::__construct();
    }

    public function show($slug, Request $request)
    {   
        $page = $this->getPage($slug);

        if ($slug === 'press/art-institute-images') {
            $configuredUsername = config('aic.http_username');
            $configuredPassword = config('aic.http_password');

            if (empty($configuredUsername) || empty($configuredPassword)) {
                return abort(500, 'Basic authentication not configured.');
            }
            $authenticationHasPassed = false;

            if ($request->header('PHP_AUTH_USER', null) && $request->header('PHP_AUTH_PW', null)) {
                $username = $request->header('PHP_AUTH_USER');
                $password = $request->header('PHP_AUTH_PW');
    
                if ($username === $configuredUsername && $password === $configuredPassword) {
                    $authenticationHasPassed = true;
                }
            }
    
            if ($authenticationHasPassed === false) {
                return response()->make('Invalid credentials.', 401, ['WWW-Authenticate' => 'Basic']);
            }
        }

        // Redirect the user if "Redirect URL" is defined
        if ($page->redirect_url) {
            return redirect($page->redirect_url);
        }

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

        return view('site.genericPage.show', [
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
}
