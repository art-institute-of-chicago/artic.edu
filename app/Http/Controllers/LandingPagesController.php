<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\CatalogCategory;
use App\Models\DigitalPublication;
use App\Models\Hour;
use App\Models\Lightbox;
use App\Models\LandingPage;
use App\Models\PrintedPublication;
use App\Repositories\LandingPageRepository;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;

class LandingPagesController extends FrontController
{
    protected $landingPageRepository;

    public function __construct(LandingPageRepository $landingPageRepository)
    {
        $this->landingPageRepository = $landingPageRepository;

        parent::__construct();
    }

    public function slugHome()
    {
        return $this->slug('home');
    }

    public function slug($slug = null)
    {
        $item = $this->landingPageRepository->published()->forSlug($slug)->firstOrFail();
        return $this->show($item->id, $slug);
    }

    public function show($id, $slug = null)
    {
        $item = $this->landingPageRepository->published()->findOrFail((int) $id);
        $canonicalPath = route('pages.slug', ['slug' => $item->getSlug()]);
        if (!$item->getSlug() || $item->getSlug() == 'home') {
            $canonicalPath = route('home');
        }
        if ($canonicalRedirect = $this->getCanonicalRedirect($canonicalPath)) {
            return $canonicalRedirect;
        }

        if (!$item->is_published) {
            $this->seo->nofollow = true;
            $this->seo->noindex = true;
        }

        $types = collect(LandingPage::TYPES);
        switch ($item->type_id) {
            case $types->search('Home'):
                $this->seo->setTitle($item->meta_title ?: $item->title ?: "Downtown Chicago's #1 Museum");
                $this->seo->setDescription($item->meta_description ?: "Located downtown by Millennium Park, this top art museum is TripAdvisor's #1 Chicago attraction—a must when visiting the city.");
                break;

            case $types->search('Visit'):
                $this->seo->setTitle($item->meta_title ?: $item->title ?: 'Visit a Chicago Landmark');
                $this->seo->setDescription($item->meta_description ?: 'Looking for things to do in Downtown Chicago? Plan your visit, find admission pricing, hours, directions, parking & more!');
                $this->seo->setImage($item->imageFront('hero') ?? $item->imageFront('visit_mobile'));
                break;

            case $types->search('My Museum Tour'):
                $this->seo->setTitle($item->meta_title ?: $item->title);
                $this->seo->setDescription($item->meta_description);
                $this->seo->setImage($item->imageFront('header_my_museum_tour_header_image') ?? $item->imageFront('header_my_museum_tour_header_image_mobile'));
                break;

            default:
                $this->seo->setTitle($item->meta_title ?: $item->title);
                $this->seo->setDescription($item->meta_description);
                $this->seo->setImage($item->imageFront('hero') ?? $item->imageFront('mobile_hero'));
                break;
        }

        View::share('landingPageType', Str::slug($item->type)); // This helps render conditional fields for LP types in all components :)
        return view('site.landingPageDetail', $this->viewData($item));
    }

