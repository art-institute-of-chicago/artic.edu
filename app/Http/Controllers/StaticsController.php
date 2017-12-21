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

  public function toybox() {
    $stackImages = array();
    for ($i = 0; $i < 3; $i++) {
      $thisImage = $this->getImage();
      array_push($stackImages, $thisImage);
    }

    return view('statics/toybox', [
      'timelineEvents' => $this->getTimelineEvents(3),
      'stackImages' => $stackImages,
    ]);
  }

  public function listings() {
    return view('statics/listings', [
        'exhibitions8' => $this->getExhibitions(8),
        'exhibitions4' => $this->getExhibitions(4),
        'exhibitions6' => $this->getExhibitions(6),
        'exhibitions3' => $this->getExhibitions(3),
        'products' => $this->getProducts(5),
        'eventsByDay' => $this->makeEventsByDates(3),
    ]);
  }

  public function home() {
    return view('statics/home', [
      'contrastHeader' => true,
      'filledLogo' => true,
      'intro' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus eget laoreet tortor. Quisque tristique laoreet lectus sit amet tempus. Aliquam vel eleifend nisi.',
      'heroExhibitions' => $this->getExhibitions(3),
      'exhibitions' => $this->getExhibitions(2),
      'events' => $this->getEvents(4),
      'products' => $this->getProducts(5),
      'theCollection' => $this->generateCollection(),
    ]);
  }

  public function exhibitions_and_events() {
    return view('statics/exhibitions_and_events', [
      'primaryNavCurrent' => 'exhibitions_and_events',
      'title' => 'Exhibitions and Events',
      'intro' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus eget laoreet <em>tortor quisque tristique laoreet</em> lectus sit amet tempus. Aliquam vel eleifend nisi.',
      'featuredExhibitions' => $this->getExhibitions(2),
      'exhibitions' => $this->getExhibitions(12),
      'eventsByDay' => $this->makeEventsByDates(1),
    ]);
  }

  public function events() {
    return view('statics/events', [
      'primaryNavCurrent' => 'exhibitions_and_events',
      'title' => 'Exhibitions and Events',
      'intro' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus eget laoreet <em>tortor quisque tristique laoreet</em> lectus sit amet tempus. Aliquam vel eleifend nisi.',
      'eventsByDay' => $this->makeEventsByDates(1),
    ]);
  }

  public function article() {
    return view('statics/article', [
      'timelineEvents' => $this->getTimelineEvents(3),
      'relatedExhibitions' => $this->getExhibitions(3),
      'relatedExhibition' => $this->getExhibition(),
      'relatedProducts' => $this->getProducts(3),
      'relatedProduct' => $this->getProduct(),
      'relatedEvents' => $this->getEvents(3),
      'relatedEvent' => $this->getEvent(),
    ]);
  }

  public function generic_landing() {
    return view('statics/generic-landing', [
    ]);
  }

  // --------------------------------------------------------------------------------------------
  // Make some fake datas
  // --------------------------------------------------------------------------------------------

  private function getImage($width = false, $height = false) {
    //$color = preg_replace('/#/i', '', $this->faker->hexcolor);
    $width = isset($width) ? $width : $this->faker->numberBetween(300,700);
    $height = isset($height) ? $height : $this->faker->numberBetween(300,700);
    //$src = "http://placehold.dev.area17.com/image/".$width."x".$height."/?bg=".$color."&text=";
    $src = "http://placeimg.com/".$width."/".$height."/nature";
    $image = array("src" => $src, "width" => $width, "height" => $height);

    return $image;
  }

  private function getExhibitionType($upcoming = false) {
    $exhibitionTypes = array("Exhibition","Special Exhibition","Ongoing");
    return $upcoming ? "Upcoming" : $this->faker->randomElement($exhibitionTypes);
  }

  private function getEventType() {
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
      "exclusive" => $this->faker->boolean(10),
      "nowOpen" => $this->faker->boolean(10),
      "image" => $this->getImage(),
      "type" => 'exhibition',
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

    $free = $this->faker->boolean(30);
    $register = false;
    $soldOut = false;

    if (!$free) {
        $register = $this->faker->boolean(30);
    }
    if ($register) {
        $soldOut = $this->faker->boolean();
    }
    if ($soldOut) {
        $register = false;
    }

    return new StaticObjectPresenter([
      "type" => $this->getEventType(),
      "id" => $this->faker->uuid,
      "slug" => "/statics/event",
      "title" => $this->faker->sentence(6, true),
      "shortDesc" => $this->faker->paragraph(1, false),
      "dateFormatted" => $this->getFormattedDateString(),
      "timeStart" => $this->makeEventTime($hour, ($this->faker->boolean() ? '00' : '30')),
      "timeEnd" => $this->makeEventTime(($hour+1), ($this->faker->boolean() ? '00' : '30')),
      "exclusive" => $this->faker->boolean(30),
      "image" => $this->getImage(),
      "type" => 'event',
      "free" => $free,
      "register" => $register,
      "soldOut" => $soldOut,
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

  private function makeEventsByDates($days = 1, $startDate = "now") {
    $dates = array();
    $date = strtotime($startDate);
    for ($i = 0; $i < $days; $i++) {
      $thisDay = array(
        'date' => array(
            'date' => date('d', strtotime($startDate. ' + '.$i.' days')),
            'month' => date('M', strtotime($startDate. ' + '.$i.' days')),
            'day' => date('D', strtotime($startDate. ' + '.$i.' days'))
        ),
        'events' => $this->getEvents($this->faker->numberBetween(3,6)),
        'ongoingEvents' => $this->getEvents($this->faker->numberBetween(1,3)),
      );
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
      "type" => 'Furnishings',
      "title" => $this->faker->sentence(4, true),
      "shortDesc" => $this->faker->paragraph(1, false),
      "image" => $this->getImage(),
      "price" => $price,
      "priceSale" => $priceSale,
      "currency" => "$",
      "type" => 'product',
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

  private function getTimelineEvent() {
    $hour = $this->faker->numberBetween(10,19);

    return new StaticObjectPresenter([
      "title" => $this->faker->sentence(6, true),
      "time" => $this->makeEventTime($hour, ($this->faker->boolean() ? '00' : '30')),
      "blurb" => $this->faker->paragraph(5),
      "image" => ($this->faker->boolean()) ? $this->getImage() : null,
      "type" => 'timelineEvent',
    ]);
  }

  private function getTimelineEvents($num = 3) {
    $events = array();
    for ($i = 0; $i < $num; $i++) {
      $event = $this->getTimelineEvent();
      array_push($events, $event);
    }
    return $events;
  }

  private function getArtwork() {
    return new StaticObjectPresenter([
      "id" => $this->faker->uuid,
      "sku" => $this->faker->year().'.'.$this->faker->numberBetween(99,249),
      "slug" => "/statics/artwork",
      "title" => $this->faker->sentence(3, true),
      "artist" => $this->faker->firstName.' '.$this->faker->lastName,
      "date" => $this->faker->year(),
      "image" => $this->getImage(),
      "type" => 'artwork',
    ]);
  }

  private function getArtworks($num = 3) {
    $artworks = array();
    for ($i = 0; $i < $num; $i++) {
      $artwork = $this->getArtwork();
      array_push($artworks, $artwork);
    }
    return $artworks;
  }

  private function getArticle() {
    return new StaticObjectPresenter([
      "id" => $this->faker->uuid,
      "slug" => "/statics/article",
      "title" => $this->faker->sentence(6, true),
      "author" => $this->faker->firstName.' '.$this->faker->lastName,
      "intro" => $this->faker->sentence(12, true),
      "date" => $this->faker->date(),
      "image" => $this->getImage(),
      "type" => 'article',
    ]);
  }

  private function getArticles($num = 3) {
    $articles = array();
    for ($i = 0; $i < $num; $i++) {
      $article = $this->getArticle();
      array_push($articles, $article);
    }
    return $articles;
  }

  private function getSelection() {
    // make some images
    $selectionImages = array();
    for ($i = 0; $i < 3; $i++) {
      $thisImage = $this->getImage();
      array_push($selectionImages, $thisImage);
    }

    return new StaticObjectPresenter([
      "id" => $this->faker->uuid,
      "slug" => "/statics/selection",
      "title" => $this->faker->sentence(6, true),
      "image" => $this->getImage(),
      "images" => $selectionImages,
      "type" => 'selection',
    ]);
  }

  private function getSelections($num = 3) {
    $selections = array();
    for ($i = 0; $i < $num; $i++) {
      $selection = $this->getSelection();
      array_push($selections, $selection);
    }
    return $selections;
  }

  private function generateCollection($num = 6) {
    $_items = array();
    $items = array();
    $numOfEach = round(($num + 3)/3);
    for ($i = 0; $i < $numOfEach; $i++) {
      $item = $this->getSelection();
      array_push($_items, $item);
    }
    for ($i = 0; $i < $numOfEach; $i++) {
      $item = $this->getArticle();
      array_push($_items, $item);
    }
    for ($i = 0; $i < $numOfEach; $i++) {
      $item = $this->getArtwork();
      array_push($_items, $item);
    }
    $_items = $this->faker->shuffle($_items);
    for ($i = 0; $i < $num; $i++) {
      array_push($items, $_items[$i]);
    }
    return $items;
  }
}
