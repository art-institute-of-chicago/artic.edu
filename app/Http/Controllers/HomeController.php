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
        $products    = $page->apiModels('homeShopItems', 'ShopItem');
        $events      = $page->homeEvents()->future()->published()->limit(4)->get();

        $mainHomeFeatures       = $page->mainHomeFeatures()->published()->limit(1)->get();
        $secondaryHomeFeatures  = $page->secondaryHomeFeatures()->published()->limit(2)->get();

        $mainFeatures = $mainHomeFeatures->concat($secondaryHomeFeatures);

        // TODO: Finish deprecating `homeFeatures` relationship
        if ($mainFeatures->count() < 1) {
            $mainFeatures = $page->homeFeatures()->published()->limit(3)->get();
        }

        $collectionFeatures = $page->collectionFeatures()->published()->get();

        $view_data = [
            'contrastHeader' => sizeof($mainFeatures) > 0,
            'filledLogo'     => sizeof($mainFeatures) > 0,
            'mainFeatures' => $mainFeatures,
            'intro' => $page->home_intro,
            'exhibitions' => $exhibitions,
            'events' => $events,
            'theCollection' => $collectionFeatures,
            'products' => $products,
            'membership_module_image' => $page->imageFront('home_membership_module_image'),
            'membership_module_url' => $page->home_membership_module_url,
            'membership_module_headline' =>  $page->home_membership_module_headline,
            'membership_module_button_text' => $page->home_membership_module_button_text,
            'membership_module_short_copy' => $page->home_membership_module_short_copy,
            'roadblocks' => $this->getLightboxes(),
        ];

        return view('site.home', $view_data);
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
        ])->filter()->map(function($lightbox) {
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
                // passthrough
            default:
                // also catches null
                return 'all';
                break;
        }
    }

}
