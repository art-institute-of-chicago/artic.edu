<?php

namespace App\Http\Controllers;

use App\Models\Lightbox;
use App\Models\Page;
use App\Repositories\PageRepository;
use Carbon\Carbon;

class PageController extends FrontController
{
    protected $repository;

    public function __construct(PageRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }

    public function show($id, $slug = null)
    {
        $item = $this->repository->published()->find((int) $id);
        $artIdeasItem = Page::forType('Art and Ideas')->first();

        if (!$item) {
            abort(404);
        }

        $canonicalPath = route('pages.show', ['id' => $item->id, 'slug' => $item->getSlug()]);

        if ($canonicalRedirect = $this->getCanonicalRedirect($canonicalPath)) {
            return $canonicalRedirect;
        }

        // Home
        $mainHomeFeatures = $item->mainHomeFeatures()->published()->limit(1)->get();
        $secondaryHomeFeatures = $item->secondaryHomeFeatures()->published()->limit(2)->get();

        $mainFeatures = $mainHomeFeatures->concat($secondaryHomeFeatures);

        // WEB-2254: Finish deprecating `homeFeatures` relationship
        if ($mainFeatures->count() < 1) {
            $mainFeatures = $item->homeFeatures()->published()->limit(3)->get();
        }

        // Visit
        $video_url = $item->file('video', 'en');

        if ($video_url) {
            $headerImage = $item->imageFront('visit_mobile');

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
            ];
        } else {
            $headerMedia = [
                'type' => 'image',
                'size' => 'hero',
                'media' => $item->imageFront('visit_hero'),
                'hideCaption' => true,
            ];
        }

        $hours = [
            'hide_hours' => $item->visit_hide_hours,
            'media' => [
                'type' => 'image',
                'size' => 's',
                'media' => $item->imageFront('visit_featured_hour'),
                'caption' => $item->visit_hour_image_caption,
            ],
            'primary' => $item->visit_hour_header,
            'secondary' => $item->visit_hour_subheader,
            'sections' => $item->featured_hours,
            'intro' => $item->visit_hour_intro
        ];

        $itemprops = [
            'name' => 'Art Institute of Chicago',
            'telephone' => '+13124433600',
            'publicAccess' => 'true',
        ];

        $contrastHeader = false;
        $filledLogo = false;
        $title = '';
        if ($item->type === Page::PAGE_TYPE_HOME) {
            $this->seo->setTitle("Downtown Chicago's #1 Museum");
            $this->seo->setDescription("Located downtown by Millennium Park, this top art museum is TripAdvisor's #1 Chicago attraction—a must when visiting the city.");
            $contrastHeader = sizeof($mainFeatures) > 0;
            $filledLogo = sizeof($mainFeatures) > 0;
        } elseif ($item->type === Page::PAGE_TYPE_VISIT) {
            $this->seo->setTitle('Visit a Chicago Landmark');
            $this->seo->setDescription('Looking for things to do in Downtown Chicago? Plan your visit, find admission pricing, hours, directions, parking & more!');
            $this->seo->setImage($item->imageFront('visit_hero') ?? $item->imageFront('visit_mobile'));
            $contrastHeader = true;
            $filledLogo = true;
            $title = __('Visit');
        } elseif ($item->type === Page::PAGE_TYPE_RESEARCH_LANDING) {
            $this->seo->setTitle('Research & Resources');
            $this->seo->setDescription($item->resources_landing_intro);
            $this->seo->setImage($item->imageFront('research_landing_image'));
            $title = 'The Collection';
        }

        $view_data = [
            'item' => $item,
            'contrastHeader' => $contrastHeader,
            'filledLogo' => $filledLogo,
            'title' => $title,

            // Home
            'mainFeatures' => $mainFeatures,
            'intro' => $item->home_intro,
            'visit_button_text' => $item->home_visit_button_text ?? 'Visit',
            'visit_button_url' => $item->home_visit_button_url ?? route('visit'),
            'plan_your_visit_link_1_text' => $item->home_plan_your_visit_link_1_text,
            'plan_your_visit_link_1_url' => $item->home_plan_your_visit_link_1_url,
            'plan_your_visit_link_2_text' => $item->home_plan_your_visit_link_2_text,
            'plan_your_visit_link_2_url' => $item->home_plan_your_visit_link_2_url,
            'plan_your_visit_link_3_text' => $item->home_plan_your_visit_link_3_text,
            'plan_your_visit_link_3_url' => $item->home_plan_your_visit_link_3_url,
            'cta_module_image' => $item->imageFront('home_cta_module_image'),
            'cta_module_action_url' => $item->home_cta_module_action_url,
            'cta_module_header' => $item->home_cta_module_header,
            'cta_module_button_text' => $item->home_cta_module_button_text,
            'cta_module_body' => $item->home_cta_module_body,
            'roadblocks' => $this->getLightboxes(),

            // Visit
            'primaryNavCurrent' => 'visit',
            'headerMedia' => $headerMedia,
            'hours' => $hours,
            'itemprops' => $itemprops,

            // Research
            'primaryNavCurrent' => 'collection',
            'intro' => $artIdeasItem->art_intro,
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

        return view('site.pageDetail', $view_data);
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
