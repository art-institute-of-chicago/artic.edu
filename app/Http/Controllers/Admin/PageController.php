<?php

namespace App\Http\Controllers\Admin;

use A17\CmsToolkit\Http\Controllers\Admin\ModuleController;
use App\Repositories\PageRepository;
use Session;

class PageController extends ModuleController
{
    protected $moduleName = 'pages';
    protected $formWith = ['slugs'];
    protected $formWithCount = [];

    protected function formData($request)
    {
        return [];
    }

    public function home(PageRepository $pages)
    {
        abort_unless($page = $pages->byName('Home'), 500, "CMS home page doesn't exist, make sure to migrate the database first (php artisan migrate)");
        Session::put("pages_back_link", route('admin.landing.home'));
        return view('admin.pages.form', $this->form($page->id));
    }

    public function exhibitions(PageRepository $pages)
    {
        abort_unless($page = $pages->byName('Exhibitions and Events'), 500, "CMS home page doesn't exist, make sure to migrate the database first (php artisan migrate)");
        Session::put("pages_back_link", route('admin.landing.exhibitions'));
        return view('admin.pages.form', $this->form($page->id));
    }

    public function art(PageRepository $pages)
    {
        abort_unless($page = $pages->byName('Art and Ideas'), 500, "CMS home page doesn't exist, make sure to migrate the database first (php artisan migrate)");
        Session::put("pages_back_link", route('admin.landing.art'));
        return view('admin.pages.form', $this->form($page->id));
    }

    public function visit(PageRepository $pages)
    {
        abort_unless($page = $pages->byName('Visit'), 500, "CMS home page doesn't exist, make sure to migrate the database first (php artisan migrate)");
        Session::put("pages_back_link", route('admin.landing.visit'));
        return view('admin.pages.form', $this->form($page->id));
    }

    public function articles(PageRepository $pages)
    {
        abort_unless($page = $pages->byName('Articles'), 500, "CMS home page doesn't exist, make sure to migrate the database and seed it first (php artisan migrate & php artisan db:seed)");
        Session::put("pages_back_link", route('admin.landing.articles'));
        return view('admin.pages.form', $this->form($page->id));
    }

    public function exhibitionHistory(PageRepository $pages)
    {
        abort_unless($page = $pages->byName('Exhibition History'), 500, "CMS home page doesn't exist, make sure to migrate the database first (php artisan migrate)");
        Session::put("pages_back_link", route('admin.landing.exhibition_history'));
        return view('admin.pages.form', $this->form($page->id));
    }

    protected function getRoutePrefix()
    {
        return null;
    }

}
