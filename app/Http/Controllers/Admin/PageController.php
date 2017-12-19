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
        abort_unless($homepage = $pages->byName('Home'), 500, "CMS home page doesn't exist, make sure to migrate the database first (php artisan migrate)");
        Session::put("pages_back_link", route('admin.landing.home'));
        return view('admin.pages.form', $this->form($homepage->id));
    }

    public function exhibitions(PageRepository $pages)
    {
        abort_unless($homepage = $pages->byName('Exhibitions and Events'), 500, "CMS home page doesn't exist, make sure to migrate the database first (php artisan migrate)");
        Session::put("pages_back_link", route('admin.landing.exhibitions'));
        return view('admin.pages.form', $this->form($homepage->id));
    }

    public function art(PageRepository $pages)
    {
        abort_unless($homepage = $pages->byName('Art and Ideas'), 500, "CMS home page doesn't exist, make sure to migrate the database first (php artisan migrate)");
        Session::put("pages_back_link", route('admin.landing.art'));
        return view('admin.pages.form', $this->form($homepage->id));
    }

    public function visit(PageRepository $pages)
    {
        abort_unless($homepage = $pages->byName('Visit'), 500, "CMS home page doesn't exist, make sure to migrate the database first (php artisan migrate)");
        Session::put("pages_back_link", route('admin.landing.visit'));
        return view('admin.pages.form', $this->form($homepage->id));
    }

    protected function getRoutePrefix()
    {
        return null;
    }

}
