<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;
use App\Repositories\PageRepository;
use Session;

class PageController extends ModuleController
{
    const MISSING_CMS_PAGE_MESSAGE = "CMS home page doesn't exist, make sure to migrate the database and seed it first (php artisan migrate & php artisan db:seed)";

    protected $moduleName = 'pages';

    protected function formData($request)
    {
        $isVisit = stripos($request->path(), 'visit') !== false ? true : false;

        return [
            'permalink' => false,
            'publish' => false,
            'editableTitle' => $isVisit,
            'translate' => $isVisit,
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
        Session::put("pages_back_link", route('admin.collection.landing'));

        $additionalFieldsets = [];
        $fields = $this->form($page->id);
        $fields['additionalFieldsets'] = $additionalFieldsets;

        return view('admin.pages.form', $fields);
    }

    public function articles_publications(PageRepository $pages)
    {
        abort_unless($page = $pages->byName('Articles and Publications'), 500, self::MISSING_CMS_PAGE_MESSAGE);
        Session::put("pages_back_link", route('admin.collection.articles_publications.landing'));

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
            ['fieldset' => 'hours', 'label' => 'Hours'],
            ['fieldset' => 'admissions', 'label' => 'Admissions'],
            ['fieldset' => 'featured_offer', 'label' => 'Featured offer'],
            ['fieldset' => 'directions', 'label' => 'Museum address'],
            ['fieldset' => 'dining_hours', 'label' => 'Dining'],
            ['fieldset' => 'faq', 'label' => 'FAQ'],
            ['fieldset' => 'tourpages', 'label' => 'Tours'],
            ['fieldset' => 'families', 'label' => 'Families, teens and educators'],
        ];

        $fields = $this->form($page->id);
        $fields['additionalFieldsets'] = $additionalFieldsets;

        return view('admin.pages.form', $fields);
    }

    public function articles(PageRepository $pages)
    {
        abort_unless($page = $pages->byName('Articles'), 500, self::MISSING_CMS_PAGE_MESSAGE);
        Session::put("pages_back_link", route('admin.collection.articles_publications.landing'));
        $additionalFieldsets = [];
        $fields = $this->form($page->id);
        $fields['additionalFieldsets'] = $additionalFieldsets;

        return view('admin.pages.form', $fields);
    }

    public function exhibitionHistory(PageRepository $pages)
    {
        abort_unless($page = $pages->byName('Exhibition History'), 500, self::MISSING_CMS_PAGE_MESSAGE);
        Session::put("pages_back_link", route('admin.exhibitions_events.history'));

        $additionalFieldsets = [];
        $fields = $this->form($page->id);
        $fields['additionalFieldsets'] = $additionalFieldsets;

        return view('admin.pages.form', $fields);
    }

    public function collection(PageRepository $pages)
    {
        abort_unless($page = $pages->byName('Collection'), 500, self::MISSING_CMS_PAGE_MESSAGE);
        Session::put("pages_back_link", route('admin.collection.landing'));

        $additionalFieldsets = [];
        $fields = $this->form($page->id);
        $fields['additionalFieldsets'] = $additionalFieldsets;

        return view('admin.pages.form', $fields);
    }

    public function research(PageRepository $pages)
    {
        abort_unless($page = $pages->byName('Research and Resources'), 500, self::MISSING_CMS_PAGE_MESSAGE);

        $additionalFieldsets = [];
        $fields = $this->form($page->id);
        $fields['additionalFieldsets'] = $additionalFieldsets;

        return view('admin.pages.form', $fields);
    }

    protected function getRoutePrefix()
    {
        return null;
    }

    protected function moduleHas($behavior)
    {
        return $behavior === 'revisions' ? false : parent::moduleHas($behavior);
    }
}