    public function viewData($item)
    {
        $types = collect(LandingPage::TYPES);

        $admission = new Admission();

        $feeTitles = $admission->present()->feeTitles();
        $feePrices = $admission->present()->feePrices();

        // Home
        $primaryFeatures = $item->primaryFeatures()->published()->limit(1)->get();
        $secondaryFeatures = $item->secondaryFeatures()->published()->limit(2)->get();

        $mainFeatures = $primaryFeatures->concat($secondaryFeatures);

        // WEB-2254: Finish deprecating `homeFeatures` relationship
        if ($mainFeatures->count() < 1) {
            $mainFeatures = $item->features()->published()->limit(3)->get();
        }

        // Visit
        if ($video_url = $item->file('video', 'en')) {
            $headerImage = $item->imageFront('mobile_hero');

            $poster_url = $headerImage['src'] ?? '';
            $video = [
                'src' => $video_url,
                'poster' => $poster_url,
                'fallbackImage' => $headerImage,
            ];

            $headerMedia = [
                'type' => 'video',
                'size' => 'hero',
                'media' => $video,
                'hideCaption' => true,
                'style' => $item->header_variation,
                'ctaTitle' => $item->header_cta_title,
                'ctaButtonLabel' => $item->header_cta_button_label,
                'ctaButtonLink' => $item->header_cta_button_link
            ];
        } else {
            $headerMedia = [
                'type' => 'image',
                'size' => 'hero',
                'media' => null,
                'hero' => $item->imageFront('hero'),
                'mobile_hero' => $item->imageFront('mobile_hero'),
                'hideCaption' => true,
                'style' => $item->header_variation,
                'ctaTitle' => $item->header_cta_title,
                'ctaButtonLabel' => $item->header_cta_button_label,
                'ctaButtonLink' => $item->header_cta_button_link
            ];
        }

        $hourType = $item->type == 'RLC' ? collect(Hour::$types)->search('RLC') : 0;
        $hours = [
            'hide_hours' => $item->hide_hours,
            'media' => [
                'type' => 'image',
                'size' => 's',
                'media' => $item->imageFront('visit_featured_hour'),
                'caption' => $item->hour_image_caption,
            ],
            'primary' => $item->hour_header,
            'secondary' => $item->hour_subheader,
            'sections' => $item->featured_hours,
            'intro' => $item->hour_intro,
            'hours' => Hour::today(type: $hourType)->first(),
        ];

        $itemprops = [
            'name' => 'Art Institute of Chicago',
            'telephone' => '+13124433600',
            'publicAccess' => 'true',
        ];

        $title = '';
        if ($item->type_id === $types->search('Visit')) {
            $title = __('Visit');
        } else {
            $title = $item->title;
        }

        $commonViewData = [
            'item' => $item,
            'contrastHeader' => false,
            'headerMedia' => $headerMedia,
            'socialLinks' => $item->socialLinks,
            'filledLogo' => false,
            'title' => $title,
            'intro' => $item->intro,
            'landingPageType' => Str::slug($item->type),
            'seo' => $this->seo,
        ];

        $blockHeadingsContent = $item->blocks->pluck('content')->pluck('heading')->filter();
        $blockHeadings = collect($blockHeadingsContent)->map(function ($blockHeadingsContent) {
            return [
                'label' => $blockHeadingsContent,
                'target' => '#' . Str::slug(strip_tags($blockHeadingsContent))
            ];
        });

        switch ($item->type_id) {
            case $types->search('Home'):
                $viewData = [
                    'contrastHeader' => true,
                    'filledLogo' => sizeof($mainFeatures) > 0,
                    'hours' => $hours,
                    'cta_module_image' => $item->imageFront('home_cta_module_image'),
                    'roadblocks' => $this->getLightboxes(),
                ];
                break;

            case $types->search('Visit'):
                $viewData = [
                    'contrastHeader' => true,
                    'primaryNavCurrent' => 'visit',
                    'subnav' => collect([
                        ['label' => 'hours', 'target' => '#hours'],
                        ['label' => 'location', 'target' => '#location'],
                        ['label' => 'admission', 'target' => '#admission']
                    ])
                        ->concat($blockHeadings)
                        ->concat([['label' => 'FAQs', 'target' => '#FAQs']])
                        ->all(),
                    'hours' => $hours,
                    'itemprops' => $itemprops,
                    'visit_map' => $item->imageFront('visit_map'),
                    'menuItems' => $item->menuItems,
                    'locations' => $item->locations,
                    'admission' => [
                        'titles' => $feeTitles,
                        'prices' => $feePrices,
                    ],
                    'accesibility_link' => $item->labels->get('visit_faq_accessibility_link'),
                    'faqs' => $item->faqs->all(),
                ];
                break;

            case $types->search('My Museum Tour'):
                $viewData = [
                    'header_my_museum_tour_icons' => $item->labels->get('header_my_museum_tour_icons'),
                    'header_my_museum_tour_header_image' => $item->imageFront('header_my_museum_tour_header_image'),
                    'header_my_museum_tour_header_image_mobile' => $item->imageFront('header_my_museum_tour_header_image_mobile'),
                    'header_my_museum_tour_text' => $item->labels->get('header_my_museum_tour_text'),
                    'header_my_museum_tour_primary_button_label' => $item->labels->get('header_my_museum_tour_primary_button_label'),
                    'header_my_museum_tour_primary_button_link' => $item->labels->get('header_my_museum_tour_primary_button_link'),
                    'header_my_museum_tour_secondary_button_label' => $item->labels->get('header_my_museum_tour_secondary_button_label'),
                    'header_my_museum_tour_secondary_button_link' => $item->labels->get('header_my_museum_tour_secondary_button_link'),
                    'header_my_museum_tour_icon_choose_title' => $item->labels->get('header_my_museum_tour_icon_choose_title'),
                    'header_my_museum_tour_icon_choose_desc' => $item->labels->get('header_my_museum_tour_icon_choose_desc'),
                    'header_my_museum_tour_icon_personalize_title' => $item->labels->get('header_my_museum_tour_icon_choose_title'),
                    'header_my_museum_tour_icon_personalize_desc' => $item->labels->get('header_my_museum_tour_icon_personalize_desc'),
                    'header_my_museum_tour_icon_finish_title ' => $item->labels->get('header_my_museum_tour_icon_finish_title'),
                    'header_my_museum_tour_icon_finish_desc' => $item->labels->get('header_my_museum_tour_icon_finish_desc'),
                    'tours_create_cta_module_image' => $item->imageFront('tours_create_cta_module_image'),
                    'tours_create_cta_module_action_url' => $item->labels->get('tours_create_cta_module_action_url'),
                    'tours_create_cta_module_header' => $item->labels->get('tours_create_cta_module_header'),
                    'tours_create_cta_module_button_text' => $item->labels->get('tours_create_cta_module_button_text'),
                    'tours_create_cta_module_body' => $item->labels->get('tours_create_cta_module_body'),
                    'tours_tickets_cta_module_image' => $item->imageFront('tours_tickets_cta_module_image'),
                    'tours_tickets_cta_module_action_url' => $item->labels->get('tours_tickets_cta_module_action_url'),
                    'tours_tickets_cta_module_header' => $item->labels->get('tours_tickets_cta_module_header'),
                    'tours_tickets_cta_module_button_text' => $item->labels->get('tours_tickets_cta_module_button_text'),
                    'tours_tickets_cta_module_body' => $item->labels->get('tours_tickets_cta_module_body'),
                ];
                break;

            case $types->search('RLC'):
                $viewData = [
                    'contrastHeader' => true,
                    'hours' => $hours,
                    'location_image' => [
                        'default' => $item->imageFront('rlc_location'),
                        'mobile' => $item->imageFront('rlc_location', 'mobile'),
                    ],
                ];
                break;

            case $types->search('Editorial'):
                $viewData = [
                    'hours' => $hours,
                    'subnav' => collect([['label' => 'Top Stories', 'target' => '#Top Stories']])->concat($blockHeadings)->all(),
                ];
                break;

            case $types->search('Publications'):
                $publications = PrintedPublication::published()->get()->merge(DigitalPublication::published()->get())->sortByDesc('publish_start_date');
                $filters = $item->labels?->get('filters')
                    ? collect($item->labels->get('filters'))->map(function ($filterId) {
                        $category = CatalogCategory::find($filterId);
                        return $category ? [
                            'label' => $category->name,
                            'value' => Str::kebab(Str::lower($category->name))
                        ] : null;
                    })->filter()->values()->toArray()
                    : [];
                $primaryFilters = array_merge(
                    [
                        [
                            'label' => 'All Publications',
                            'value' => 'all'
                        ],
                        [
                            'label' => 'Digital Publications',
                            'value' => 'digital-publication'
                        ],
                        [
                            'label' => 'Printed Publications',
                            'value' => 'printed-publication'
                        ]
                    ],
                    $filters
                );

                // Get all active categories
                $allCategories = $this->getItemCategories($publications);

                // Filter out categories that exist in primaryFilters
                $primaryFilterValues = collect($primaryFilters)->pluck('value')->toArray();
                $categories = collect($allCategories)->filter(function ($category) use ($primaryFilterValues) {
                    return !in_array($category['data-button-value'], $primaryFilterValues);
                })->values()->toArray();

                $publicationResourcesItems = collect($item->publicationResources()->pluck('resource_title', 'resource_target'))
                ->filter(function ($title, $target) {
                    return !empty($target);
                });

                $publicationResourceLinks = collect();
                if (count($publicationResourcesItems) > 0) {
                    $publicationResourceLinks = $publicationResourcesItems->map(function ($title, $target) {
                        return [
                            'label' => $title,
                            'target' => $target
                        ];
                    });
                }

                $viewData = [
                    'publications' => $publications,
                    'publicationResources' => $item->publicationResources,
                    'primaryFilters' => $primaryFilters,
                    'categories' => $categories,
                    'sortOptions' => [
                        [
                            'label' => 'Newest To Oldest',
                            'active' => request()->get('sort') == 'datetime::desc',
                            'ajaxScrollTarget' => 'listing',
                            'id' => null,
                            'data-button-value' => 'datetime::desc'
                        ],
                        [
                            'label' => 'Oldest To Newest',
                            'active' => request()->get('sort') == 'datetime::asc',
                            'ajaxScrollTarget' => 'listing',
                            'id' => null,
                            'data-button-value' => 'datetime::asc'
                        ],
                        [
                            'label' => 'Alphabetically',
                            'active' => request()->get('sort') == 'title::desc',
                            'ajaxScrollTarget' => 'listing',
                            'id' => null,
                            'data-button-value' => 'title::desc'
                        ],
                    ],
                    'subnav' => collect($blockHeadings)
                    ->concat([['label' => 'Publications', 'target' => '#Publications']])
                    ->concat($publicationResourceLinks->toArray())
                    ->concat([['label' => 'Resources', 'target' => '#Resources'], ['label' => 'Shop<svg aria-hidden="true" class="icon--arrow"><use xlink:href="#icon--arrow"></use></svg>', 'target' => 'https://shop.artic.edu']])
                    ->all(),
                ];
                break;
            case $types->search('Conservation and Science'):
                $viewData = [
                    'subnav' => collect($blockHeadings),
                ];
                break;

            default:
                $viewData = array();
                break;
        }
        $viewLabels = $item->labels?->toArray() ?? [];

        return array_merge($commonViewData, $viewData, $viewLabels);
    }

