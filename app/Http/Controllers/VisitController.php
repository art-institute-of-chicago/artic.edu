<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Fee;

use Illuminate\Http\Request;

class VisitController extends FrontController
{

    public function index()
    {
        $page = Page::forType('Visit')->first();


        $video_url = $page->file('video');
        if ($video_url)  {
            $headerImage = $page->imageFront('visit_hero');

            $poster_url = isset($headerImage['src']) ? $headerImage['src'] : '';
            $video = [
                'src' => $video_url,
                'poster' => $poster_url,
                'fallbackImage' => $headerImage
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

        $ageGroups = array();
        $ageName = '';
        $prices = array();
        $keys = array();
        $titles = array();
        $i = 0;
        foreach(Fee::orderBy('fee_age_id')->get() as $admission){
            if ($admission->fee_category) {
                $key = strtolower(str_replace(' ', '', $admission->fee_category->title));
                $title = $admission->fee_category->title;
                $tooltip = $admission->fee_category->tooltip;
                if($ageName !== $admission->fee_age->title){

                    if($ageName !== ''){
                        array_push($ageGroups, array('title' => $ageName, 'prices' => $prices));
                    }

                    $ageName = $admission->fee_age->title;
                    $prices = array();
                    $i = 0;
                };
                $prices[$key] = $admission->price;
                $titles[$i] = array('title' => $title, 'tooltip' => $tooltip);
                $keys[$i] = $key;
                $i += 1;
            }
        };
        array_push($ageGroups, array('title' => $ageName, 'prices' => $prices));

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
            'ageGroups' => $ageGroups,
            'keys' => $keys,
            'titles' => $titles,
            'become_member' => array(
                'label' => $page->visit_become_member_label,
                'link' => $page->visit_become_member_link
            ),
            'buy_tickets' => array(
                'label' => $page->visit_buy_tickets_label,
                'link' => $page->visit_buy_tickets_link
            )
        );
        $dining = array();
        foreach ($page->dining_hours as $hour) {
          array_push($dining, array(
            'image' => $hour->imageFront('dining_cover'),
            'title' => $hour->name,
            'text' => $hour->hours
          ));
        };

        $directions = array(
            'intro' => 'Located in the heart of the Chicago—across from Millennium Park and steps from Lake Michigan—the Art Institute welcomes visitors at two entrances.',
            'image' => $page->imageFront('visit_map'),
            'locations' => $page->locations,
            'links' => array(
                array(
                  'href' => $page->visit_parking_link,
                  'label' => 'Directions & Parking',
                ),
                array(
                  'href' => $page->visit_transportation_link,
                  'label' => 'Public Transportation',
                ),
            ),
        );

        $questions = array();
        foreach ($page->faqs as $faq) {
          array_push($questions, array(
            'label' => $faq->title,
            'href' => $faq->link
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
            ))
          ));
        };

        $tours = [];
        foreach($page->visitTourPages as $item) {
            $links = [];
            foreach($item->children as $child) {
                array_push($links, array(
                    'href' => $child->url,
                    'label' => $child->title,
                  ));
            }
            array_push($tours, array(
                  'title' => $item->title,
                  'titleLink' => $item->url,
                  'image' => $item->imageFront('listing'),
                  'links' => $links
              ));
        }

        $itemprops = [
            'name'             => 'Art Institute of Chicago',
            'telephone'        => '+13124433600',
            'publicAccess'     => 'true',
        ];

        return view('site.visit', [
          'primaryNavCurrent' => 'visit',
          'title' => $page->title,
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
