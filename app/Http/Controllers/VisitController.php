<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\FeeAge;
use App\Models\FeeCategory;
use App\Models\Page;
use Illuminate\Support\Str;

class VisitController extends FrontController
{
    public function index()
    {
        app()->setLocale(request('lang') ?? 'en');

        config(['translatable.use_fallback' => true]);

        $page = Page::forType('Visit')->first();

        $this->seo->setTitle('Visit a Chicago Landmark');
        $this->seo->setDescription('Looking for things to do in Downtown Chicago? Plan your visit, find admission pricing, hours, directions, parking & more!');
        $this->seo->setImage($page->imageFront('visit_hero') ?? $page->imageFront('visit_mobile'));

        $video_url = $page->file('video', 'en');

        if ($video_url) {
            $headerImage = $page->imageFront('visit_mobile');

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
                'media' => $page->imageFront('visit_hero'),
                'hideCaption' => true,
            ];
        }

        $hours = [
            'hide_hours' => $page->visit_hide_hours,
            'media' => [
                'type' => 'image',
                'size' => 's',
                'media' => $page->imageFront('visit_featured_hour'),
                'caption' => $page->visit_hour_image_caption,
            ],
            'primary' => $page->visit_hour_header,
            'secondary' => $page->visit_hour_subheader,
            'sections' => $page->featured_hours,
            'intro' => $page->visit_hour_intro
        ];

        $expects = [];
        foreach ($page->whatToExpects as $item) {
            array_push($expects, [
                'iconType' => $item->icon_type,
                'text' => $item->text,
            ]);
        }
        $whatToExpect = [
            'more_link' => $page->visit_what_to_expect_more_link,
            'more_text' => $page->visit_what_to_expect_more_text,
            'items' => $expects,
        ];

        // Get prices grid for admissions
        // WEB-2256: This should be moved away from the controller.
        $fees = Fee::all();
        $prices = [];
        $titles = [];
        foreach (FeeCategory::ordered()->get() as $category) {
            $titles[$category->id]['title'] = $category->title;
            $titles[$category->id]['id'] = Str::slug($category->title);
            $titles[$category->id]['tooltip'] = $category->tooltip;

            foreach (FeeAge::ordered()->get() as $age) {
                $fee = $fees->where('fee_age_id', $age->id)->where('fee_category_id', $category->id)->first();

                if ($fee) {
                    $prices[$age->id]['title'] = $age->title;
                    $prices[$age->id]['title_en'] = $age->title;
                    $prices[$age->id][$category->id] = $fee->price;
                }
            }
        }

        $citypassImg = $page->imageFront('visit_city_pass');
        $citypassImg['alt'] = '';

        $admission = [
            'text' => preg_replace('/<p>/i', '<p class="f-secondary">', $page->visit_admission_description),
            'cityPass' => [
                'title' => $page->visit_city_pass_title,
                'text' => $page->visit_city_pass_text,
                'image' => $citypassImg,
                'link' => [
                    'label' => $page->visit_city_pass_button_label,
                    'href' => $page->visit_city_pass_link,
                ],
            ],
            'titles' => $titles,
            'prices' => $prices,
            'become_member' => [
                'label' => $page->visit_become_member_label,
                'link' => $page->visit_become_member_link,
            ],
            'buy_tickets' => [
                'label' => $page->visit_buy_tickets_label,
                'link' => $page->visit_buy_tickets_link,
            ],
        ];

        $directions = [
            'intro' => __('Located in the heart of Chicago—across from Millennium Park and steps from Lake Michigan—the Art Institute welcomes visitors at two entrances.'),
            'image' => $page->imageFront('visit_map'),
            'locations' => $page->locations,
            'link' => [
                'href' => $page->visit_parking_link,
                'label' => __('Directions, Parking, and Public Transportation'),
            ],
            'accessibility_link' => [
                'href' => $page->visit_parking_accessibility_link,
                'label' => __('Visitors with Mobility Needs'),
            ],
        ];

        $questions = [];
        foreach ($page->faqs as $faq) {
            array_push($questions, [
                'label' => $faq->title,
                'href' => $faq->link,
            ]);
        }

        $faq = [
            'accesibility_link' => $page->visit_faq_accessibility_link,
            'more_link' => $page->visit_faq_more_link,
            'questions' => $questions,
        ];

        $accessibility = [
            'image' => $page->imageFront('visit_accessibility'),
            'text' => $page->visit_accessibility_text,
            'link_text' => $page->visit_accessibility_link_text,
            'link_url' => $page->visit_accessibility_link_url,
        ];

        $explore = [];
        foreach ($page->families as $item) {
            array_push($explore, [
                'image' => $item->imageFront('family_cover'),
                'title' => $item->title,
                'text' => $item->text,
                'titleLink' => $item->associated_generic_page_link ?? $item->external_link,
                'links' => [[
                    'href' => $item->external_link,
                    'label' => $item->link_label,
                ]],
            ]);
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
            'whatToExpect' => $whatToExpect,
            'admission' => $admission,
            'directions' => $directions,
            'faq' => $faq,
            'accessibility' => $accessibility,
            'explore' => $explore,
            'itemprops' => $itemprops,
        ]);
    }
}