    protected function setPageMetaData($item)
    {
        return [
            'type' => 'page',
            'tags' => $item->categories->implode(','),
            'authors' => implode(',', $this->seo->citationAuthor),
            'publish-date' => $item->date->toDateString(),
        ];
    }

    private function getLightboxes()
    {
        $activeLightboxes = Lightbox::orderBy('lightbox_start_date', 'DESC')
            ->where('lightbox_start_date', '<=', Carbon::today())
            ->where('lightbox_end_date', '>=', Carbon::today())
            ->published()
            ->get();

        if (!$activeLightboxes || $activeLightboxes->count() < 1) {
            return null;
        }

        $forAllLightbox = $activeLightboxes->firstWhere('geotarget', Lightbox::GEOTARGET_ALL);

        if (!$forAllLightbox) {
            $forAllLightbox = $activeLightboxes->firstWhere('geotarget', null);
        }

        if ($forAllLightbox) {
            return collect([$this->getLightbox($forAllLightbox)]);
        }

        $displayedLightboxes = collect([
            $activeLightboxes->firstWhere('geotarget', Lightbox::GEOTARGET_LOCAL),
            $activeLightboxes->firstWhere('geotarget', Lightbox::GEOTARGET_NOT_LOCAL),
        ])->filter()->map(function ($lightbox) {
            return $this->getLightbox($lightbox);
        });

        if ($displayedLightboxes->count() > 0) {
            return $displayedLightboxes;
        }

        return collect([$this->getLightbox($activeLightboxes->first())]);
    }


