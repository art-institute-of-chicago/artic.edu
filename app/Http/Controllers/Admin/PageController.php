<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;
use App\Repositories\PageRepository;
use Session;

class PageController extends ModuleController
{
    public const MISSING_CMS_PAGE_MESSAGE = "CMS home page doesn't exist, make sure to migrate the database and seed it first (php artisan migrate & php artisan db:seed)";

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
        Session::put('pages_back_link', route('admin.homepage.landing'));

        $additionalFieldsets = [
            ['fieldset' => 'plan-your-visit', 'label' => 'Plan Your Visit'],
            ['fieldset' => 'video-carousel', 'label' => 'Video Carousel'],
            ['fieldset' => 'call-to-action', 'label' => 'Call to Action'],
            ['fieldset' => 'highlights', 'label' => 'Highlights'],
            ['fieldset' => 'artists', 'label' => 'Artists'],
            ['fieldset' => 'from-the-collection', 'label' => 'From the Collection'],
            ['fieldset' => 'from-the-shop', 'label' => 'From the Shop'],
            ['fieldset' => 'exhibitions-and-events', 'label' => 'Exhibitions and Events'],
        ];
        $fields = $this->form($page->id);
        $fields['additionalFieldsets'] = $additionalFieldsets;

        return view('admin.pages.form', $fields);
    }

    public function exhibitions(PageRepository $pages)
    {
        abort_unless($page = $pages->byName('Exhibitions and Events'), 500, self::MISSING_CMS_PAGE_MESSAGE);
        Session::put('pages_back_link', route('admin.exhibitions_events.landing'));

        $additionalFieldsets = [];
        $fields = $this->form($page->id);
        $fields['additionalFieldsets'] = $additionalFieldsets;

        return view('admin.pages.form', $fields);
    }

    public function art(PageRepository $pages)
    {
        abort_unless($page = $pages->byName('Art and Ideas'), 500, self::MISSING_CMS_PAGE_MESSAGE);
        Session::put('pages_back_link', route('admin.collection.landing'));

        $additionalFieldsets = [];
        $fields = $this->form($page->id);
        $fields['additionalFieldsets'] = $additionalFieldsets;

        return view('admin.pages.form', $fields);
    }

    public function articles_publications(PageRepository $pages)
    {
        abort_unless($page = $pages->byName('Articles and Publications'), 500, self::MISSING_CMS_PAGE_MESSAGE);
        Session::put('pages_back_link', route('admin.collection.articles_publications.landing'));

        $additionalFieldsets = [];
        $fields = $this->form($page->id);
        $fields['additionalFieldsets'] = $additionalFieldsets;

        return view('admin.pages.form', $fields);
    }

    public function visit(PageRepository $pages)
    {
        abort_unless($page = $pages->byName('Visit'), 500, self::MISSING_CMS_PAGE_MESSAGE);
        Session::put('pages_back_link', route('admin.homepage.landing'));

        $additionalFieldsets = [
            ['fieldset' => 'hours', 'label' => 'Hours'],
            ['fieldset' => 'call-to-action', 'label' => 'CTA'],
            ['fieldset' => 'expect', 'label' => 'Expect'],
            ['fieldset' => 'admissions', 'label' => 'Adm.'],
            ['fieldset' => 'faq', 'label' => 'FAQ'],
            ['fieldset' => 'citypass', 'label' => 'CityPASS'],
            ['fieldset' => 'accessibility', 'label' => 'A11y'],
            ['fieldset' => 'directions', 'label' => 'Dir.'],
            ['fieldset' => 'explore', 'label' => 'Explore'],
        ];

        $fields = $this->form($page->id);
        $fields['additionalFieldsets'] = $additionalFieldsets;

        return view('admin.pages.form', $fields);
    }

    public function articles(PageRepository $pages)
    {
        abort_unless($page = $pages->byName('Articles'), 500, self::MISSING_CMS_PAGE_MESSAGE);
        Session::put('pages_back_link', route('admin.collection.articles_publications.landing'));
        $additionalFieldsets = [];
        $fields = $this->form($page->id);
        $fields['additionalFieldsets'] = $additionalFieldsets;

        return view('admin.pages.form', $fields);
    }

    public function exhibitionHistory(PageRepository $pages)
    {
        abort_unless($page = $pages->byName('Exhibition History'), 500, self::MISSING_CMS_PAGE_MESSAGE);
        Session::put('pages_back_link', route('admin.exhibitions_events.history'));

        $additionalFieldsets = [];
        $fields = $this->form($page->id);
        $fields['additionalFieldsets'] = $additionalFieldsets;

        return view('admin.pages.form', $fields);
    }

    public function collection(PageRepository $pages)
    {
        abort_unless($page = $pages->byName('Collection'), 500, self::MISSING_CMS_PAGE_MESSAGE);
        Session::put('pages_back_link', route('admin.collection.landing'));

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
