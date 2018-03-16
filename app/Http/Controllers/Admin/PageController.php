<?php

namespace App\Http\Controllers\Admin;

use A17\CmsToolkit\Http\Controllers\Admin\ModuleController;
use App\Repositories\PageRepository;
use Session;

class PageController extends ModuleController
{
    const MISSING_CMS_PAGE_MESSAGE = "CMS home page doesn't exist, make sure to migrate the database and seed it first (php artisan migrate & php artisan db:seed)";

    protected $moduleName = 'pages';

    protected function formData($request)
    {
        #TODO: remove horrible hack to enable title editing for Visit Page
        $editableTitle = stripos($request->path(), 'visit') !== false ? true : false;
        return [
            'permalink' => false,
            'publish' => false,
            'editableTitle' => $editableTitle,
        ];
    }

    public function home(PageRepository $pages)
    {
        abort_unless($page = $pages->byName('Home'), 500, self::MISSING_CMS_PAGE_MESSAGE);
        Session::put("pages_back_link", route('admin.homepage.landing'));

        $additionalFieldsets = [
            ['fieldset' => 'membership', 'label' => 'Membership Module'],
        ];
        $fields = $this->form($page->id);
        $fields['additionalFieldsets'] = $additionalFieldsets;

        return view('admin.pages.form', $fields);
    }

    public function exhibitions(PageRepository $pages)
    {
        abort_unless($page = $pages->byName('Exhibitions and Events'), 500, self::MISSING_CMS_PAGE_MESSAGE);
        Session::put("pages_back_link", route('admin.exhibitions_events.landing'));

        $additionalFieldsets = [];
        $fields = $this->form($page->id);
        $fields['additionalFieldsets'] = $additionalFieldsets;

        return view('admin.pages.form', $fields);
    }

    public function art(PageRepository $pages)
    {
        abort_unless($page = $pages->byName('Art and Ideas'), 500, self::MISSING_CMS_PAGE_MESSAGE);
        Session::put("pages_back_link", route('admin.landing.art'));

        $additionalFieldsets = [];
        $fields = $this->form($page->id);
        $fields['additionalFieldsets'] = $additionalFieldsets;

        return view('admin.pages.form', $fields);
    }

    public function visit(PageRepository $pages)
    {
        abort_unless($page = $pages->byName('Visit'), 500, self::MISSING_CMS_PAGE_MESSAGE);
        Session::put("pages_back_link", route('admin.homepage.landing'));

        $additionalFieldsets = [
            ['fieldset' => 'locations', 'label' => 'Locations'],
            ['fieldset' => 'admissions', 'label' => 'Admissions'],
            ['fieldset' => 'featured_hours', 'label' => 'Featured hours'],
            ['fieldset' => 'dinning_hours', 'label' => 'Dinning hours'],
        ];

        $fields = $this->form($page->id);
        $fields['additionalFieldsets'] = $additionalFieldsets;

        return view('admin.pages.form', $fields);
    }

    public function articles(PageRepository $pages)
    {
        abort_unless($page = $pages->byName('Articles'), 500, self::MISSING_CMS_PAGE_MESSAGE);
        Session::put("pages_back_link", route('admin.landing.articles'));
        $additionalFieldsets = [];
        $fields = $this->form($page->id);
        $fields['additionalFieldsets'] = $additionalFieldsets;

        return view('admin.pages.form', $fields);
    }

    public function exhibitionHistory(PageRepository $pages)
    {
        abort_unless($page = $pages->byName('Exhibition History'), 500, self::MISSING_CMS_PAGE_MESSAGE);
        Session::put("pages_back_link", route('admin.landing.exhibition_history'));

        $additionalFieldsets = [];
        $fields = $this->form($page->id);
        $fields['additionalFieldsets'] = $additionalFieldsets;

        return view('admin.pages.form', $fields);
    }

    protected function getRoutePrefix()
    {
        return null;
    }

    protected function moduleHasRevisions()
    {
        return false;
    }

}
