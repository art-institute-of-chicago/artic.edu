<?php

namespace App\Http\Controllers;

use App\Presenters\StaticObjectPresenter;
use Faker\Generator as Faker;
use LakeviewImageService;

use A17\Models\Hour;
use App\Models\Page;

use Illuminate\Http\Request;

class VisitController extends FrontController
{


      protected $faker;

      function __construct(Faker $faker) {
          $this->faker = $faker;

          parent::__construct();
      }



    public function index()
    {
        $page = Page::forType('Visit')->first();

        $headerMedia = $page->visit_hero;

        $hours = array(
            'media' => array(
                'type' => 'image',
                'size' => 's',
                'media' => $this->getImage(800,450),
                'hideCaption' => true,
            ),
            'primary' => $this->faker->sentence(8),
            'secondary' => $this->faker->sentence(8),
            'sections' => array(
                array(
                    'title' => $this->faker->sentence(3),
                    'link' => '#',
                    'text' => $this->faker->sentence(8),
                ),
                array(
                    'title' => $this->faker->sentence(3),
                    'link' => '#',
                    'text' => $this->faker->sentence(8),
                ),
                array(
                    'title' => $this->faker->sentence(3),
                    'link' => '#',
                    'text' => $this->faker->sentence(8),
                ),
             )
        );

        $admission = array(
            'text' => $this->faker->paragraph(3),
            'cityPass' => array(
                'title' => 'CityPass',
                'text' => $this->faker->paragraph(3),
                'image' => $this->getImage(400,225),
                'link' => array(
                    'label' => 'Get CityPass',
                    'href' => '#',
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

        $directions = array(
            'intro' => $this->faker->paragraph(),
            'image' => array(
                'type' => 'image',
                'size' => 's',
                'media' => $this->getImage(800,800),
                'hideCaption' => true,
            ),
            'text' => array(
                array(
                    "type" => 'text',
                    "subtype" => 'secondary',
                    "content" => $this->generateParagraph()
                ),
                array(
                    "type" => 'text',
                    "subtype" => 'secondary',
                    "content" => $this->generateParagraph()
                ),
            ),
            'links' => array(
                array(
                  'href' => '#',
                  'label' => $this->faker->sentence(2),
                ),
                array(
                  'href' => '#',
                  'label' => $this->faker->sentence(2),
                ),
            ),
        );

        return view('site.visit', [
          'primaryNavCurrent' => 'visit',
          'title' => 'Plan Your Visit',
          'contrastHeader' => true,
          'filledLogo' => true,
          'headerMedia' => $headerMedia,
          'hours' => $hours,
          'admission' => $admission,
          'directions' => $directions,
          'dining' => array(
            'options' => $this->generateDiningOptions(),
          ),
          'faq' => array(
            'questions' => array(
                array(
                  'href' => '#',
                  'label' => $this->faker->sentence(2),
                ),
                array(
                  'href' => '#',
                  'label' => $this->faker->sentence(2),
                ),
                array(
                  'href' => '#',
                  'label' => $this->faker->sentence(2),
                ),
                array(
                  'href' => '#',
                  'label' => $this->faker->sentence(2),
                ),
            ),
          ),
          'tours' => array(
                array(
                    'title' => $this->faker->sentence(2),
                    'titleLink' => '#',
                    'image' => $this->getImage(400,225),
                    'links' => array(
                        array(
                          'href' => '#',
                          'label' => $this->faker->sentence(2),
                        ),
                        array(
                          'href' => '#',
                          'label' => $this->faker->sentence(2),
                        ),
                        array(
                          'href' => '#',
                          'label' => $this->faker->sentence(2),
                        ),
                        array(
                          'href' => '#',
                          'label' => $this->faker->sentence(2),
                        ),
                    )
                ),
                array(
                    'title' => $this->faker->sentence(2),
                    'titleLink' => '#',
                    'image' => $this->getImage(400,225),
                    'links' => array(
                        array(
                          'href' => '#',
                          'label' => $this->faker->sentence(2),
                        ),
                        array(
                          'href' => '#',
                          'label' => $this->faker->sentence(2),
                        ),
                    )
                ),
                array(
                    'title' => $this->faker->sentence(2),
                    'titleLink' => '#',
                    'image' => $this->getImage(400,225),
                    'links' => array(
                        array(
                          'href' => '#',
                          'label' => $this->faker->sentence(2),
                        ),
                        array(
                          'href' => '#',
                          'label' => $this->faker->sentence(2),
                        ),
                        array(
                          'href' => '#',
                          'label' => $this->faker->sentence(2),
                        ),
                    )
                ),
           ),
          'familiesTeensEducators' => array(
                array(
                    'title' => $this->faker->sentence(2),
                    'titleLink' => '#',
                    'image' => $this->getImage(400,225),
                    'text' => $this->faker->paragraph(3),
                    'links' => array(
                        array(
                          'href' => '#',
                          'label' => $this->faker->sentence(2),
                        ),
                    )
                ),
                array(
                    'title' => $this->faker->sentence(2),
                    'titleLink' => '#',
                    'image' => $this->getImage(400,225),
                    'text' => $this->faker->paragraph(3),
                    'links' => array(
                        array(
                          'href' => '#',
                          'label' => $this->faker->sentence(2),
                        ),
                    )
                ),
                array(
                    'title' => $this->faker->sentence(2),
                    'titleLink' => '#',
                    'image' => $this->getImage(400,225),
                    'text' => $this->faker->paragraph(3),
                    'links' => array(
                        array(
                          'href' => '#',
                          'label' => $this->faker->sentence(2),
                        ),
                    )
                ),
           ),
        ]);
    }




  private function getImage() {
    $sourceType = 'placeholder';
    $width = $this->faker->numberBetween(2000,5000);
    $height = $this->faker->numberBetween(2000,5000);
    $src = "//placehold.dev.area17.com/image/".$width."x".$height."?bg=333&fg=ccc";

    $credit = $this->faker->boolean() ? $this->faker->sentence(3) : null;
    $creditUrl = ($credit && $this->faker->boolean()) ? '#' : null;

    $image = array(
        "sourceType" => $sourceType,
        "src" => $src,
        "width" => $width,
        "height" => $height,
        "shareUrl" => '#',
        "shareTitle" => $this->faker->sentence(5),
        "downloadUrl" => $src,
        "downloadName" => $this->faker->word(),
        "credit" => $credit,
        "creditUrl" => $creditUrl,
    );

    //$image = LakeviewImageService::getImage('92e0fb45-44a6-4b99-c011-2175b9cbc468');
    //$image['sourceType'] = 'lakeview';

    return $image;
  }

  private function generateParagraph($num = 6, $variableLength = true) {
    return '<p>'.$this->faker->paragraph($num, $variableLength).'</p>';
  }
  private function generateDiningOptions($num = 3) {
    $options = array();
    for ($i = 0; $i < $num; $i++) {
      $option = array(
        "title" => $this->faker->sentence(),
        "text" => $this->faker->paragraph(),
        "image" => $this->getImage(),
      );
      array_push($options, $option);
    }
    return $options;
  }
}
