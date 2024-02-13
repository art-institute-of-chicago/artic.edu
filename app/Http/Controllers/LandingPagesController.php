<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\Hour;
use App\Models\Lightbox;
use App\Models\LandingPage;
use App\Helpers\StringHelpers;
use App\Repositories\LandingPageRepository;
use Carbon\Carbon;

class LandingPagesController extends FrontController
{
    protected $landingPageRepository;

    public function __construct(LandingPageRepository $landingPageRepository)
    {
        $this->landingPageRepository = $landingPageRepository;

        parent::__construct();
    }
    public function show($id, $slug = null)
    {
        $item = $this->landingPageRepository->published()->findOrFail((int) $id);
        $canonicalPath = route('landingPages.show', ['id' => $item->id, 'slug' => $item->getSlug()]);
        if ($canonicalRedirect = $this->getCanonicalRedirect($canonicalPath)) {
            return $canonicalRedirect;
        }
        return view('site.landingPageDetail', $this->viewData($item));
    }

    public function viewData($item)
    {
        $types = collect(LandingPage::TYPES);

        $admission = new Admission();

        $feeTitles = $admission->present()->feeTitles();
        $feePrices = $admission->present()->feePrices();

        if (!$item->is_published) {
            $this->seo->nofollow = true;
            $this->seo->noindex = true;
        }

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

        switch ($item->type_id) {
            case $types->search('Home'):
                $this->seo->setTitle($item->meta_title ?: $item->title ?: "Downtown Chicago's #1 Museum");
                $this->seo->setDescription($item->meta_description ?: "Located downtown by Millennium Park, this top art museum is TripAdvisor's #1 Chicago attraction—a must when visiting the city.");
                break;

            case $types->search('Visit'):
                $this->seo->setTitle($item->meta_title ?: $item->title ?: 'Visit a Chicago Landmark');
                $this->seo->setDescription($item->meta_description ?: 'Looking for things to do in Downtown Chicago? Plan your visit, find admission pricing, hours, directions, parking & more!');
                $this->seo->setImage($item->imageFront('hero') ?? $item->imageFront('visit_mobile'));
                $title = __('Visit');
                break;

            case $types->search('Research and Resources'):
                $this->seo->setTitle($item->meta_title ?: $item->title ?: 'Research & Resources');
                $this->seo->setDescription($item->resources_landing_intro);
                $this->seo->setImage($item->imageFront('research_landing_image'));
                $title = 'The Collection';
                break;

            default:
                $this->seo->setTitle($item->meta_title ?: $item->title);
                $this->seo->setDescription($item->meta_description);
                $this->seo->setImage($item->imageFront('hero') ?? $item->imageFront('mobile_hero'));
                $title = $item->title;
                break;
        }

        $commonViewData = [
            'item' => $item,
            'contrastHeader' => false,
            'headerMedia' => $headerMedia,
            'mainFeatures' => $mainFeatures,
            'socialLinks' => $item->socialLinks,
            'filledLogo' => false,
            'title' => $title,
            'intro' => $item->intro,
            'landingPageType' => StringHelpers::pageBlades($item->type),
        ];

        $blockHeadings = $item->blocks->pluck('content')->pluck('heading')->filter();

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

            case $types->search('Research and Resources'):
                $viewData = [
                    'primaryNavCurrent' => 'collection',
                    'intro' => $item->labels->get('resources_landing_intro'),
                    'linksBar' => [
                        [
                            'href' => route('collection'),
                            'label' => 'Artworks',
                        ],
                        [
                            'href' => route('articles_publications'),
                            'label' => 'Writings',
                        ],
                        [
                            'href' => route('collection.research_resources'),
                            'label' => 'Resources',
                            'active' => true,
                        ],
                    ],
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
}