    private function getLightbox($lightbox)
    {
        return [
            'title' => $lightbox->header,
            'subheader' => $lightbox->subheader,
            'intro' => $lightbox->body,
            'action_url' => $lightbox->action_url,
            'form_id' => $lightbox->form_id,
            'form_token' => $lightbox->form_token,
            'form_tlc_source' => $lightbox->form_tlc_source,
            'lightbox_button_text' => $lightbox->lightbox_button_text,
            'variation' => $lightbox->variation,
            'variation_class' => $lightbox->variation_class,
            'expiry_period' => $lightbox->expiry_period,
            'hide_fields' => $lightbox->hide_fields,
            'geotarget' => $this->getLightboxGeotarget($lightbox->geotarget),
            'terms_text' => $lightbox->terms_text,
            'image' => $lightbox->imageFront('cover'),
            'cover_caption' => $lightbox->cover_caption,
        ];
    }

    public function getEditorialHeader()
    {
        $hour = Hour::today()->first();

        $data['date'] = Carbon::now()->format('M d, Y');
        $data['hours'] = $hour->present()->getTodayStatusWithHours();

        return response()->json($data);
    }

    private function getLightboxGeotarget($value = null)
    {
        switch ($value) {
            case Lightbox::GEOTARGET_LOCAL:
                return 'local';

                break;
            case Lightbox::GEOTARGET_NOT_LOCAL:
                return 'not-local';

                break;
            case Lightbox::GEOTARGET_ALL:
                // Passthrough
            default:
                // Also catches null
                return 'all';

                break;
        }
    }

    private function getItemCategories($items)
    {
        $categories = collect();
        $categoryIds = [];

        foreach ($items as $item) {
            if ($item->categories) {
                foreach ($item->categories as $category) {
                    if (!in_array($category->id, $categoryIds)) {
                        $categories->push([
                            'label' => $category->name,
                            'active' => request()->get('category') == $category->id,
                            'ajaxScrollTarget' => 'listing',
                            'id' => $category->id,
                            'data-button-value' => Str::kebab(Str::lower($category->name))
                        ]);
                        $categoryIds[] = $category->id;
                    }
                }
            }
        }

        return $categories;
    }
}
