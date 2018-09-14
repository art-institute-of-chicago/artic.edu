<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\FeeAge;
use App\Models\FeeCategory;
use App\Models\Page;
use Illuminate\Http\Request;

class VisitController extends FrontController
{

    public function index()
    {
        app()->setLocale(request('lang') ?? 'en');

        config(['translatable.use_fallback' => true]);

        $page = Page::forType('Visit')->first();

        $this->seo->setTitle("Visit a Chicago Landmark");
        $this->seo->setDescription("Looking for things to do in Downtown Chicago? Plan your visit, find admission pricing, hours, directions, parking & more!");
        $this->seo->setImage($page->imageFront('visit_hero') ?? $page->imageFront('visit_mobile'));

        $video_url = $page->file('video', 'en');

        if ($video_url) {
            $headerImage = $page->imageFront('visit_mobile');

            $poster_url = isset($headerImage['src']) ? $headerImage['src'] : '';
            $video = [
                'src' => $video_url,
                'poster' => $poster_url,
                'fallbackImage' => $headerImage,
            ];

            $headerMedia = array(
                'type' => 'video',
                'size' => 'hero',
                'media' => $video,
                'hideCaption' => true,
            );
        } else {
            $headerMedia = array(
                'type' => 'image',
                'size' => 'hero',
                'media' => $page->imageFront('visit_hero'),
                'hideCaption' => true,
            );
        }

        $hours = array(
            'media' => array(
                'type' => 'image',
                'size' => 's',
                'media' => $page->imageFront('visit_featured_hour'),
                'hideCaption' => true,
            ),
            'primary' => $page->visit_hour_header,
            'secondary' => $page->visit_hour_subheader,
            'sections' => $page->featured_hours,
        );

        // Get prices grid for admissions
        // This should be moved away from the controller.
        $fees = Fee::all();
        $prices = [];
        $titles = [];
        foreach (FeeCategory::ordered()->get() as $category) {
            $titles[$category->id]['title'] = $category->title;
            $titles[$category->id]['id'] = str_slug($category->title);
            $titles[$category->id]['tooltip'] = $category->tooltip;

            foreach (FeeAge::ordered()->get() as $age) {
                $fee = $fees->where('fee_age_id', $age->id)->where('fee_category_id', $category->id)->first();

                if ($fee) {
                    $prices[$age->id]['title'] = $age->title;
                    $prices[$age->id]['title_en'] = $age->translate('en')->title;
                    $prices[$age->id][$category->id] = $fee->price;
                }
            }
        }

        $admission = array(
            'text' => preg_replace('/<p>/i', '<p class="f-secondary">', $page->visit_admission_description),
            'cityPass' => array(
                'title' => $page->visit_city_pass_title,
                'text' => $page->visit_city_pass_text,
                'image' => $page->imageFront('visit_city_pass'),
                'link' => array(
                    'label' => $page->visit_city_pass_button_label,
                    'href' => $page->visit_city_pass_link,
                ),
            ),
            'titles' => $titles,
            'prices' => $prices,
            'become_member' => array(
                'label' => $page->visit_become_member_label,
                'link' => $page->visit_become_member_link,
            ),
            'buy_tickets' => array(
                'label' => $page->visit_buy_tickets_label,
                'link' => $page->visit_buy_tickets_link,
            ),
        );
        $dining = array();
        foreach ($page->dining_hours as $hour) {
            array_push($dining, array(
                'image' => $hour->imageFront('dining_cover'),
                'title' => $hour->name,
                'text' => $hour->accessible_hours,
            ));
        };

        $directions = array(
            'intro' => __('Located in the heart of Chicago—across from Millennium Park and steps from Lake Michigan—the Art Institute welcomes visitors at two entrances.'),
            'image' => $page->imageFront('visit_map'),
            'locations' => $page->locations,
            'link' => array(
                'href' => $page->visit_parking_link,
                'label' => __('Directions, Parking, and Public Transportation'),
            ),
        );

        $questions = array();
        foreach ($page->faqs as $faq) {
            array_push($questions, array(
                'label' => $faq->title,
                'href' => $faq->link,
            ));
        };

        $faq = array(
            'accesibility_link' => $page->visit_faq_accessibility_link,
            'more_link' => $page->visit_faq_more_link,
            'questions' => $questions,
        );

        $families = array();
        foreach ($page->families as $item) {
            array_push($families, array(
                'image' => $item->imageFront('family_cover'),
                'title' => $item->title,
                'text' => $item->text,
                'titleLink' => $item->associated_generic_page_link ?? $item->external_link,
                'links' => array(array(
                    'href' => $item->external_link,
                    'label' => $item->link_label,
                )),
            ));
        };

        $tours = [];
        foreach ($page->visitTourPages as $item) {
            $links = [];
            foreach ($item->children()->orderBy('position')->published()->get() as $child) {
                array_push($links, array(
                    'href' => $child->url,
                    'label' => $child->title,
                ));
            }
            array_push($tours, array(
                'title' => $item->title,
                'titleLink' => $item->url,
                'image' => $item->imageFront('listing'),
                'links' => $links,
            ));
        }

        $itemprops = [
            'name' => 'Art Institute of Chicago',
            'telephone' => '+13124433600',
            'publicAccess' => 'true',
        ];

        return view('site.visit', [
            'primaryNavCurrent' => 'visit',
            'page' => $page,
            'title' => __('Visit'),
            'contrastHeader' => true,
            'filledLogo' => true,
            'headerMedia' => $headerMedia,
            'hours' => $hours,
            'admission' => $admission,
            'dining' => $dining,
            'directions' => $directions,
            'faq' => $faq,
            'families' => $families,
            'tours' => $tours,
            'itemprops' => $itemprops,
        ]);
    }

}
