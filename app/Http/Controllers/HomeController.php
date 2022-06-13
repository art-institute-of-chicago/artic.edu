<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Lightbox;

use Carbon\Carbon;

class HomeController extends FrontController
{
    public function index()
    {
        $this->seo->setTitle("Downtown Chicago's #1 Museum");
        $this->seo->setDescription("Located downtown by Millennium Park, this top art museum is TripAdvisor's #1 Chicago attraction—a must when visiting the city.");

        $page = Page::forType('Home')->first();

        $exhibitions = $page->apiModels('homeExhibitions', 'Exhibition');
        $products = $page->apiModels('homeShopItems', 'ShopItem');
        $homeArtworks = $page->apiModels('homeArtworks', 'Artwork');

        $events = $page->homeEvents()->future()->published()->limit(4)->get();

        $mainHomeFeatures = $page->mainHomeFeatures()->published()->limit(1)->get();
        $secondaryHomeFeatures = $page->secondaryHomeFeatures()->published()->limit(2)->get();

        $mainFeatures = $mainHomeFeatures->concat($secondaryHomeFeatures);

        // WEB-2254: Finish deprecating `homeFeatures` relationship
        if ($mainFeatures->count() < 1) {
            $mainFeatures = $page->homeFeatures()->published()->limit(3)->get();
        }

        $view_data = [
            'contrastHeader' => sizeof($mainFeatures) > 0,
            'filledLogo' => sizeof($mainFeatures) > 0,
            'mainFeatures' => $mainFeatures,
            'intro' => $page->home_intro,
            'visit_button_text' => $page->home_visit_button_text ?? 'Visit',
            'visit_button_url' => $page->home_visit_button_url ?? route('visit'),
            'plan_your_visit_link_1_text' => $page->home_plan_your_visit_link_1_text,
            'plan_your_visit_link_1_url' => $page->home_plan_your_visit_link_1_url,
            'plan_your_visit_link_2_text' => $page->home_plan_your_visit_link_2_text,
            'plan_your_visit_link_2_url' => $page->home_plan_your_visit_link_2_url,
            'plan_your_visit_link_3_text' => $page->home_plan_your_visit_link_3_text,
            'plan_your_visit_link_3_url' => $page->home_plan_your_visit_link_3_url,
            'exhibitions' => $exhibitions,
            'events' => $events,
            'artworks' => $homeArtworks,
            'products' => $products,
            'cta_module_image' => $page->imageFront('home_cta_module_image'),
            'cta_module_action_url' => $page->home_cta_module_action_url,
            'cta_module_header' => $page->home_cta_module_header,
            'cta_module_button_text' => $page->home_cta_module_button_text,
            'cta_module_body' => $page->home_cta_module_body,
            'roadblocks' => $this->getLightboxes(),
            'video_title' => $page->home_video_title,
            'video_description' => $page->home_video_description,
            'videos' => $page->getRelated('homeVideos')->where('published', true),
            'highlights' => $page->getRelated('homeHighlights')->where('published', true),
            'homeArtists' => $page->homeArtists,
            'articles' => $this->getArticles(),
            'experiences' => $this->getExperiences(),
        ];

        return view('site.home', $view_data);
    }

    private function getArticles()
    {
        $page = Page::forType('Articles and Publications')->first();
        $articles = $page->getRelatedWithApiModels('featured_items', [], [
            'articles' => false,
            'experiences' => false
        ]) ?? null;

        return [
            'featureHero' => $articles->shift(),
            'features' => $articles,
        ];
    }

    private function getExperiences()
    {
        $page = Page::forType('Articles and Publications')->first();

        return $page->experiences()->webPublished()->notUnlisted()->get();
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
