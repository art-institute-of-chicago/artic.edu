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

    $article = $this->generateAllBlocksArticle();

    return view('statics/article', [
      'contrastHeader' => ($article->headerType === 'hero'),
      'article' => $article,
    ]);
  }

  public function article_feature() {

    $article = $this->generateAllBlocksArticle();
    $article->push('headerType', 'feature');
    $article->push('headerImage', $this->getImage(1600,900));

    return view('statics/article', [
      'contrastHeader' => ($article->headerType === 'hero'),
      'article' => $article,
    ]);
  }

  public function article_hero() {

    $article = $this->generateAllBlocksArticle();
    $article->push('headerType', 'hero');
    $article->push('headerImage', $this->getImage(1600,900));

    return view('statics/article', [
      'contrastHeader' => ($article->headerType === 'hero'),
      'article' => $article,
    ]);
  }

  public function article_superhero() {

    $article = $this->generateAllBlocksArticle();
    $article->push('headerType', 'super-hero');
    $article->push('headerImage', $this->getImage(1600,900));

    return view('statics/article', [
      'contrastHeader' => ($article->headerType === 'hero'),
      'article' => $article,
    ]);
  }

  public function generic_landing() {
    $navs = $this->generateGenericNav('landing');

    return view('statics/generic', [
        'subNav' => $navs['subNav'],
        'nav' => $navs['nav'],
        'headerImage' => $this->getImage(2000,240),
        "title" => "Students",
        "breadcrumb" => $this->generateGenericBreadcrumb(),
        "blocks" => $this->generateBlocks(3),
        'featuredRelated' => array(
          'type' => 'media',
          'items' => $this->getMedias(1),
        ),
    ]);
  }

  public function generic_detail() {
    $navs = $this->generateGenericNav('detail');

    return view('statics/generic', [
        'subNav' => $navs['subNav'],
        'nav' => $navs['nav'],
        'headerImage' => $this->getImage(2000,240),
        "title" => "Scheduling a tour",
        "breadcrumb" => $this->generateGenericBreadcrumb(),
        "blocks" => $this->generateBlocks(3),
        'featuredRelated' => array(
          'type' => 'media',
          'items' => $this->getMedias(1),
        ),
    ]);
  }

  public function exhibition() {
    // make some left rail links
    $locationLink = array('label' => 'Galleries 182-184', 'href' => '#', 'iconBefore' => 'location');
    $relatedEventsLink = array('label' => '12 related events', 'href' => '#related_events', 'iconBefore' => 'calendar');
    $closingSoon = array('label' => 'Closing Soon', 'variation' => 'closing-soon');
    // make left rail nav array
    $nav = array();
    array_push($nav, $locationLink);
    array_push($nav, $relatedEventsLink);
    array_push($nav, $closingSoon);
    // get an exhibition
    $article = $this->getExhibition();
    // update and add some items (I ran into memory issues doing this in the main getExhibition func..)
    $article->push('articleType', 'exhibition');
    $article->push('closingSoon', true);
    $article->push('headerType', 'hero');
    $article->push('headerImage', $this->getImage(1600,900));
    $article->push('blocks', $this->generateBlocks(6));
    $article->push('intro', $this->faker->paragraph(6, false));
    $article->push('sponsors', $this->generateBlocks(2));
    $article->push('futherSupport', array(
      'logo' => $this->getImage(320,320),
      'title' => "Further support has been provided by",
      'text' => $this->faker->paragraph(5),
    ));
    $article->push('relatedEventsByDay', $this->makeEventsByDates(1));
    $article->push('relatedExhibitions', $this->getExhibitions(4));
    $article->push('featuredRelated', array(
      'type' => 'media',
      'items' => $this->getMedias(1),
    ));
    $article->push('nav', $nav);
    // now push to a view
    return view('statics/article', [
      'contrastHeader' => ($article->headerType === 'hero'),
      'article' => $article,
    ]);
  }

  public function event() {
    // make some left rail links
    $locationLink = array('label' => 'Rubloff Auditorium', 'href' => '#', 'iconBefore' => 'location');
    $ticketLink = '#';
    $registrationLink = array('label' => 'Registration required', 'href' => $ticketLink, 'iconBefore' => 'user');
    // make left rail nav array
    $nav = array();
    array_push($nav, $locationLink);
    array_push($nav, $registrationLink);
    // set ticket prices
    $ticketPrices = array(
      array('price' => '$10', 'label' => 'students'),
      array('price' => '$15', 'label' => 'members'),
      array('price' => '$20', 'label' => 'nonmembers'),
    );
    // get an event
    $article = $this->getEvent();
    $article->push('articleType', 'event');
    //$article->push('headerType', 'feature');
    $article->push('headerImage', $this->getImage(1600,900));
    $article->push('blocks', $this->generateBlocks(6));
    $article->push('intro', $this->faker->paragraph(6, false));
    $article->push('speakers', array(
        array(
          'img' => $this->getImage(320,320),
          'title' => $this->faker->firstName.' '.$this->faker->lastName,
          'text' => $this->faker->paragraph(5),
        ),
      )
    );
    $article->push('sponsors', $this->generateBlocks(2));
    $article->push('futherSupport', array(
      'logo' => $this->getImage(320,320),
      'title' => "Further support has been provided by",
      'text' => $this->faker->paragraph(5),
    ));
    $article->push('relatedEvents', $this->getEvents(4));
    $article->push('ticketLink', $ticketLink);
    $article->push('nav', $nav);
    $article->push('ticketPrices', $ticketPrices);
    // now push to a view
    return view('statics/article', [
      'contrastHeader' => ($article->headerType === 'hero'),
      'article' => $article,
    ]);
  }

  public function editorial() {
    $headerImage = $this->getImage(1600,900);
    $blocks = $this->generateBlocks(3);
    array_push($blocks, array(
        "type" => 'quote',
        "content" => $this->faker->paragraph(6, false)
    ));
    array_push($blocks, array(
        "type" => 'text',
        "content" => 'Curabitur velit libero<sup id="ref_cite-1"><a href="#ref_note-1">[1]</a></sup>, pretium sed ullamcorper eget, rutrum a nisl. Maecenas lacinia<sup id="ref_cite-2"><a href="#ref_note-2">[2]</a></sup> sit amet magna dignissim dapibus. Cras convallis <a href="#">lectus eget pulvinar tristique</a>. Maecenas <strong>consequat</strong> egestas est, in <em>luctus urna</em> porta rhoncus. Quisque id massa tristique<sup id="ref_cite-3"><a href="#ref_note-3">[3]</a></sup>, tincidunt risus vel, gravida justo.'
    ));
    // get an event
    $article = $this->getArticle();
    $article->push('articleType', 'editorial');
    $article->push('headerType', 'feature');
    $article->push('headerImage', $headerImage);
    $article->push('blocks', $blocks);
    $article->push('intro', $this->faker->paragraph(6, false));
    $article->push('sponsors', $this->generateBlocks(2));
    $article->push('futherSupport', array(
      'logo' => $this->getImage(320,320),
      'title' => "Further support has been provided by",
      'text' => $this->faker->paragraph(5),
    ));
    $article->push('relatedArticles', $this->getArticles(4));
    $article->push('featuredRelated', array(
      'type' => 'event',
      'items' => $this->getEvents(1),
    ));
    $article->push('topics', array(
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
    );
    $article->push('references', array(
      array(
        'id' => '1',
        'reference' => $this->faker->sentence(9),
      ),
      array(
        'id' => '2',
        'reference' => $this->faker->sentence(9),
      ),
      array(
        'id' => '3',
        'reference' => $this->faker->sentence(9),
      ),
    ));
    $article->push('citation', $this->faker->paragraph(5));
    $article->push('comments', '<p class="f-secondary">comments embed code</p>');
    // now push to a view
    return view('statics/article', [
      'contrastHeader' => ($article->headerType === 'hero'),
      'article' => $article,
    ]);
  }

  public function artwork() {
    // get an artwork
    $article = $this->getArtwork();
    // update and add some items (I ran into memory issues doing this in the main getartwork func..)
    $article->push('nextArticle', $this->getArtwork());
    $article->push('prevArticle', $this->getArtwork());
    $article->push('articleType', 'artwork');
    $article->push('headerType', 'gallery');
    $article->push('onView', array('label' => 'European Painting and Sculpture, Galleries 239', 'href' => '#'));
    $article->push('blocks', $this->generateBlocks(6));
    $article->push('exploreFuther', array(
      'items' => $this->getArtworks(8),
      'nav' => array(
        array(
          'href' => '#',
          'label' => "Renaissance",
        ),
        array(
          'href' => '#',
          'label' => "Arms",
          'active' => true,
        ),
        array(
          'href' => '#',
          'label' => "Northern Italy",
        ),
        array(
          'href' => '#',
          'label' => "All tags",
        ),
      ),
    ));
    $article->push('galleryImages', $this->getImages($this->faker->numberBetween(1,5)));
    $article->push('recentlyViewedArtworks', $this->getArtworks(6));
    $article->push('interestedThemes', array(
      array(
        'href' => '#',
        'label' => "Picasso",
      ),
      array(
        'href' => '#',
        'label' => "Modern Art",
      ),
      array(
        'href' => '#',
        'label' => "European Art",
      ),
    ));
    $article->push('featuredRelated', array(
      'type' => 'article',
      'items' => $this->getArticles(1),
    ));
    // now push to a view
    return view('statics/article', [
      'contrastHeader' => ($article->headerType === 'hero'),
      'article' => $article,
    ]);
  }

  // --------------------------------------------------------------------------------------------
  // Make some fake datas
  // --------------------------------------------------------------------------------------------

  private function getImage($width = false, $height = false) {
    //$color = preg_replace('/#/i', '', $this->faker->hexcolor);
    $width = isset($width) && $width ? $width : $this->faker->numberBetween(300,700);
    $height = isset($height) && $height ? $height : $this->faker->numberBetween(300,700);
    //$src = "http://placehold.dev.area17.com/image/".$width."x".$height."/?bg=".$color."&text=";
    $src = "http://placeimg.com/".$width."/".$height."/nature";
    $srcset = "http://placeimg.com/".$width."/".$height."/nature ".$width."w";
    //$src = $this->faker->imageUrl($width, $height, 'nature');
    //$src = str_replace('https://', 'http://', $src);

    $credit = $this->faker->boolean() ? $this->faker->sentence(3) : null;
    $creditUrl = ($credit && $this->faker->boolean()) ? '#' : null;

    $image = array(
        "src" => $src,
        "srcset" => $srcset,
        "width" => $width,
        "height" => $height,
        "shareUrl" => '#',
        "shareTitle" => $this->faker->sentence(5),
        "downloadUrl" => $src,
        "downloadName" => $this->faker->word(),
        "credit" => $credit,
        "creditUrl" => $creditUrl,
    );

    return $image;
  }

  private function getImages($num = 3) {
    $images = array();
    for ($i = 0; $i < $num; $i++) {
      $image = $this->getImage();
      array_push($images, $image);
    }
    return $images;
  }

  private function getVideo() {
    $video = array(
        'src' => '/test/feature-1.mp4',
        'poster' => '/test/feature-1.jpg',
    );
    return $video;
  }

  private function getEmbed() {
    $embed = array(
        'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/LjV3OcqI_CY?rel=0&amp;showinfo=0" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>',
    );
    return $embed;
  }

  private function getGalleryImages($num = 6) {
    $images = array();
    for ($i = 0; $i < $num; $i++) {
      if ($i == 2) {
        array_push($images, array(
              'type' => 'video',
              'size' => 'gallery',
              'media' => $this->getVideo(),
              'caption' => $this->faker->paragraph(3, false)
          )
        );
      } else if ($i == 5) {
        array_push($images, array(
              'type' => 'embed',
              'size' => 'gallery',
              'media' => $this->getEmbed(),
              'caption' => $this->faker->paragraph(3, false)
          )
        );
      } else {
        array_push($images, array(
              'type' => 'image',
              'size' => 'gallery',
              'media' => $this->getImage(),
              'caption' => $this->faker->paragraph(3, false)
          )
        );
      }
    }
    return $images;
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
      "slug" => "/statics/exhibition",
      "title" => $this->faker->sentence(6, true),
      "dateStart" => $this->getFormattedDateString(),
      "dateEnd" => $this->getFormattedDateString(),
      "closingSoon" => $this->faker->boolean(10),
      "exclusive" => $this->faker->boolean(10),
      "nowOpen" => $this->faker->boolean(10),
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

    $dateFormatted = $this->getFormattedDateString();
    $timeStart = $this->makeEventTime($hour, ($this->faker->boolean() ? '00' : '30'));
    $timeEnd = $this->makeEventTime($hour + 1, ($this->faker->boolean() ? '00' : '30'));
    $date = $dateFormatted.', '.$timeStart.' - '.$timeEnd;

    return new StaticObjectPresenter([
      "type" => $this->getEventType(),
      "id" => $this->faker->uuid,
      "slug" => "/statics/event",
      "title" => $this->faker->sentence(6, true),
      "shortDesc" => $this->faker->paragraph(1, false),
      "dateFormatted" => $dateFormatted,
      "timeStart" => $timeStart,
      "timeEnd" => $timeEnd,
      "date" => $date,
      "exclusive" => $this->faker->boolean(30),
      "image" => $this->getImage(),
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

  private function getMedia() {
    return new StaticObjectPresenter([
      "id" => $this->faker->uuid,
      "slug" => "/statics/media",
      "title" => $this->faker->sentence(6, true),
      "image" => $this->getImage(),
      "timeStamp" => $this->faker->time(),
      "type" => 'media',
    ]);
  }

  private function getMedias($num = 3) {
    $medias = array();
    for ($i = 0; $i < $num; $i++) {
      $media = $this->getMedia();
      array_push($medias, $media);
    }
    return $medias;
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
      "title" => $this->faker->sentence(5, true),
      "subtitle" => $this->faker->sentence(5, true),
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
      "author" => array(
        'img' => $this->getImage(320,320),
        'name' => $this->faker->firstName.' '.$this->faker->lastName,
        'link' => '#',
      ),
      "intro" => $this->faker->sentence(12, true),
      "date" => $this->getFormattedDateString(),
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

  private function generateGenericNav($state = 'landing') {
    $subNav = array(
        array('href' => '#', 'label' => 'Tours'),
        array('href' => '#', 'label' => 'Scheduling a tour', 'active' => ($state === 'detail')),
        array('href' => '#', 'label' => 'Preparing for a museum visit'),
        array('href' => '#', 'label' => 'Bus scholarship'),
        array('href' => '#', 'label' => 'For tour companies'),
    );
    $nav = array(
        array('label' => 'Adults and university', 'href' => '#'),
        array('label' => 'Students', 'href' => '#', 'links' => $subNav, 'active' => ($state === 'landing')),
        array('label' => 'Group FAQs', 'href' => '#',),
    );

    return array('nav' => $nav, 'subNav' => $subNav);
  }

  private function generateGenericBreadcrumb() {
    return array(
        array('label' => 'Visit', 'href' => '#'),
        array('label' => 'Group Visits', 'href' => '#',),
        array('label' => 'Students', 'href' => '#',),
    );
  }

  private function generateAllBlocksArticle() {
    $article = $this->getExhibition();
    $article->push('articleType', 'exhibition');
    $article->push('headerImage', $this->getImage(1600,900));
    $article->push('intro', $this->faker->paragraph(6, false));
    $article->push('blocks', $this->generateBlocks('all'));
    $article->push('nav', array(array('label' => 'Galleries 182-184', 'href' => '#', 'iconBefore' => 'location')));
    $article->push('relatedEventsByDay', $this->makeEventsByDates(1));
    $article->push('relatedExhibitions', $this->getExhibitions(4));
    $article->push('relatedEvents', $this->getEvents(4));
    $article->push('relatedArticles', $this->getArticles(4));
    $article->push('featuredRelated', array(
       'type' => 'event',
       'items' => $this->getEvents(1),
    ));
    return $article;
  }

  private function generateBlocks($num = 3) {

    $blocks = array();

    array_push($blocks, array(
        "type" => 'text',
        "content" => 'Curabitur velit libero, pretium sed ullamcorper eget, rutrum a nisl. Maecenas lacinia sit amet magna dignissim dapibus. Cras convallis <a href="#">lectus eget pulvinar tristique</a>. Maecenas <strong>consequat</strong> egestas est, in <em>luctus urna</em> porta rhoncus. Quisque id massa tristique, tincidunt risus vel, gravida justo.'
    ));
    array_push($blocks, array(
        "type" => 'text',
        "subtype" => 'heading-1',
        "content" => $this->faker->sentence(6)
    ));
    array_push($blocks, array(
        "type" => 'text',
        "content" => $this->faker->paragraph(12, false)
    ));
    array_push($blocks, array(
        "type" => 'hr',
    ));
    array_push($blocks, array(
        "type" => 'text',
        "subtype" => 'heading-2',
        "content" => $this->faker->sentence(6)
    ));
    array_push($blocks, array(
        "type" => 'text',
        "content" => $this->faker->paragraph(12, false)
    ));
    array_push($blocks, array(
        "type" => 'unorderedList',
        "items" => array(
          $this->faker->sentence(6),
          $this->faker->sentence(6),
          $this->faker->sentence(6),
        )
    ));
    array_push($blocks, array(
        "type" => 'text',
        "content" => $this->faker->paragraph(12, false)
    ));
    array_push($blocks, array(
        "type" => 'orderedList',
        "items" => array(
          $this->faker->sentence(6),
          $this->faker->sentence(6),
          $this->faker->sentence(6),
        )
    ));
    array_push($blocks, array(
        "type" => 'text',
        "subtype" => 'intro',
        "content" => $this->faker->paragraph(6, false)
    ));
    array_push($blocks, array(
        "type" => 'text',
        "content" => $this->faker->paragraph(12, false)
    ));
    array_push($blocks, array(
        "type" => 'quote',
        "content" => $this->faker->paragraph(6, false)
    ));
    array_push($blocks, array(
        "type" => 'media',
        "content" => array(
            'type' => 'image',
            'size' => 's',
            'media' => $this->getImage(640,480),
            'caption' => $this->faker->paragraph(3, false)
        )
    ));
    array_push($blocks, array(
        "type" => 'media',
        "content" => array(
            'type' => 'image',
            'size' => 'm',
            'media' => $this->getImage(480,640),
            'caption' => $this->faker->paragraph(3, false)
        )
    ));
    array_push($blocks, array(
        "type" => 'media',
        "content" => array(
            'type' => 'image',
            'size' => 'l',
            'media' => $this->getImage(640,640),
            'caption' => $this->faker->paragraph(3, false)
        )
    ));
    array_push($blocks, array(
        "type" => 'media',
        "content" => array(
            'type' => 'video',
            'size' => 's',
            'media' => $this->getVideo(),
            'caption' => $this->faker->paragraph(3, false)
        )
    ));
    array_push($blocks, array(
        "type" => 'media',
        "content" => array(
            'type' => 'embed',
            'size' => 's',
            'media' => $this->getEmbed(),
            'caption' => $this->faker->paragraph(3, false)
        )
    ));
    array_push($blocks, array(
        "type" => 'become-a-member',
    ));
    array_push($blocks, array(
        "type" => 'newsletter-sign-up',
    ));
    array_push($blocks, array(
        "type" => 'newsletter-sign-up',
        "subtype" => 'wide',
    ));
    array_push($blocks, array(
        "type" => 'newsletter-sign-up',
        "subtype" => 'inline',
    ));
    array_push($blocks, array(
        "type" => 'listing',
        "subtype" => 'exhibition',
        "items" => $this->getExhibitions(3),
    ));
    array_push($blocks, array(
        "type" => 'text',
        "content" => $this->faker->paragraph(6, false)
    ));
    array_push($blocks, array(
        "type" => 'listing',
        "subtype" => 'event',
        "items" => $this->getEvents(3),
    ));
    array_push($blocks, array(
        "type" => 'text',
        "content" => $this->faker->paragraph(6, false)
    ));
    array_push($blocks, array(
        "type" => 'listing',
        "subtype" => 'product',
        "items" => $this->getProducts(3),
    ));
    array_push($blocks, array(
        "type" => 'text',
        "content" => $this->faker->paragraph(6, false)
    ));
    array_push($blocks, array(
        "type" => 'aside',
        "subtype" => 'event',
        "items" => $this->getEvents(1),
    ));
    array_push($blocks, array(
        "type" => 'text',
        "content" => $this->faker->paragraph(6, false)
    ));
    array_push($blocks, array(
        "type" => 'aside',
        "subtype" => 'event',
        "items" => $this->getEvents(3),
    ));
    array_push($blocks, array(
        "type" => 'text',
        "content" => $this->faker->paragraph(6, false)
    ));
    array_push($blocks, array(
        "type" => 'aside',
        "subtype" => 'exhibition',
        "items" => $this->getExhibitions(1),
    ));
    array_push($blocks, array(
        "type" => 'text',
        "content" => $this->faker->paragraph(6, false)
    ));
    array_push($blocks, array(
        "type" => 'aside',
        "subtype" => 'exhibition',
        "items" => $this->getExhibitions(3),
    ));
    array_push($blocks, array(
        "type" => 'text',
        "content" => $this->faker->paragraph(6, false)
    ));
    array_push($blocks, array(
        "type" => 'aside',
        "subtype" => 'product',
        "items" => $this->getProducts(1),
    ));
    array_push($blocks, array(
        "type" => 'text',
        "content" => $this->faker->paragraph(6, false)
    ));
    array_push($blocks, array(
        "type" => 'aside',
        "subtype" => 'product',
        "items" => $this->getProducts(3),
    ));
    array_push($blocks, array(
        "type" => 'text',
        "content" => $this->faker->paragraph(6, false)
    ));
    array_push($blocks, array(
        "type" => 'text',
        "content" => $this->faker->paragraph(6, false)
    ));
    array_push($blocks, array(
        "type" => 'time-line',
        "items" => $this->getTimelineEvents(3)
    ));
    array_push($blocks, array(
        "type" => 'link-list',
        "links" => array(
              array('label' => 'Quis finibus maximus', 'href' => '#'),
              array('label' => 'Ut fermentum est', 'href' => '#', 'iconAfter' => 'new-window'),
              array('label' => 'In tempor velit', 'href' => '#', 'iconAfter' => 'new-window')
          )
    ));
    array_push($blocks, array(
        "type" => 'text',
        "content" => $this->faker->paragraph(6)
    ));
    array_push($blocks, array(
        "type" => 'accordion',
        "content" => array(
            array(
                'title' => $this->faker->sentence(6),
                'blocks' => array(
                    array(
                        "type" => 'text',
                        "content" => $this->faker->paragraph(8)
                    ),
                    array(
                        "type" => 'text',
                        "content" => $this->faker->paragraph(8)
                    ),
                ),
            ),
            array(
                'title' => $this->faker->sentence(6),
                'blocks' => array(
                    array(
                        "type" => 'text',
                        "content" => $this->faker->paragraph(8)
                    ),
                    array(
                        "type" => 'text',
                        "content" => $this->faker->paragraph(8)
                    ),
                ),
            ),
            array(
                'title' => $this->faker->sentence(6),
                'blocks' => array(
                    array(
                        "type" => 'text',
                        "content" => $this->faker->paragraph(8)
                    ),
                    array(
                        "type" => 'text',
                        "content" => $this->faker->paragraph(8)
                    ),
                ),
            ),
        )
    ));
    array_push($blocks, array(
        "type" => 'text',
        "content" => $this->faker->paragraph(6)
    ));
    array_push($blocks, array(
        "type" => 'gallery',
        "subtype" => 'mosaic',
        "title" => 'Mosaic Gallery',
        "caption" => $this->faker->paragraph(3, false),
        "items" => $this->getGalleryImages(6),
    ));
    array_push($blocks, array(
        "type" => 'text',
        "content" => $this->faker->paragraph(6)
    ));
    array_push($blocks, array(
        "type" => 'gallery',
        "subtype" => 'slider',
        "title" => 'Slider Gallery',
        "caption" => $this->faker->paragraph(3, false),
        "items" => $this->getGalleryImages(6),
    ));
    array_push($blocks, array(
        "type" => 'text',
        "content" => $this->faker->paragraph(6)
    ));

    if ($num === 'all') {
      return $blocks;
    } else {
      $generatedBlocks = array();
      for ($i = 0; $i < $num; $i++) {
        array_push($generatedBlocks, array(
          "type" => 'text',
          "content" => $this->faker->paragraph(10)
        ));
      }
      return $generatedBlocks;
    }
  }
}
