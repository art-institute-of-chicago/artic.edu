<?php

namespace App\Http\Controllers;

use App\Models\Page;

use Illuminate\Http\Request;

class VisitController extends FrontController
{

    public function index()
    {
        $page = Page::forType('Visit')->first();

        $headerMedia = $page->imageFront('visit_hero');

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

        $admission = array(
            'text' => 'Become a member Text',
            'cityPass' => array(
                'title' => $page->visit_city_pass_title,
                'text' => $page->visit_city_pass_text,
                'image' => $page->imageFront('visit_city_pass'),
                'link' => array(
                    'label' => $page->visit_city_pass_button_label,
                    'href' => $page->visit_city_pass_link,
                ),
            ),
            'ageGroups' => array(
                array(
                    'title' => 'Adults',
                    'prices' => array(
                        'generalAdmission' => '$25',
                        'chicagoResidents' => '$20',
                        'illonoisResidents' => '$20',
                        'fastPass' => '$35',
                    ),
                ),
                array(
                    'title' => 'Seniors',
                    'subtitle' => '65+',
                    'prices' => array(
                        'generalAdmission' => '$19',
                        'chicagoResidents' => '$14',
                        'illonoisResidents' => '$16',
                        'fastPass' => '$29',
                    ),
                ),
                array(
                    'title' => 'Students',
                    'prices' => array(
                        'generalAdmission' => '$19',
                        'chicagoResidents' => '$14',
                        'illonoisResidents' => '$16',
                        'fastPass' => '$29',
                    ),
                ),
                array(
                    'title' => 'Teens',
                    'subtitle' => '14-17',
                    'prices' => array(
                        'generalAdmission' => '$19',
                        'chicagoResidents' => 'Free',
                        'illonoisResidents' => '$16',
                        'fastPass' => '$19',
                    ),
                ),
            ),
        );
        $dining = array();
        foreach ($page->dining_hours as $hour) {
          array_push($dining, array(
            'image' => $hour->imageFront('cover'),
            'title' => $hour->name,
            'text' => $hour->hours
          ));
        }

        $directions = array(
            'intro' => 'Located in the heart of the Chicago-across from Millenium Park and steps from Lake Michigan-the Art Institute wecomes visitors at two entrances',
            'image' => $page->imageFront('visit_map'),
            'locations' => $page->locations,
            'links' => array(
                array(
                  'href' => $page->visit_parking_link,
                  'label' => 'Direction & Parking',
                ),
                array(
                  'href' => $page->visit_transportation_link,
                  'label' => 'Public Transportation',
                ),
            ),
        );

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
        ]);
    }

}
