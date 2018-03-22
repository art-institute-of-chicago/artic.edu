<?php

namespace App\Http\Controllers;

use App\Models\Page;

use Illuminate\Http\Request;

class VisitController extends FrontController
{

    public function index()
    {
        $page = Page::forType('Visit')->first();

        $headerMedia = array(
          'type' => 'image',
          'size' => 'hero',
          'media' => $page->imageFront('visit_hero'),
          'hideCaption' => true,
         );

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

        // $admission = array(
        //     'text' => $this->faker->paragraph(3),
        //     'cityPass' => array(
        //         'title' => 'CityPass',
        //         'text' => $this->faker->paragraph(3),
        //         'image' => $this->getImage(400,225),
        //         'link' => array(
        //             'label' => 'Get CityPass',
        //             'href' => '#',
        //         ),
        //     ),
        //     'ageGroups' => array(
        //         array(
        //             'title' => 'Adults',
        //             'prices' => array(
        //                 'generalAdmission' => '$25',
        //                 'chicagoResidents' => '$20',
        //                 'illonoisResidents' => '$20',
        //                 'fastPass' => '$35',
        //             ),
        //         ),
        //         array(
        //             'title' => 'Seniors',
        //             'subtitle' => '65+',
        //             'prices' => array(
        //                 'generalAdmission' => '$19',
        //                 'chicagoResidents' => '$14',
        //                 'illonoisResidents' => '$16',
        //                 'fastPass' => '$29',
        //             ),
        //         ),
        //         array(
        //             'title' => 'Students',
        //             'prices' => array(
        //                 'generalAdmission' => '$19',
        //                 'chicagoResidents' => '$14',
        //                 'illonoisResidents' => '$16',
        //                 'fastPass' => '$29',
        //             ),
        //         ),
        //         array(
        //             'title' => 'Teens',
        //             'subtitle' => '14-17',
        //             'prices' => array(
        //                 'generalAdmission' => '$19',
        //                 'chicagoResidents' => 'Free',
        //                 'illonoisResidents' => '$16',
        //                 'fastPass' => '$19',
        //             ),
        //         ),
        //     ),
        // );

        // $directions = array(
        //     'intro' => $this->faker->paragraph(),
        //     'image' => array(
        //         'type' => 'image',
        //         'size' => 's',
        //         'media' => $this->getImage(800,800),
        //         'hideCaption' => true,
        //     ),
        //     'text' => array(
        //         array(
        //             "type" => 'text',
        //             "subtype" => 'secondary',
        //             "content" => $this->generateParagraph()
        //         ),
        //         array(
        //             "type" => 'text',
        //             "subtype" => 'secondary',
        //             "content" => $this->generateParagraph()
        //         ),
        //     ),
        //     'links' => array(
        //         array(
        //           'href' => '#',
        //           'label' => $this->faker->sentence(2),
        //         ),
        //         array(
        //           'href' => '#',
        //           'label' => $this->faker->sentence(2),
        //         ),
        //     ),
        // );

        return view('site.visit', [
          'primaryNavCurrent' => 'visit',
          'title' => $page->title,
          'contrastHeader' => true,
          'filledLogo' => true,
          'headerMedia' => $headerMedia,
          'hours' => $hours,
          // 'admission' => $admission,
          // 'directions' => $directions,
        ]);
    }

}
