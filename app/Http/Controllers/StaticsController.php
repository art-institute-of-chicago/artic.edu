<?php

namespace App\Http\Controllers;

use A17\CmsToolkit\Http\Controllers\Front\Controller as Controller;
use App\Presenters\StaticObjectPresenter;
use Faker\Generator as Faker;

class StaticsController extends Controller {
  protected $faker;

  function __construct(Faker $faker) {
      $this->faker = $faker;

      parent::__construct();
  }

  public function index($slug = "") {
      if ( !empty($slug) && method_exists($this, $function = str_replace('-','_',$slug))) {
          return $this->{$function}();
      }

      return view(($slug != "") ? "statics/{$slug}" : "statics/index");
  }

  public function typetest() {
    return view('statics/typetest', [
      'exhibitions1' => $this->getExhibitions(2),
      'exhibitions2' => $this->getExhibitions(3),
      'exhibitions3' => $this->getExhibitions(4),
      'products' => $this->getProducts(5),
    ]);
  }

  public function home() {
    return view('statics/home', [
      'contrastHeader' => true,
      'intro' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus eget laoreet tortor. Quisque tristique laoreet lectus sit amet tempus. Aliquam vel eleifend nisi.',
      'heroExhibitions' => $this->getExhibitions(3),
      'featuredExhibitions' => $this->getExhibitions(2),
      'exhibitions' => $this->getExhibitions(4),
      'products' => $this->getProducts(5),
    ]);
  }

  public function whatson() {
    return view('statics/whatson', [
      'intro' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus eget laoreet tortor. Quisque tristique laoreet lectus sit amet tempus. Aliquam vel eleifend nisi.',
      'featuredExhibitions' => $this->getExhibitions(2),
      'exhibitions' => $this->getExhibitions(12),
      'eventsByDay' => $this->makeEventsByDates(1),
    ]);
  }

  // --------------------------------------------------------------------------------------------
  // Make some fake datas
  // --------------------------------------------------------------------------------------------

  private function getImage() {
    $images = array(
      array("src" => "http://placehold.dev.area17.com/image/524x750", "width" => 524, "height" => 750),
      array("src" => "http://placehold.dev.area17.com/image/516x750", "width" => 516, "height" => 750),
      array("src" => "http://placehold.dev.area17.com/image/651x500", "width" => 651, "height" => 500),
      array("src" => "http://placehold.dev.area17.com/image/1193x1547", "width" => 1193, "height" => 1547),
      array("src" => "http://placehold.dev.area17.com/image/3868x2052", "width" => 3868, "height" => 2052),
      array("src" => "http://placehold.dev.area17.com/image/1537x2029", "width" => 1537, "height" => 2029),
      array("src" => "http://placehold.dev.area17.com/image/2272x2279", "width" => 2272, "height" => 2279),
      array("src" => "http://placehold.dev.area17.com/image/1571x3000", "width" => 1571, "height" => 3000),
      array("src" => "http://placehold.dev.area17.com/image/2978x3000", "width" => 2978, "height" => 3000),
      array("src" => "http://placehold.dev.area17.com/image/2161x3000", "width" => 2161, "height" => 3000),
      array("src" => "http://placehold.dev.area17.com/image/1768x2100", "width" => 1768, "height" => 2100),
    );

    return $this->faker->randomElement($images);
  }

  private function getExhibitionType($upcoming = false) {
    $exhibitionTypes = array("Exhibition","Special Exhibition","Ongoing");
    return $upcoming ? "Upcoming" : $this->faker->randomElement($exhibitionTypes);
  }

  private function getEventType($exlusive = false) {
    $eventTypes = array("Family Program","Gallery Talk","Talks");
    return $this->faker->randomElement($eventTypes);
  }

  private function makeEventTime($hour,$minute) {
    return $hour.':'.$minute.($hour > 11 ? 'pm' : 'am');
  }

  private function getFormattedDateString() {
    return $this->faker->monthName().' '.$this->faker->numberBetween(1,30).', '.$this->faker->year();
  }


  private function getExhibition($upcoming = false) {
    return new StaticObjectPresenter([
      "type" => $this->getExhibitionType($upcoming),
      "id" => $this->faker->uuid,
      "slug" => "/statics/event",
      "title" => $this->faker->sentence(6, true),
      "dateStart" => $this->getFormattedDateString(),
      "dateEnd" => $this->getFormattedDateString(),
      "closingSoon" => $this->faker->boolean(10),
      "image" => $this->getImage(),
    ]);
  }

  private function getExhibitions($num = 3, $upcoming = false) {
    $exhibitions = array();
    for ($i = 0; $i < $num; $i++) {
      $exhibition = $this->getExhibition($upcoming);
      array_push($exhibitions, $exhibition);
    }
    return $exhibitions;
  }

  private function getEvent() {
    $hour = $this->faker->numberBetween(10,19);

    return new StaticObjectPresenter([
      "type" => $this->getEventType(),
      "id" => $this->faker->uuid,
      "slug" => "/statics/event",
      "title" => $this->faker->sentence(6, true),
      "timeStart" => $this->makeEventTime($hour, ($this->faker->boolean() ? '00' : '30')),
      "timeEnd" => $this->makeEventTime(($hour+1), ($this->faker->boolean() ? '00' : '30')),
      "image" => $this->getImage(),
    ]);
  }

  private function getEvents($num = 3) {
    $events = array();
    for ($i = 0; $i < $num; $i++) {
      $event = $this->getEvent();
      array_push($events, $event);
    }
    return $events;
  }

  private function makeEventsByDates($days = 1, $startDate = "today") {
    $dates = array();
    $date = date_create( ($startDate !== "today") ? $startDate : '' );
    for ($i = 0; $i < $days; $i++) {
      date_add($date, date_interval_create_from_date_string($i.' days'));
      $thisDay = array('date' => array('date' => date('d'), 'month' => date('M'), 'day' => date('D')), 'events' => $this->getEvents($this->faker->numberBetween(3,6)));
      array_push($dates, $thisDay);
    }
    return $dates;
  }

  private function getProduct() {
    $priceRounded = $this->faker->boolean(70);
    $price = $this->faker->numberBetween(30,2500);
    $priceSale = $this->faker->boolean(30);

    if ($priceSale) {
      $priceSale = floor($price * 0.75);
    }

    if (!$priceRounded) {
      $price = $price - 0.01;
    }

    if ($priceSale && !$priceRounded) {
      $priceSale = $priceSale - 0.01;
    }

    return new StaticObjectPresenter([
      "id" => $this->faker->uuid,
      "slug" => "/statics/product",
      "title" => $this->faker->sentence(4, true),
      "image" => $this->getImage(),
      "price" => $price,
      "priceSale" => $priceSale,
      "currency" => "$",
    ]);
  }

  private function getProducts($num = 5) {
    $products = array();
    for ($i = 0; $i < $num; $i++) {
      $product = $this->getProduct();
      array_push($products, $product);
    }
    return $products;
  }

}
