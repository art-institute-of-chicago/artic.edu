<?php

namespace App\Http\Controllers;

use App\Presenters\StaticObjectPresenter;
use Faker\Generator as Faker;
use Carbon\Carbon;
use LakeviewImageService;

class StaticsController extends FrontController {
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

  public function error404() {
    return view('errors/404');
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
    $items = $this->getHomepageItems();
    return view('statics/home', $items);
  }

  public function home_1_feature() {
    $items = $this->getHomepageItems();
    $items['heroItems'] = $this->getExhibitions(1);
    return view('statics/home', $items);
  }

  public function home_features() {
    $items = $this->getHomepageItems();
    $items['heroItems'] = array();
    $event = $this->getEvent();
    $artwork = $this->getArtwork();
    $article = $this->getArticle();
    $artist = $this->getArtist(true);
    $media = $this->getMedia();
    $exhibition = $this->getExhibition();

    array_push($items['heroItems'], $exhibition);
    array_push($items['heroItems'], $event);
    array_push($items['heroItems'], $artwork);
    array_push($items['heroItems'], $article);
    array_push($items['heroItems'], $artist);
    //array_push($items['heroItems'], $media);

    return view('statics/home_features', $items);
  }

  public function home_videos() {
    $items = $this->getHomepageItems();
    $items['heroItems'] = array();
    $exhibition1 = $this->getExhibition();
    $exhibition2 = $this->getExhibition();
    $exhibition3 = $this->getEvent();

    $exhibition1->push('videoFront', $this->getVideo());
    $exhibition2->push('videoFront', $this->getVideo());

    array_push($items['heroItems'], $exhibition1);
    array_push($items['heroItems'], $exhibition2);
    array_push($items['heroItems'], $exhibition3);

    return view('statics/home', $items);
  }

  public function roadblock1() {
    $items = $this->getHomepageItems();
    $items['roadblock'] = [
        'title' => 'Avoid the crowds and save 20%',
        'intro' => $this->faker->paragraph(),
        'image' => false
    ];

    return view('statics/home', $items);
  }

  public function roadblock2() {
    $items = $this->getHomepageItems();
    $items['roadblock'] = [
        'title' => 'Enjoy Exclusing Access Today',
        'intro' => $this->faker->paragraph(),
        'image' => $this->getImage()
    ];

    return view('statics/home', $items);
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

  public function events_no_results() {
    return view('statics/events', [
      'primaryNavCurrent' => 'exhibitions_and_events',
      'title' => 'Exhibitions and Events',
      'intro' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus eget laoreet <em>tortor quisque tristique laoreet</em> lectus sit amet tempus. Aliquam vel eleifend nisi.',
      'eventsByDay' => [],
    ]);
  }

  public function article() {

    $article = $this->generateAllBlocksArticle();

    return view('statics/article', [
      'contrastHeader' => ($article->headerType === 'feature' || $article->headerType === 'hero' || $article->headerType === 'super-hero'),
      'article' => $article,
      'relatedEventsByDay' => $this->makeEventsByDates(1)
    ]);
  }

  public function article_feature() {

    $article = $this->generateAllBlocksArticle();
    $article->push('headerType', 'feature');
    $article->push('headerImage', $this->getImage());

    return view('statics/article', [
      'contrastHeader' => ($article->headerType === 'feature' || $article->headerType === 'hero' || $article->headerType === 'super-hero'),
      'article' => $article,
      'relatedEventsByDay' => $this->makeEventsByDates(1)
    ]);
  }

  public function article_hero() {

    $article = $this->generateAllBlocksArticle();
    $article->push('headerType', 'hero');
    $article->push('headerImage', $this->getImage());

    return view('statics/article', [
      'contrastHeader' => ($article->headerType === 'feature' || $article->headerType === 'hero' || $article->headerType === 'super-hero'),
      'article' => $article,
      'relatedEventsByDay' => $this->makeEventsByDates(1)
    ]);
  }

  public function article_superhero() {

    $article = $this->generateAllBlocksArticle();
    $article->push('headerType', 'super-hero');
    $article->push('headerImage', $this->getImage());

    return view('statics/article', [
      'contrastHeader' => ($article->headerType === 'feature' || $article->headerType === 'hero' || $article->headerType === 'super-hero'),
      'article' => $article,
      'relatedEventsByDay' => $this->makeEventsByDates(1)
    ]);
  }

  public function article_cms_blocks() {
    $article = $this->generateAllBlocksArticle('cms');

    return view('statics/article', [
      'contrastHeader' => ($article->headerType === 'feature' || $article->headerType === 'hero' || $article->headerType === 'super-hero'),
      'article' => $article,
      'relatedEventsByDay' => $this->makeEventsByDates(1)
    ]);
  }

  public function generic_landing() {
    $navs = $this->generateGenericNav('landing');

    return view('statics/generic', [
        'borderlessHeader' => true,
        'subNav' => $navs['subNav'],
        'nav' => $navs['nav'],
        'headerImage' => $this->getImage(),
        "title" => "Students",
        "breadcrumb" => $this->generateGenericBreadcrumb(),
        "blocks" => $this->generateBlocks(3),
        'featuredRelated' => array(
          'type' => 'media',
          'items' => $this->getMedias(1),
        ),
    ]);
  }

  public function article_galleries() {

    $article = $this->generateAllBlocksArticle('galleries');

    return view('statics/article', [
      'contrastHeader' => ($article->headerType === 'feature' || $article->headerType === 'hero' || $article->headerType === 'super-hero'),
      'article' => $article,
      'relatedEventsByDay' => $this->makeEventsByDates(1)
    ]);
  }

  public function generic_detail() {
    $navs = $this->generateGenericNav('detail');

    return view('statics/generic', [
        'borderlessHeader' => true,
        'subNav' => $navs['subNav'],
        'nav' => $navs['nav'],
        'headerImage' => $this->getImage(),
        "title" => "Proin commodo, erat rhoncus porta mollis, tortor odio luctus sapien, eget eleifend erat mi a urna",
        "breadcrumb" => $this->generateGenericBreadcrumb('long'),
        "blocks" => $this->generateBlocks(3),
        'featuredRelated' => array(
          'type' => 'media',
          'items' => $this->getMedias(1),
        ),
    ]);
  }

  public function generic_detail_no_image() {
    $navs = $this->generateGenericNav('detail');

    return view('statics/generic', [
        'borderlessHeader' => true,
        'subNav' => $navs['subNav'],
        'nav' => $navs['nav'],
        "title" => "Proin commodo, erat rhoncus porta mollis, tortor odio luctus sapien, eget eleifend erat mi a urna",
        "breadcrumb" => $this->generateGenericBreadcrumb('long'),
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
    $article->push('headerType', 'super-hero');
    $article->push('headerImage', $this->getImage());
    $article->push('blocks', $this->generateBlocks(6));
    $article->push('intro', $this->faker->paragraph(6, false));
    $article->push('sponsors', $this->generateBlocks(2));
    $article->push('futherSupport', array(
      'logo' => $this->getImage(),
      'title' => "Further support has been provided by",
      'text' => $this->faker->paragraph(5),
    ));
    // $article->push('relatedEventsByDay', $this->makeEventsByDates(1));
    $article->push('relatedExhibitions', $this->getExhibitions(4));
    $article->push('featuredRelated', array(
      'type' => 'media',
      'items' => $this->getMedias(1),
    ));
    $article->push('nav', $nav);
    // now push to a view
    return view('statics/article', [
      'contrastHeader' => ($article->headerType === 'feature' || $article->headerType === 'hero' || $article->headerType === 'super-hero'),
      'relatedEventsByDay' => $this->makeEventsByDates(1),
      'article' => $article,
    ]);
  }

  public function event() {
    $article = $this->getEventPageContents();
    $article->push('relatedEvents', $this->getEvents(4));
    $article->push('relatedOffers', $this->getOffers(3));
    // now push to a view
    return view('statics/article', [
      'contrastHeader' => ($article->headerType === 'feature' || $article->headerType === 'hero' || $article->headerType === 'super-hero'),
      'article' => $article,
      'relatedEventsByDay' => $this->makeEventsByDates(1)
    ]);
  }

  public function event_past() {
    $article = $this->getEventPageContents();
    $article->push('relatedEvents', $this->getEvents(4));
    $article->push('relatedOffers', $this->getOffers(3));

    $article->push('ticketLink', null);
    $article->push('ticketPrices', null);
    $article->push('nav', null);
    // now push to a view
    return view('statics/article', [
      'contrastHeader' => ($article->headerType === 'feature' || $article->headerType === 'hero' || $article->headerType === 'super-hero'),
      'article' => $article,
      'relatedEventsByDay' => $this->makeEventsByDates(1)
    ]);
  }

  public function event_past_minimal() {
    $article = $this->getEventPageContents();

    $blocks = array();
    array_push($blocks, array(
        "type" => 'text',
         "content" => $this->generateParagraph(12)
    ));
    array_push($blocks, array(
        "type" => 'text',
         "content" => $this->generateParagraph(6)
    ));
    $article->push('blocks', $blocks);
    $article->push('ticketLink', null);
    $article->push('ticketPrices', null);
    $article->push('nav', null);
    //article->push('intro', null);
    $article->push('date', null);
    $article->push('dateStart', null);
    $article->push('dateEnd', null);
    $article->push('type', null);
    $article->push('speakers', null);
    $article->push('sponsors', null);
    $article->push('futherSupport', null);
    // now push to a view
    return view('statics/article', [
      'contrastHeader' => ($article->headerType === 'feature' || $article->headerType === 'hero' || $article->headerType === 'super-hero'),
      'article' => $article,
    ]);
  }

  public function event_feature() {
    $article = $this->getEventPageContents('feature');
    // now push to a view
    return view('statics/article', [
      'contrastHeader' => ($article->headerType === 'feature' || $article->headerType === 'hero' || $article->headerType === 'super-hero'),
      'article' => $article,
      'relatedEventsByDay' => $this->makeEventsByDates(1)
    ]);
  }

  public function event_hero() {
    $article = $this->getEventPageContents('hero');
    // now push to a view
    return view('statics/article', [
      'contrastHeader' => ($article->headerType === 'feature' || $article->headerType === 'hero' || $article->headerType === 'super-hero'),
      'article' => $article,
      'relatedEventsByDay' => $this->makeEventsByDates(1)
    ]);
  }

  public function event_superhero() {
    $article = $this->getEventPageContents('super-hero');
    // now push to a view
    return view('statics/article', [
      'contrastHeader' => ($article->headerType === 'feature' || $article->headerType === 'hero' || $article->headerType === 'super-hero'),
      'article' => $article,
      'relatedEventsByDay' => $this->makeEventsByDates(1)
    ]);
  }

  public function editorial() {
    $headerImage = $this->getImage();
    $blocks = array();
    array_push($blocks, array(
        "type" => 'text',
        "content" => '<p><span class="f-dropcap-editorial">L</span>orem ipsum dolor sit amet, consectetur adipiscing elit. Mauris vehicula libero vel quam fringilla dignissim. Praesent finibus sem sed arcu tempor, non tincidunt magna luctus. Maecenas lacinia interdum lacinia. Pellentesque ac felis vehicula, fermentum mauris sed, ornare ex. Mauris cursus, nulla eget fermentum molestie, metus velit sodales turpis, nec tempus felis orci id erat. Curabitur velit libero<sup id="ref_cite-1"><a href="#ref_note-1">[1]</a></sup>, pretium sed ullamcorper eget, rutrum a nisl. Maecenas lacinia<sup id="ref_cite-2"><a href="#ref_note-2">[2]</a></sup> sit amet magna dignissim dapibus. Cras convallis <a href="#">lectus eget pulvinar tristique</a>. Maecenas <strong>consequat</strong> egestas est, in <em>luctus urna</em> porta rhoncus. Quisque id massa tristique<sup id="ref_cite-3"><a href="#ref_note-3">[3]</a></sup>, tincidunt risus vel, gravida justo.</p>'
    ));
    array_push($blocks, array(
        "type" => 'quote',
        "content" => $this->faker->paragraph(6, false)
    ));
    $blocks = array_merge($blocks, $this->generateBlocks(3));
    // get an event
    $article = $this->getArticle();
    $article->push('articleType', 'editorial');
    $article->push('headerType', 'feature');
    $article->push('headerImage', $headerImage);
    $article->push('blocks', $blocks);
    $article->push('intro', $this->faker->paragraph(6, false));
    $article->push('sponsors', $this->generateBlocks(2));
    $article->push('futherSupport', array(
      'logo' => $this->getImage(),
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
          'label' => $this->faker->sentence(2),
        ),
        array(
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
        'reference' => "Accusamus <strong>nam dolorem</strong> velit <em>sapiente facilis dolore</em> quae",
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
      'contrastHeader' => ($article->headerType === 'feature' || $article->headerType === 'hero' || $article->headerType === 'super-hero'),
      'article' => $article,
    ]);
  }

  public function editorial_minimal() {
    $blocks = array();
    array_push($blocks, array(
        "type" => 'text',
        "content" => '<p><span class="f-dropcap-editorial">L</span>orem ipsum dolor sit amet, consectetur adipiscing elit. Mauris vehicula libero vel quam fringilla dignissim. Praesent finibus sem sed arcu tempor, non tincidunt magna luctus. Maecenas lacinia interdum lacinia. Pellentesque ac felis vehicula, fermentum mauris sed, ornare ex. Mauris cursus, nulla eget fermentum molestie, metus velit sodales turpis, nec tempus felis orci id erat. Curabitur velit libero, pretium sed ullamcorper eget, rutrum a nisl. Maecenas lacinia sit amet magna dignissim dapibus. Cras convallis <a href="#">lectus eget pulvinar tristique</a>. Maecenas <strong>consequat</strong> egestas est, in <em>luctus urna</em> porta rhoncus. Quisque id massa tristique, tincidunt risus vel, gravida justo.</p>'
    ));
    $blocks = array_merge($blocks, $this->generateBlocks(3));
    // get an event
    $article = $this->getArticle();
    $article->push('articleType', 'editorial');
    $article->push('blocks', $blocks);
    //$article->push('intro', null);
    $article->push('type', null);
    $article->push('author',array(
      'img' => $this->getImage(),
      'name' => $this->faker->firstName.' '.$this->faker->lastName,
    ));
    // now push to a view
    return view('statics/article', [
      'contrastHeader' => ($article->headerType === 'feature' || $article->headerType === 'hero' || $article->headerType === 'super-hero'),
      'article' => $article,
    ]);
  }

  public function artwork() {
    $exploreFurtherTab = (isset($_GET['exploreFurtherTab'])) ? intval($_GET['exploreFurtherTab']) : 1;
    // get an artwork
    $article = $this->getArtwork();
    // generate some blocks
    $blocks = $this->generateArtworkBlocks();
    // update and add some items (I ran into memory issues doing this in the main getartwork func..)
    $article->push('nextArticle', $this->getArtwork());
    $article->push('prevArticle', $this->getArtwork());
    $article->push('articleType', 'artwork');
    $article->push('headerType', 'gallery');
    $article->push('onView', array('label' => 'European Painting and Sculpture, Galleries 239', 'href' => '#'));
    $article->push('blocks', $blocks);
    $article->push('exploreFurther', array(
      'items' => ($exploreFurtherTab !== 4) ? $this->getArtworks(8) : null,
      'tags' => ($exploreFurtherTab === 4) ? $this->generateTags() : null,
      'nav' => array(
        array(
          'href' => '/statics/artwork?exploreFurtherTab=1',
          'label' => "Renaissance",
          'active' => ($exploreFurtherTab === 1) ? true : false,
          'ajaxTabTarget' => 'exploreFurther',
        ),
        array(
          'href' => '/statics/artwork?exploreFurtherTab=2',
          'label' => "Arms",
          'active' => ($exploreFurtherTab === 2) ? true : false,
          'ajaxTabTarget' => 'exploreFurther',
        ),
        array(
          'href' => '/statics/artwork?exploreFurtherTab=3',
          'label' => "Northern Italy",
          'active' => ($exploreFurtherTab === 3) ? true : false,
          'ajaxTabTarget' => 'exploreFurther',
        ),
        array(
          'href' => '/statics/artwork?exploreFurtherTab=4',
          'label' => "All tags",
          'active' => ($exploreFurtherTab === 4) ? true : false,
          'ajaxTabTarget' => 'exploreFurther',
        ),
      ),
    ));
    $article->push('galleryImages', collect($this->getImages($this->faker->numberBetween(1,10))));
    //$article->push('galleryImages', $this->getImages(1));
    $article->push('recentlyViewedArtworks', $this->getArtworks($this->faker->numberBetween(6,20)));
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
      'contrastHeader' => ($article->headerType === 'feature' || $article->headerType === 'hero' || $article->headerType === 'super-hero'),
      'borderlessHeader' => true,
      'article' => $article,
    ]);
  }

  public function video() {
    $relatedVideos = $this->getArticles(4);
    $newRelatedVideos = [];

    foreach ($relatedVideos as $vid) {
        $vid->subtype = null;
        $vid->isVideo = true;

        $newRelatedVideos[] = $vid;
    }

    $article = (object)[
        'articleType' => 'video',
        'type' => 'video',
        'id' => $this->faker->uuid,
        'slug' => "/statics/video",
        'title' => $this->faker->sentence(6, true),
        'date' => $this->makeDate(),
        'intro' => $this->faker->paragraph(6, false),
        'video' => [
            'type' => 'embed',
            'size' => 'l',
            'media' => $this->getEmbed('youtube'),
            "poster" => $this->getImage(),
            'hideCaption' => true
        ],
        'blocks' => [
            [
                "type" => 'text',
                "content" => $this->generateParagraph(12, false)
            ],
            [
                "type" => 'text',
                "content" => $this->generateParagraph(12, false)
            ]
        ],
        'relatedVideos' => $newRelatedVideos,
        'recentlyViewedArtworks' => $this->getArtworks($this->faker->numberBetween(6,20)),
    ];

    // $article = $this->getExhibition();
    // $article->push('articleType', 'video');
    // $article->push('headerImage', $this->getImage());
    // $article->push('intro', $this->faker->paragraph(6, false));
    // $article->push('blocks', $this->generateBlocks('all'));
    // $article->push('nav', array(array('label' => 'Galleries 182-184', 'href' => '#', 'iconBefore' => 'location')));
    // $article->push('relatedEventsByDay', $this->makeEventsByDates(1));
    // $article->push('relatedExhibitions', $this->getExhibitions(4));
    // $article->push('relatedEvents', $this->getEvents(4));
    // $article->push('relatedArticles', $this->getArticles(4));
    // $article->push('featuredRelated', array(
    //    'type' => 'event',
    //    'items' => $this->getEvents(1),
    // ));

    return view('statics/video', [
      'article' => $article,
    ]);
  }

  public function collection() {
    $quickSearchLinks = array();
    for ($i = 0; $i < 20; $i++) {
      array_push($quickSearchLinks,
        array(
          'href' => '#',
          'label' => $this->faker->word(),
          'image' => $this->getImage(),
        )
      );
    }

    $filters = array();
    for ($i = 0; $i < 20; $i++) {
      array_push($filters,
        array(
          'href' => '#',
          'label' => $this->faker->word(),
          'count' => $this->faker->numberBetween(13,1312),
        )
      );
    }
    // now push to a view
    return view('statics/collection', [
      'primaryNavCurrent' => 'collection',
      'title' => 'The Collection',
      'intro' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus eget laoreet <em>tortor quisque tristique laoreet</em> lectus sit amet tempus. Aliquam vel eleifend nisi.',
      'onViewLink' => (isset($_GET['onview']) && $_GET['onview'] === 'true') ? '/statics/collection' : '/statics/collection?onview=true',
      'onViewActive' => (isset($_GET['onview']) && $_GET['onview'] === 'true'),
      'quickSearchLinks' => $quickSearchLinks,
      'filterCategories' => $this->generateCollectionFilterCategories(),
      'hasAnyFilter' => false,
      'activeFilters' => array(
        array(
          'href' => '#',
          'label' => "Arms",
        ),
        array(
          'href' => '#',
          'label' => "Legs",
        ),
      ),
      'artworks' => $this->getArtworks(20),
      'recentlyViewedArtworks' => $this->getArtworks($this->faker->numberBetween(6,20)),
      'interestedThemes' => array(
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
      ),
      'featuredArticlesHero' => $this->getArticle(),
      'featuredArticles' => $this->getArticles(4),
    ]);
  }

  public function collection_filters_search() {
    return [
        'html' => view('statics.collection_filters_search', [
            'links' => $this->generateFilterList(8)
        ])->render(),
    ];
  }

  public function collection_no_results() {
    $quickSearchLinks = array();
    for ($i = 0; $i < 20; $i++) {
      array_push($quickSearchLinks,
        array(
          'href' => '#',
          'label' => $this->faker->word(),
          'image' => $this->getImage(),
        )
      );
    }

    $filters = array();
    for ($i = 0; $i < 20; $i++) {
      array_push($filters,
        array(
          'href' => '#',
          'label' => $this->faker->word(),
          'count' => $this->faker->numberBetween(13,1312),
        )
      );
    }
    // now push to a view
    return view('statics/collection', [
      'primaryNavCurrent' => 'collection',
      'title' => 'The Collection',
      'intro' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus eget laoreet <em>tortor quisque tristique laoreet</em> lectus sit amet tempus. Aliquam vel eleifend nisi.',
      'quickSearchLinks' => $quickSearchLinks,
      'filters' => $filters,
      'filterCategories' => $this->generateCollectionFilterCategories(),
      'featuredArticlesHero' => $this->getArticle(),
      'featuredArticles' => $this->getArticles(4),
    ]);
  }

  public function collectionsAutocomplete(){
    $items = array();

    for ($i = 0; $i < 5; $i++) {
      array_push($items, array(
          'href' => '#',
          'label' => $this->faker->words(3, true),
      ));
    }

    return view('components/molecules/_m-search-bar__autocomplete', [
        'items' => $items
    ]);
  }

  public function visit() {
    $items = $this->getVisitItems();
    // now push to a view
    return view('statics/visit', $items);
  }

  public function visit_video() {
    $items = $this->getVisitItems();
    $items['headerMedia'] = array(
        'type' => 'video',
        'size' => 'hero',
        'media' => $this->getVideo(),
        'hideCaption' => true,
    );
    // now push to a view
    return view('statics/visit', $items);
  }

  public function exhibition_history() {
    // now push to a view
    return view('statics/exhibition_history', [
      'primaryNavCurrent' => 'exhibitions_and_events',
      'title' => 'Plan Your Visit',
      'intro' => $this->faker->sentence(20, false),
      'media' => array(
        'type' => 'image',
        'size' => 's',
        'media' => $this->getImage(),
        'hideCaption' => true,
       ),
      'blocks' => $this->generateBlocks(1),
      'exhibitions' => $this->getExhibitionHistoryDetails(10),
      'recentlyViewedArtworks' => $this->getArtworks($this->faker->numberBetween(6,20)),
      'interestedThemes' => array(
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
      ),
    ]);
  }

  public function exhibition_history_no_results() {
    // now push to a view
    return view('statics/exhibition_history', [
      'primaryNavCurrent' => 'exhibitions_and_events',
      'title' => 'Plan Your Visit',
      'intro' => $this->faker->sentence(20, false),
      'media' => array(
        'type' => 'image',
        'size' => 's',
        'media' => $this->getImage(),
        'hideCaption' => true,
       ),
      'blocks' => $this->generateBlocks(1),
      'exhibitions' => [],
      'recentlyViewedArtworks' => $this->getArtworks($this->faker->numberBetween(6,20)),
      'interestedThemes' => array(
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
      ),
    ]);
  }

  public function exhibition_history_detail() {

    $blocks = array();

    $article = $this->getExhibitionHistoryDetail();
    $article->push('articleType', 'exhibitionHistory');
    $article->push('blocks', $blocks);
    $article->push('nav', array(array('label' => 'Galleries 182-184', 'href' => '#', 'iconBefore' => 'location')));
    $article->push('relatedExhibitionsTitle', 'On View');
    $article->push('relatedExhibitions', $this->getExhibitions(4));
    $article->push('catalogues', $this->generateFiles($this->faker->numberBetween(1,3)));
    $article->push('pictures', $this->generatePictures($this->faker->numberBetween(2,5)));
    $article->push('otherResources', $this->generateFiles($this->faker->numberBetween(2,5)));

    return view('statics/article', [
      'contrastHeader' => ($article->headerType === 'feature' || $article->headerType === 'hero' || $article->headerType === 'super-hero'),
      'article' => $article,
    ]);
  }

  public function artist_tag() {
    $article = $this->getArtistTag(true);

    // now push to a view
    return view('statics/artist_tag', [
      "article" => $article,
    ]);
  }

  public function artist_tag_no_intro() {
    $article = $this->getArtistTag();

    // now push to a view
    return view('statics/artist_tag', [
      "article" => $article,
    ]);
  }

  public function generic_listing() {
    $navs = $this->generateGenericNav('landing');
    $filters = array(
        array(
            'prompt' => 'Months',
            'links' => array(
                array('href' => '#', 'label' => 'All', 'active' => true),
                array('href' => '#', 'label' => 'December'),
                array('href' => '#', 'label' => 'November'),
                array('href' => '#', 'label' => 'October'),
                array('href' => '#', 'label' => 'September'),
                array('href' => '#', 'label' => 'August'),
            ),
        ),
    );
    // now push to a view
    return view('statics/generic', [
      'title' => 'Press Releases',
      'subNav' => $navs['subNav'],
      'nav' => $navs['nav'],
      "breadcrumb" => $this->generateGenericBreadcrumb(),
      'wideBody' => true,
      'filters' => $filters,
      'listingCountText' => 'Showing 1-10 press releases',
      'listingItems' => $this->getPressReleases(10),
    ]);
  }

  public function generic_listing_no_results() {
    $navs = $this->generateGenericNav('landing');
    $filters = array(
        array(
            'prompt' => 'Months',
            'links' => array(
                array('href' => '#', 'label' => 'All'),
                array('href' => '#', 'label' => 'December'),
                array('href' => '#', 'label' => 'November'),
                array('href' => '#', 'label' => 'October'),
                array('href' => '#', 'label' => 'September', 'active' => true),
                array('href' => '#', 'label' => 'August'),
            ),
        ),
    );
    // now push to a view
    return view('statics/generic', [
      'title' => 'Press Releases',
      'subNav' => $navs['subNav'],
      'nav' => $navs['nav'],
      "breadcrumb" => $this->generateGenericBreadcrumb(),
      'wideBody' => true,
      'filters' => $filters,
      'listingCountText' => 'Showing 1-10 press releases',
      'listingItems' => [],
    ]);
  }

  public function faq() {
    $navs = $this->generateGenericNav('landing');
    $questionsAndAnswers = array();
    for ($i = 0; $i < 5; $i++) {
        array_push($questionsAndAnswers, array(
            "type" => 'text',
            "subtype" => 'heading-2',
            "content" => $this->generateHeading(6, 'h3')
        ));
        array_push($questionsAndAnswers, array(
            "type" => 'text',
            "content" => $this->generateParagraph(3)
        ));
    }
    $accordion = array();
    for ($i = 0; $i < 10; $i++) {
        array_push($accordion, array(
            'title' => "Static question title ".($i + 1),
            'blocks' => $questionsAndAnswers,
        ));
    }
    $blocks = array();
    array_push($blocks, array(
        "type" => 'accordion',
        "variation" => 'o-accordion--alt',
        "titleFont" => 'f-list-4',
        "content" => $accordion,
    ));
    // now push to a view
    return view('statics/generic', [
      'title' => 'FAQ',
      'subNav' => $navs['subNav'],
      'nav' => $navs['nav'],
      "breadcrumb" => $this->generateGenericBreadcrumb(),
      'wideBody' => true,
      "blocks" => $blocks,
    ]);
  }

  public function articles() {
    // now push to a view
    return view('statics/articles', [
      'title' => 'Articles',
      'heroArticle' => $this->getArticle(),
      'featuredArticles' => $this->getArticles(2),
      'articles' => $this->getArticles(20),
    ]);
  }

  public function generic_form() {
    $navs = $this->generateGenericNav('landing');
    // now push to a view
    return view('statics/generic', [
        'subNav' => $navs['subNav'],
        'nav' => $navs['nav'],
        'title' => $this->faker->sentence(),
        "breadcrumb" => $this->generateGenericBreadcrumb(),
        "blocks" => $this->generateGenericForm(),
    ]);
  }

  public function contact() {
    $nav = array(
        array('label' => 'Contact Us', 'href' => '#', 'active' => true),
    );
    $blocks = array();
    array_push($blocks, array(
        "type" => 'media',
        "content" => array(
            'type' => 'image',
            'size' => 's',
            'media' => $this->getImage(),
            'hideCaption' => true,
        )
    ));
    array_push($blocks, array(
        "type" => 'intro',
        "content" => 'Curabitur velit libero, pretium sed ullamcorper eget, rutrum a nisl. Maecenas lacinia sit amet magna dignissim dapibus. Cras convallis <a href="#">lectus eget pulvinar tristique</a>. Maecenas <strong>consequat</strong> egestas est, in <em>luctus urna</em> porta rhoncus. Quisque id massa tristique, tincidunt risus vel, gravida justo.'
    ));
    array_push($blocks, array(
        "type" => 'text',
        "content" => '<p>Curabitur velit libero, pretium sed ullamcorper eget, rutrum a nisl. Maecenas lacinia sit amet magna dignissim dapibus. Cras convallis <a href="#">lectus eget pulvinar tristique</a>. Maecenas <strong>consequat</strong> egestas est, in <em>luctus urna</em> porta rhoncus. Quisque id massa tristique, tincidunt risus vel, gravida justo.</p>'
    ));
    array_push($blocks, array(
        "type" => 'text',
        "content" => $this->generateParagraph(2)
    ));
    array_push($blocks, array(
        "type" => 'info-bar',
        "icon" => 'icon--info',
        "blocks" => array(
            array(
                "type" => 'text',
                "content" => $this->generateParagraph(2)
            ),
        ),
    ));
    array_push($blocks, array(
        "type" => 'text',
        "subtype" => 'heading-2',
        "content" => $this->generateHeading(6, 'h3')
    ));
    array_push($blocks, array(
        "type" => 'text',
        "content" => $this->generateParagraph(2)
    ));
    array_push($blocks, array(
        "type" => 'text',
        "subtype" => 'heading-2',
        "content" => $this->generateHeading(6, 'h3')
    ));
    array_push($blocks, array(
        "type" => 'text',
        "content" => $this->generateParagraph(2)
    ));

    // now push to a view
    return view('statics/generic', [
        'nav' => $nav,
        'title' => "Contact Us",
        "blocks" => $blocks,
    ]);
  }

  public function articles_publications_landing() {
      return view('statics/articles_publications_landing', [
          'primaryNavCurrent' => 'collection',
          'title' => 'The Collection',
          'intro' => 'Explore <em>over 100,000 artworks</em> and information about works of art from all areas in our online encyclopedic collections.',
          'linksBar' => [
              [
                'href' => '#',
                'label' => 'Artworks',
              ],
              [
                'href' => '#',
                'label' => 'Articles & Publications',
                'active' => true,
              ],
              [
                'href' => '#',
                'label' => 'Research & Resources',
              ],
          ],
          'featureHero' => $this->getArticle(),
          'features' => $this->getArticles(4),
          'digitalCatalogs' => [
              'items' => $this->getCatalogs(3),
          ],
          'printedCatalogs' => [
              'intro' => $this->faker->paragraph(),
              'items' => $this->getCatalogs(4), // image dims should be max of 160x160 on printed catalogs
          ],
          'journalHero' => $this->getArticle(),
          'journals' => $this->getArticles(4),
      ]);
  }

  public function research_landing() {
      return view('statics/research_landing', [
          'primaryNavCurrent' => 'collection',
          'title' => 'The Collection',
          'intro' => 'Explore <em>over 100,000 artworks</em> and information about works of art from all areas in our online encyclopedic collections.',
          'linksBar' => [
              [
                'href' => '#',
                'label' => 'Artworks',
              ],
              [
                'href' => '#',
                'label' => 'Articles & Publications',
              ],
              [
                'href' => '#',
                'label' => 'Research & Resources',
                'active' => true,
              ],
          ],
          'hero' => (object)[
              'image' => $this->getImage(),
              'primary' => $this->faker->sentence(8),
              'secondary' => $this->faker->sentence(8),
          ],
          'items' => [
              [
                  'image' => $this->getImage(),
                  'title' => 'Libraries',
                  'titleLink' => '#',
                  'text' => 'The Ryerson & Burnham Libraries constitute a major art and architecure research collection service The Art Institute of Chicago...',
                  'links' => [
                      [
                          'href' => '#',
                          'label' => 'Library Catalog',
                          'external' => true,
                      ],
                      [
                          'href' => '#',
                          'label' => 'Library Catalog Help',
                      ]
                  ]
              ],
              [
                  'image' => $this->getImage(),
                  'title' => 'Art & Architecture Archives',
                  'titleLink' => '#',
                  'text' => 'The Archives’ collections are notably strong in late 19th- and 20th-century American architecture, with particular depth...',
              ],
              [
                  'image' => $this->getImage(),
                  'title' => 'Research Guides',
                  'titleLink' => '#',
                  'text' => 'When starting your research, explore the guides. To consult with an actual librarian, visit the reference desk...',
                  'links' => [
                      [
                          'href' => '#',
                          'label' => 'Researching Art or Artists',
                      ],
                      [
                          'href' => '#',
                          'label' => 'Researching a Work from the Collections',
                      ],
                      [
                          'href' => '#',
                          'label' => 'Find the Value of a Work of Art',
                      ],
                      [
                          'href' => '#',
                          'label' => 'Find the Value of a Book',
                      ]
                  ]
              ],
              [
                  'image' => $this->getImage(),
                  'title' => 'Scholarly Initiatives',
                  'titleLink' => '#',
                  'text' => 'The Ryerson & Burnham Libraries constitute a major art and architecure research collection service The Art Institute of Chicago...',
              ],
              [
                  'image' => $this->getImage(),
                  'title' => 'Educator Resources',
                  'titleLink' => '#',
                  'text' => 'The Archives’ collections are notably strong in late 19th- and 20th-century American architecture, with particular depth...',
              ],
              [
                  'image' => $this->getImage(),
                  'title' => 'Provenance',
                  'titleLink' => '#',
                  'text' => 'When starting your research, explore the guides. To consult with an actual librarian, visit the reference desk...',
              ],
          ],
          'studyRooms' => [
              [
                  'title' => 'Prints and Drawings',
                  'titleLink' => '#',
                  'text' => 'The Ryerson & Burnham Libraries constitute a major art and architecure research collection service The Art Institute of Chicago...',
              ],
              [
                  'title' => 'Photography',
                  'titleLink' => '#',
                  'text' => 'The Archives’ collections are notably strong in late 19th- and 20th-century American architecture, with particular depth...',
              ],
              [
                  'title' => 'Ryerson Special Collections',
                  'titleLink' => '#',
                  'text' => 'When starting your research, explore the guides. To consult with an actual librarian, visit the reference desk...',
              ],
          ]
      ]);
  }

  public function search_results() {
    $eventsAndExhibitions = array();
    for ($i = 0; $i < 2; $i++) {
      $event = $this->getEvent();
      $event->push('listingType','event');
      array_push($eventsAndExhibitions, $event);
    }
    for ($i = 0; $i < 2; $i++) {
      $exhibition = $this->getExhibition();
      $exhibition->push('listingType','exhibition');
      array_push($eventsAndExhibitions, $exhibition);
    }
    $eventsAndExhibitions = $this->faker->shuffle($eventsAndExhibitions);

    $articlesAndPublications = array();
    for ($i = 0; $i < 2; $i++) {
      $article = $this->getArticle();
      $article->push('listingType','article');
      array_push($articlesAndPublications, $article);
    }
    for ($i = 0; $i < 1; $i++) {
      $selection = $this->getSelection();
      $selection->push('listingType','selection');
      array_push($articlesAndPublications, $selection);
    }
    $articlesAndPublications = $this->faker->shuffle($articlesAndPublications);

    $featuredResults = array();
    array_push($featuredResults, array(
        'type' => 'artist',
        'item' => $this->getArtist($this->faker->boolean()),
    ));
    /*
    array_push($featuredResults, array(
        'type' => 'event',
        'item' => $this->getEvent(),
    ));
    array_push($featuredResults, array(
        'type' => 'exhibition',
        'item' => $this->getExhibition(),
    ));
    array_push($featuredResults, array(
        'type' => 'page',
        'item' => $this->getPage(),
    ));
    array_push($featuredResults, array(
        'type' => 'artwork',
        'item' => $this->getArtwork(),
    ));
    array_push($featuredResults, array(
        'type' => 'article',
        'item' => $this->getArticle(),
    ));
    array_push($featuredResults, array(
        'type' => 'selection',
        'item' => $this->getSelection(),
    ));
    */

    // now push to a view
    return view('statics/search_results', [
        'title' => "Search Results",
        'searchTerm' => 'Picasso',
        'searchResultsTypeLinks' => $this->searchResultsNavLinks('all'),
        'featuredResults' => $featuredResults,
        'artists' => array(
          'results' => $this->getArtists(6),
          'totalResults' => '124',
          'allResultsHref' => '/statics/search_results_artists',
          'pagination' => null,
          'allResultsView' => null,
        ),
        'pages' => array(
          'results' => $this->getPages(3),
          'totalResults' => '6',
          'allResultsHref' => '/statics/search_results_pages',
          'pagination' => null,
          'allResultsView' => null,
        ),
        'artworks' => array(
          'results' => $this->getArtworks(8),
          'totalResults' => '1,242',
          'allResultsHref' => '/statics/search_results_artworks',
          'pagination' => null,
          'allResultsView' => null,
        ),
        'eventsAndExhibitions' => array(
          'results' => $eventsAndExhibitions,
          'totalResults' => '6',
          'allResultsHref' => '/statics/search_results_events_and_exhibitions',
          'pagination' => null,
          'allResultsView' => null,
        ),
        'articlesAndPublications' => array(
          'results' => $articlesAndPublications,
          'totalResults' => '6',
          'allResultsHref' => '/statics/search_results_articles_and_publications',
          'pagination' => null,
          'allResultsView' => null,
        ),
        'researchAndResources' => array(
          'results' => $this->getPages(3),
          'totalResults' => '11',
          'allResultsHref' => '/statics/search_results_research_and_resources',
          'pagination' => null,
          'allResultsView' => null,
        ),
    ]);
  }

  public function search_results_no_results() {

    // now push to a view
    return view('statics/search_results', [
        'title' => "Search Results",
        'searchTerm' => 'Darth Vader',
    ]);
  }

  public function search_results_artists() {

    // now push to a view
    return view('statics/search_results', [
        'title' => "Search Results",
        'searchTerm' => 'Picasso',
        'searchResultsTypeLinks' => $this->searchResultsNavLinks('artists'),
        'artists' => array(
          'results' => $this->getArtists(33),
          'totalResults' => null,
          'allResultsHref' => null,
          'pagination' => true,
          'allResultsView' => true,
        ),
    ]);
  }

  public function search_results_pages() {

    $boolean = $this->faker->boolean() ? true : false;

    // now push to a view
    return view('statics/search_results', [
        'title' => "Search Results",
        'searchTerm' => 'Picasso',
        'searchResultsTypeLinks' => $this->searchResultsNavLinks('pages'),
        'pages' => array(
          'results' => $boolean ? $this->getPages(24) : $this->getPages(6),
          'totalResults' => null,
          'allResultsHref' => null,
          'pagination' => $boolean,
          'allResultsView' => true,
        ),
    ]);
  }

  public function search_results_artworks() {

    // now push to a view
    return view('statics/search_results', [
        'title' => "Search Results",
        'searchTerm' => 'Picasso',
        'searchResultsTypeLinks' => $this->searchResultsNavLinks('artworks'),
        'artworks' => array(
          'results' => $this->getArtworks(24),
          'totalResults' => null,
          'allResultsHref' => null,
          'pagination' => true,
          'allResultsView' => true,
          'activeFilters' => array(
              array(
                'href' => '#',
                'label' => "Arms",
              ),
              array(
                'href' => '#',
                'label' => "Legs",
              ),
              array(
                'href' => '#',
                'label' => "Arms",
              ),
              array(
                'href' => '#',
                'label' => "Legs",
              ),
              array(
                'href' => '#',
                'label' => "Arms",
              ),
              array(
                'href' => '#',
                'label' => "Legs",
              ),
            ),
            'filterCategories' => $this->generateCollectionFilterCategories(),
        ),
    ]);
  }

  public function search_results_events_and_exhibitions() {
    $eventsAndExhibitions = array();
    for ($i = 0; $i < 12; $i++) {
      $event = $this->getEvent();
      $event->push('listingType','event');
      array_push($eventsAndExhibitions, $event);
    }
    for ($i = 0; $i < 12; $i++) {
      $exhibition = $this->getExhibition();
      $exhibition->push('listingType','exhibition');
      array_push($eventsAndExhibitions, $exhibition);
    }
    $eventsAndExhibitions = $this->faker->shuffle($eventsAndExhibitions);

    // now push to a view
    return view('statics/search_results', [
        'title' => "Search Results",
        'searchTerm' => 'Picasso',
        'searchResultsTypeLinks' => $this->searchResultsNavLinks('exhibitionsAndEvents'),
        'eventsAndExhibitions' => array(
          'results' => $eventsAndExhibitions,
          'totalResults' => null,
          'allResultsHref' => null,
          'pagination' => true,
          'allResultsView' => true,
        ),
    ]);
  }

  public function search_results_articles_and_publications() {
    $articlesAndPublications = array();
    for ($i = 0; $i < 18; $i++) {
      $article = $this->getArticle();
      $article->push('listingType','article');
      array_push($articlesAndPublications, $article);
    }
    for ($i = 0; $i < 6; $i++) {
      $selection = $this->getSelection();
      $selection->push('listingType','selection');
      array_push($articlesAndPublications, $selection);
    }
    $articlesAndPublications = $this->faker->shuffle($articlesAndPublications);

    // now push to a view
    return view('statics/search_results', [
        'title' => "Search Results",
        'searchTerm' => 'Picasso',
        'searchResultsTypeLinks' => $this->searchResultsNavLinks('articlesAndPublications'),
        'articlesAndPublications' => array(
          'results' => $articlesAndPublications,
          'totalResults' => null,
          'allResultsHref' => null,
          'pagination' => true,
          'allResultsView' => true,
        ),
    ]);
  }

  public function search_results_research_and_resources() {

    $boolean = $this->faker->boolean() ? true : false;

    // now push to a view
    return view('statics/search_results', [
        'title' => "Search Results",
        'searchTerm' => 'Picasso',
        'searchResultsTypeLinks' => $this->searchResultsNavLinks('researchAndResources'),
        'researchAndResources' => array(
          'results' => $boolean ? $this->getPages(24) : $this->getPages(6),
          'totalResults' => null,
          'allResultsHref' => null,
          'pagination' => $boolean,
          'allResultsView' => true,
        ),
    ]);
  }

  // --------------------------------------------------------------------------------------------
  // Make some fake datas
  // --------------------------------------------------------------------------------------------

  private function getImageUrl()
  {
    $sourceType = 'placeholder';
    $width = $this->faker->numberBetween(2000,5000);
    $height = $this->faker->numberBetween(2000,5000);
    $src = "//placehold.dev.area17.com/image/".$width."x".$height."?bg=333&fg=ccc";

    return $src;
  }

  private function getImage($credit = null) {
    $sourceType = 'placeholder';
    $width = $this->faker->numberBetween(2000,5000);
    $height = $this->faker->numberBetween(2000,5000);
    $src = "//placehold.dev.area17.com/image/".$width."x".$height."?bg=333&fg=ccc";

    if ($credit) {
        $credit = $this->faker->sentence(3);
        $creditUrl = null;
    } else {
        $credit = $this->faker->boolean() ? $this->faker->sentence(3) : null;
        $creditUrl = ($credit && $this->faker->boolean()) ? '#' : null;
    }

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
        "alt" => "My image alt tag"
    );

    /*
    $image = array(
        "sourceType" => 'imgix',
        "src" => 'https://aic-cms-dev.imgix.net/fd860e9e-0875-4eef-89ba-4abf5beb3afb/screenshot2017-12-08at11.51.39am.png?auto=compress%2Cformat&fit=min&fm=jpg&q=80&rect=%2C%2C%2C',
        "width" => 1184,
        "height" => 592,
    );
    $image = array(
        "sourceType" => 'imgix',
        "src" => 'https://wyss-prod.imgix.net/app/uploads/2017/11/29103410/Falkor-IMG_7110.jpg?',
        "width" => 4000,
        "height" => 3000,
    );
    /**/
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
    $videos = array(
        array(
            'src' => 'http://1312img.s3.amazonaws.com/aic/feature-1.mp4',
            'poster' => 'http://1312img.s3.amazonaws.com/aic/feature-1.jpg',
            'fallbackImage' => $this->getImage(),
        ),
        array(
            'src' => 'http://1312img.s3.amazonaws.com/aic/feature-2.mp4',
            'poster' => 'http://1312img.s3.amazonaws.com/aic/feature-2.jpg',
            'fallbackImage' => $this->getImage(),
        ),
        array(
            'src' => 'http://1312img.s3.amazonaws.com/aic/feature-3.mp4',
            'poster' => 'http://1312img.s3.amazonaws.com/aic/feature-3.jpg',
            'fallbackImage' => $this->getImage(),
        ),
    );
    return $this->faker->randomElement($videos);
  }

  private function getEmbed($type = null) {
    $embed = array();
    $soundcloud = ($type !== 'youtube' && ($this->faker->boolean() || $type == 'soundcloud'));
    if ($soundcloud) {
        $embed = array(
            'embed' => '<iframe width="100%" height="300" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/348258574&color=%23b50938&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true"></iframe>',
        );
    } else {
        $embed = array(
            'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/LjV3OcqI_CY?rel=0&amp;showinfo=0" frameborder="0" allow="autoplay" gesture="media" allow="encrypted-media" allowfullscreen></iframe>',
        );
    }
    return $embed;
  }

  private function getGalleryImages($num = 6, $type = false) {
      $images = array();
      if ($type === 'artworks') {
        for ($i = 0; $i < $num; $i++) {
          // need to convert the artwork item to media
          $artwork = $this->getArtwork();
          $artworkItem = array();
          $artworkItem['type'] = 'image';
          $artworkItem['size'] = 'gallery';
          $artworkItem['media'] = $artwork->imageFront();
          $artworkItem['captionTitle'] = $artwork->title;
          $artworkItem['caption'] = $artwork->artist.', '.$artwork->year.' <br>'.$artwork->galleryLocation;
          $artworkItem['hideShare'] = true;
          $artworkItem['fullscreen'] = true;

          array_push($images, $artworkItem);
        }
      } else {
          $artwork = $this->getArtwork();
          $artworkItem = array();
          $artworkItem['type'] = 'image';
          $artworkItem['size'] = 'gallery';
          $artworkItem['media'] = $artwork->imageFront();
          $artworkItem['captionTitle'] = $artwork->title;
          $artworkItem['caption'] = $artwork->artist.', '.$artwork->year.' <br>'.$artwork->galleryLocation;
          $artworkItem['hideShare'] = true;
          $artworkItem['fullscreen'] = true;

        for ($i = 0; $i < $num; $i++) {
          if ($i == 5) {
            array_push($images, array(
                  'type' => 'embed',
                  'size' => 'gallery',
                  'media' => $this->getEmbed(),
                  "poster" => $this->getImage(),
                  'caption' => $this->faker->paragraph(3, false),
                  'isArtwork' => true,
              )
            );
          } else if ($i == 1 || $i === 2) {
              if ($i === 2) {
                  $artworkItem['url'] = '#';
              }
              array_push($images, $artworkItem);
          } else {
            array_push($images, array(
                  'type' => 'image',
                  'size' => 'gallery',
                  'media' => $this->getImage(),
                  'caption' => $this->faker->paragraph(3, false),
                  'url' => $this->faker->boolean() ? '#' : null,
                  'isArtwork' => true,
              )
            );
          }
        }
      }
      return $images;
    }

  private function makeDate() {
    $timestamp = $this->faker->unixTime();
    return Carbon::createFromTimestamp($timestamp);
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

  private function getExhibition($upcoming = false) {
    return new StaticObjectPresenter([
      "type" => $this->getExhibitionType($upcoming),
      "id" => $this->faker->uuid,
      "slug" => "/statics/exhibition",
      "title" => $this->faker->sentence(6, true),
      "dateStart" => $this->makeDate(),
      "dateEnd" => $this->makeDate(),
      "formattedDate" => $this->makeDate()->format('F j, Y'),
      "closingSoon" => $this->faker->boolean(10),
      "exclusive" => $this->faker->boolean(10),
      "nowOpen" => $this->faker->boolean(10),
      "listingType" => 'exhibition',
      "list_description" => $this->faker->paragraph(10),
      "imageFront" => function () {
        return $this->getImage();
      },

      "present" => function () use ($upcoming) {
        return new StaticObjectPresenter([
            'exhibitionType' => $this->getExhibitionType($upcoming),
            "formattedDate" => $this->makeDate()->format('F j, Y'),
        ]);
      },

      "imageAsArray" => function () {
        return $this->getImage();
      }
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

  private function getExhibitionHistoryDetail() {

    $boolean = $this->faker->boolean();

    return new StaticObjectPresenter([
      "type" => "exhibition",
      "id" => $this->faker->uuid,
      "slug" => $boolean ? "/statics/exhibition_history_detail" : null,
      "title" => $this->faker->sentence(6, true),
      "dateStart" => $this->makeDate(),
      "dateEnd" => $this->makeDate(),
      "imageFront" => $boolean ? function() {return $this->getImage();} : null,
      'short_description' => $this->faker->paragraph(6, false),
      'listing_description' => $this->faker->paragraph(6, false),
    ]);
  }

  private function getExhibitionHistoryDetails($num = 3) {
    $items = array();
    for ($i = 0; $i < $num; $i++) {
      $item = $this->getExhibitionHistoryDetail();
      array_push($items, $item);
    }
    return $items;
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

    $timeStart = $this->makeEventTime($hour, ($this->faker->boolean() ? '00' : '30'));
    $timeEnd = $this->makeEventTime($hour + 1, ($this->faker->boolean() ? '00' : '30'));

    $ticketStatus = ['rsvp', 'buy-ticket', 'sold-out', 'free', 'register'];
    $randomTicketStatus = $ticketStatus[array_rand($ticketStatus)];

    return new StaticObjectPresenter([
      "type" => $this->getEventType(),
      "id" => $this->faker->uuid,
      "slug" => "/statics/event",
      "title" => $this->faker->sentence(6, true),
      "shortDesc" => $this->faker->paragraph(1, false),
      "list_description" => $this->faker->paragraph(1, false),
      "timeStart" => $timeStart,
      "timeEnd" => $timeEnd,
      "date" => $this->makeDate(),
      "dateStart" => $this->makeDate(),
      "dateEnd" => $this->makeDate(),
      "is_member_exclusive" => $this->faker->boolean(30),
      "imageFront" => function () {
         return $this->getImage();
      },
      "free" => $free,
      "register" => $register,
      "soldOut" => $soldOut,
      "is_ticketed" => true,
      "icsLink" => '#',
      "listingType" => 'event',

      // Add a presenter function to fit our integrations
      "present" => function () use ($timeStart, $timeEnd, $randomTicketStatus) {
        return new StaticObjectPresenter([
            'type' => $this->getEventType(),
            'nextOcurrenceDate' => $this->makeDate()->format('F j, Y'),
            'nextOcurrenceTime' => "{$timeStart} &ndash; {$timeEnd}",
            'ticketStatus' => $randomTicketStatus,
        ]);
      },

      "imageAsArray" => function () {
        return $this->getImage();
      }

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
      $thisDay = \Carbon\Carbon::parse($startDate)->format('Y-m-d');
      $dates[$thisDay] = $this->getEvents($this->faker->numberBetween(3,6));

      // TODO: Integrate ongoingEvents when we reach that view
      // 'ongoingEvents' => $this->getEvents($this->faker->numberBetween(1,3)),
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
      "description" => $this->faker->paragraph(1, false),
      "imageFront" => function () {
        return $this->getImage();
      },
      "price" => $price,
      "sale_price" => $priceSale,
      "currency" => "$",
      "type" => 'product',
      "listingType" => 'product',
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

  private function getOffer() {
    $priceRounded = $this->faker->boolean(70);
    $price = $this->faker->numberBetween(30,2500);

    if (!$priceRounded) {
      $price = $price - 0.01;
    }

    return new StaticObjectPresenter([
      "id" => $this->faker->uuid,
      "slug" => "#",
      "web_url" => "#",
      "title" => $this->faker->sentence(4, true),
      "label" => strtoupper($this->faker->word(1, true)),
      "shortDesc" => $this->faker->paragraph(1, false),
      "description" => $this->faker->paragraph(1, false),
      "imageFront" => function () {
        return $this->getImage();
      },
      "price" => $price,
      "currency" => "$",
      "type" => 'Offer',
      "listingType" => 'offer',
    ]);
  }

  private function getOffers($num = 5) {
    $offers = array();
    for ($i = 0; $i < $num; $i++) {
      $offer = $this->getOffer();
      array_push($offers, $offer);
    }
    return $offers;
  }

  private function getMedia() {
    return new StaticObjectPresenter([
      "id" => $this->faker->uuid,
      "slug" => "/statics/media",
      "title" => $this->faker->sentence(6, true),
      "image" => $this->getImage(),
      "imageFront" => function () { return $this->getImage(); },
      "timeStamp" => $this->faker->time(),
      "embed" => $this->getEmbed(),
      "type" => 'media',
      "listingType" => 'media'
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

  private function getArtist($intro = false) {
    $nationalities = array('American','French','Spanish','British','German','Dutch','Swiss');

    return new StaticObjectPresenter([
      "id" => $this->faker->uuid,
      "slug" => "/statics/artist",
      "title" => $this->faker->name(),
      "imageFront" => ($intro) ? function () { return $this->getImage(); } : null,
      'caption' => ($intro) ? $this->faker->sentence() : null,
      'also_known_as' => 'Rembrant',
      'birth_date' => strtotime('July 15, 1606'),
      'death_date' => strtotime('October 4 1669'),
      'nationality' => $this->faker->randomElement($nationalities),
      'blocks' => ($intro) ? $this->generateBlocks(2) : null,
      'intro' => ($intro) ? $this->generateParagraph() : null,
      'tags' => ($intro) ? array(
        array('label' => 'Baroque', 'href' => '#'),
        array('label' => 'Dutch Painters', 'href' => '#'),
       ) : null,
      "type" => 'artist',
      "listingType" => 'artist',
      "image" => ($intro) ? function(){
        return $this->getImage(); } : null,
      "imageAsArray" => ($intro) ? function(){
        return $this->getImage(); } : null,
    ]);
  }

  private function getArtists($num = 3) {
    $artists = array();
    for ($i = 0; $i < $num; $i++) {
      $artist = $this->getArtist( $this->faker->boolean() );
      array_push($artists, $artist);
    }
    return $artists;
  }

  private function getCatalog() {
    return new StaticObjectPresenter([
      "id" => $this->faker->uuid,
      "slug" => "/statics/catalog",
      "title" => $this->faker->sentence(),
      "imageFront" => function () {
        return $this->getImage();
      },
      "type" => 'catalog',
    ]);
  }

  private function getCatalogs($num = 3) {
    $catalogs = array();
    for ($i = 0; $i < $num; $i++) {
      $catalog = $this->getCatalog();
      array_push($catalogs, $catalog);
    }
    return $catalogs;
  }

  private function getPage() {

    $types = array('Musuem Spaces', 'Press Releases', 'About');

    return new StaticObjectPresenter([
      "id" => $this->faker->uuid,
      "slug" => "/statics/page",
      "title" => $this->faker->sentence(),
      "imageFront" => $this->faker->boolean() ? function() { return $this->getImage(); } : null,
      "shortDesc" => $this->faker->sentence(12, true),
      "subtype" => $this->faker->randomElement($types),
      "type" => 'page',
    ]);
  }

  private function getPages($num = 3) {
    $pages = array();
    for ($i = 0; $i < $num; $i++) {
      $page = $this->getPage();
      array_push($pages, $page);
    }
    return $pages;
  }

  private function getTimelineEvent() {
    $hour = $this->faker->numberBetween(10,19);

    return new StaticObjectPresenter([
      "title" => $this->faker->sentence(6, true),
      "time" => $this->makeEventTime($hour, ($this->faker->boolean() ? '00' : '30')),
      "blurb" => $this->faker->paragraph(5),
      "imageFront" => $this->faker->boolean() ? function() { return $this->getImage(); } : null,
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
      "year" => $this->faker->year(),
      "artist_display" => $this->faker->firstName.' '.$this->faker->lastName.', '.$this->faker->year(),
      "imageFront" => function() {
        return $this->getImage();
      },
      "galleryLocation" => "Gallery 239",
      "type" => 'artwork',
      "listingType" => 'artwork',
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
      "heading" => $this->faker->sentence(6, true),
      "author" => array(
        'img' => $this->getImage(),
        'name' => $this->faker->firstName.' '.$this->faker->lastName,
        'link' => '#',
      ),
      "intro" => $this->faker->sentence(12, true),
      "date" => $this->makeDate(),
      "imageFront" => function() {
        return $this->getImage();
      },
      "type" => 'article',
      "subtype" => $this->faker->word(),
      "listingType" => 'article',
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

  private function getPressRelease() {
    return new StaticObjectPresenter([
      "id" => $this->faker->uuid,
      "slug" => "/statics/article",
      "title" => $this->faker->sentence(6, true),
      "shortDesc" => $this->faker->sentence(12, true),
      "date" => $this->makeDate(),
      "imageFront" => function() {
        return $this->getImage();
      },
      "type" => 'generic',
      "listingType" => 'generic',
      "present" => function () {
        return new StaticObjectPresenter([
            "date" => $this->makeDate()->format('F j, Y'),
        ]);
      },
    ]);
  }

  private function getPressReleases($num = 3) {
    $items = array();
    for ($i = 0; $i < $num; $i++) {
      $item = $this->getPressRelease();
      array_push($items, $item);
    }
    return $items;
  }

  private function generateFile() {
    return array(
        'thumb' => $this->getImage(),
        'name' => 'AIC1970PandS69thAn_comb',
        'extension' => 'pdf',
        'size' => '2.1MB',
        'link' => '#',
    );
  }

  private function generateFiles($num = 3) {
    $files = array();
    for ($i = 0; $i < $num; $i++) {
      $file = $this->generateFile();
      array_push($files, $file);
    }
    return $files;
  }

  private function generatePicture() {
    return array(
        'type' => 'image',
        'size' => 's',
        'media' => $this->getImage(),
        'hideCaption' => true,
        'downloadable' => true,
    );
  }

  private function generatePictures($num = 3) {
    $pictures = array();
    for ($i = 0; $i < $num; $i++) {
      $picture = $this->generatePicture();
      array_push($pictures, $picture);
    }
    return $pictures;
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
      "imageFront" => function() {
        return $this->getImage();
      },
      "images" => $selectionImages,
      "type" => 'selection',
      "listingType" => 'selection',
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
        $thisItem = $_items[$i];
        $thisItemTitle = $thisItem->__get('title');
        $thisItem->push('title',($i+1).' '.$thisItemTitle);
        array_push($items, $thisItem);
    }
    return $items;
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

  private function generateGenericBreadcrumb($variant = 'short') {
    if ($variant === 'long') {
        return array(
            array('label' => 'About Us', 'href' => '#'),
            array('label' => 'Departments', 'href' => '#',),
            array('label' => 'Sed cursus, sem tristique euismod efficitur', 'href' => '#',),
            array('label' => 'Velit urna blandit velit', 'href' => '#',),
            array('label' => 'sollicitudin velit nisi nec purus', 'href' => '#',),
            array('label' => 'Proin commodo, erat rhoncus porta mollis, tortor odio luctus sapien, eget eleifend erat mi a urna', 'href' => '#',),
        );
    } else {
        return array(
            array('label' => 'Visit', 'href' => '#'),
            array('label' => 'Group Visits', 'href' => '#',),
            array('label' => 'Students', 'href' => '#',),
        );
    }
  }

  private function generateAllBlocksArticle($type = null) {
    $article = $this->getExhibition();
    $article->push('articleType', 'exhibition');
    $article->push('headerImage', $this->getImage());
    $article->push('intro', $this->faker->paragraph(6, false));
    if ($type === null) {
        $article->push('blocks', $this->generateBlocks('all'));
        $article->push('nav', array(array('label' => 'Galleries 182-184', 'href' => '#', 'iconBefore' => 'location')));
        $article->push('relatedExhibitions', $this->getExhibitions(4));
        $article->push('relatedEvents', $this->getEvents(4));
        $article->push('relatedOffers', $this->getOffers(3));
        $article->push('relatedArticles', $this->getArticles(4));
        $article->push('featuredRelated', array(
           'type' => 'event',
           'items' => $this->getEvents(1),
        ));
    } else if ($type === 'galleries') {
        $blocks = array();
        array_push($blocks, array(
            "type" => 'text',
            "content" => $this->generateParagraph(6)
        ));
        array_push($blocks, array(
            "type" => 'gallery',
            "subtype" => 'mosaic',
            "title" => 'Mosaic Gallery',
            "caption" => $this->faker->paragraph(3, false),
            "items" => $this->getGalleryImages(20),
        ));
        array_push($blocks, array(
            "type" => 'text',
            "content" => $this->generateParagraph(6)
        ));
        array_push($blocks, array(
            "type" => 'gallery',
            "subtype" => 'slider',
            "title" => 'Slider Gallery',
            "caption" => $this->faker->paragraph(3, false),
            "items" => $this->getGalleryImages(20),
        ));
        array_push($blocks, array(
            "type" => 'text',
            "content" => $this->generateParagraph(6)
        ));
        array_push($blocks, array(
            "type" => 'gallery',
            "subtype" => 'mosaic',
            "title" => 'Mosaic Gallery',
            "caption" => $this->faker->paragraph(3, false),
            "items" => $this->getGalleryImages(20),
            "allLink" => array(
              'href' => '#',
              'label' => "See all exhibition objects",
            ),
        ));
        array_push($blocks, array(
            "type" => 'text',
            "content" => $this->generateParagraph(6)
        ));
        array_push($blocks, array(
            "type" => 'gallery',
            "subtype" => 'slider',
            "title" => 'Slider Gallery',
            "caption" => $this->faker->paragraph(3, false),
            "items" => $this->getGalleryImages(20),
            "allLink" => array(
              'href' => '#',
              'label' => "See all exhibition objects",
            ),
        ));
        array_push($blocks, array(
            "type" => 'text',
            "content" => $this->generateParagraph(6)
        ));
        $article->push('blocks', $blocks);
    } else if ($type === 'cms') {
        $blocks = array();
        array_push($blocks, array(
            "type" => 'text',
            "content" => '<p>Dicta veritatis non rerum ut sequi. Voluptatum rem sapiente cum consequuntur magnam. Dolores nobis molestiae praesentium omnis omnis suscipit vel magnam. Et totam est quas dignissimos vel temporibus. Et omnis quos et reiciendis cum culpa asperiores.</p><p>Inventore sunt voluptatum maiores quia in. Ut earum minima similique ut exercitationem consequuntur. Non tenetur nihil aperiam facilis sunt sint. Cupiditate magni saepe et omnis consequatur. Sunt iure quam deleniti hic.</p>'
        ));
        array_push($blocks, array(
            "type" => 'media',
            "content" => array(
                'type' => 'image',
                'size' => 's',
                'media' => $this->getImage(),
                'caption' => $this->faker->paragraph(3, false)
            )
        ));
        array_push($blocks, array(
            "type" => 'text',
            "content" => '<p>Curabitur velit libero, pretium sed ullamcorper eget, rutrum a nisl. Maecenas lacinia sit amet magna dignissim dapibus. Cras convallis <a href="#">lectus eget pulvinar tristique</a>. Maecenas <strong>consequat</strong> egestas est, in <em>luctus urna</em> porta rhoncus. Quisque id massa tristique, tincidunt risus vel, gravida justo.</p><h2>Quisque id massa tristique</h2><p>Curabitur velit libero, pretium sed ullamcorper eget, rutrum a nisl. Maecenas lacinia sit amet magna dignissim dapibus. Cras convallis <a href="#">lectus eget pulvinar tristique</a>. Maecenas <strong>consequat</strong> egestas est, in <em>luctus urna</em> porta rhoncus. Quisque id massa tristique, tincidunt risus vel, gravida justo.</p><h3>Quisque id massa tristique</h3><p>Curabitur velit libero, pretium sed ullamcorper eget, rutrum a nisl. Maecenas lacinia sit amet magna dignissim dapibus. Cras convallis <a href="#">lectus eget pulvinar tristique</a>. Maecenas <strong>consequat</strong> egestas est, in <em>luctus urna</em> porta rhoncus. Quisque id massa tristique, tincidunt risus vel, gravida justo.</p><h2>Quisque id massa tristique</h2><p>Curabitur velit libero, pretium sed ullamcorper eget, rutrum a nisl. Maecenas lacinia sit amet magna dignissim dapibus.</p><ul><li>Qui sunt sint non repudiandae culpa.</li><li>Dignissimos unde et optio quam consequatur excepturi sunt.</li><li>In saepe quia explicabo quidem eos asperiores iure voluptatem.</li></ul><p>Curabitur velit libero, pretium sed ullamcorper eget, rutrum a nisl. Maecenas lacinia sit amet magna dignissim dapibus. Cras convallis <a href="#">lectus eget pulvinar tristique</a>. Maecenas <strong>consequat</strong> egestas est, in <em>luctus urna</em> porta rhoncus. Quisque id massa tristique, tincidunt risus vel, gravida justo.</p><ol><li>Qui sunt sint non repudiandae culpa.</li><li>Dignissimos unde et optio quam consequatur excepturi sunt.</li><li>In saepe quia explicabo quidem eos asperiores iure voluptatem.</li></ol>'
        ));
        array_push($blocks, array(
            "type" => 'media',
            "content" => array(
                'type' => 'video',
                'size' => 'm',
                'media' => $this->getVideo(),
                "poster" => $this->getImage(),
                'caption' => $this->faker->paragraph(3, false)
            )
        ));
        array_push($blocks, array(
            "type" => 'text',
            "content" => $this->generateParagraph(6)
        ));
        array_push($blocks, array(
            "type" => 'media',
            "content" => array(
                'type' => 'embed',
                'size' => 'l',
                'media' => $this->getEmbed(),
                "poster" => $this->getImage(),
                'caption' => $this->faker->paragraph(12, false)
            )
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
            "content" => $this->generateParagraph(6)
        ));
        array_push($blocks, array(
            "type" => 'gallery',
            "subtype" => 'slider',
            "title" => 'Slider Gallery',
            "caption" => $this->faker->paragraph(3, false),
            "items" => $this->getGalleryImages(6),
        ));
        array_push($blocks, array(
            "type" => 'media',
            "content" => array(
                'type' => 'embed',
                'size' => 'l',
                'media' => $this->getEmbed(),
                "poster" => $this->getImage(),
                'caption' => $this->faker->paragraph(3, false)
            )
        ));
        array_push($blocks, array(
            "type" => 'text',
            "content" => $this->generateParagraph(6)
        ));
        array_push($blocks, array(
            "type" => 'quote',
            "content" => $this->faker->paragraph(6, false)
        ));
        array_push($blocks, array(
            "type" => 'text',
            "content" => $this->generateParagraph(6)
        ));
        array_push($blocks, array(
            "type" => 'become-a-member',
        ));
        array_push($blocks, array(
            "type" => 'text',
            "content" => $this->generateParagraph(6)
        ));
        array_push($blocks, array(
            "type" => 'time-line',
            "items" => $this->getTimelineEvents(3)
        ));
        array_push($blocks, array(
            "type" => 'text',
            "content" => $this->generateParagraph(20)
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
            "content" => $this->generateParagraph(20)
        ));
        array_push($blocks, array(
            "type" => 'listing',
            "subtype" => 'product',
            "items" => $this->getProducts(3),
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
            "content" => $this->generateParagraph(12)
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
            "content" => $this->generateParagraph(20)
        ));
        array_push($blocks, array(
            "type" => 'artwork',
            "item" => $this->getArtwork(),
        ));
        array_push($blocks, array(
            "type" => 'text',
            "content" => $this->generateParagraph(12)
        ));
        $article->push('featuredRelated', array(
           'type' => 'event',
           'items' => $this->getEvents(1),
        ));
        $article->push('blocks', $blocks);
    }
    return $article;
  }

  public function generateArtworkBlocks() {

    $blocks = $this->generateBlocks(2);

    array_push($blocks, array(
      "type" => 'deflist',
      "items" => array(
        array('key' => $this->faker->sentence(3), 'value' => $this->faker->paragraph(5)),
        array('key' => $this->faker->sentence(3), 'value' => $this->faker->paragraph(5)),
        array('key' => $this->faker->sentence(3), 'value' => $this->faker->paragraph(5)),
        array('key' => $this->faker->sentence(3), 'value' => $this->faker->paragraph(5)),
        array('key' => $this->faker->sentence(3), 'value' => $this->faker->paragraph(5)),
      )
    ));

    array_push($blocks, array(
        "type" => 'accordion',
        "content" => array(
            array(
                'title' => 'Publication History',
                'blocks' => array(
                    array(
                        "type" => 'text',
                        "content" => $this->faker->sentence(8)
                    ),
                    array(
                        "type" => 'text',
                        "content" => $this->faker->sentence(8)
                    ),
                    array(
                        "type" => 'text',
                        "content" => $this->faker->sentence(8)
                    ),
                    array(
                        "type" => 'text',
                        "content" => $this->faker->sentence(8)
                    ),
                    array(
                        "type" => 'text',
                        "content" => $this->faker->sentence(8)
                    ),
                ),
            ),
            array(
                'title' => 'Exhibition History',
                'blocks' => array(
                    array(
                        "type" => 'text',
                        "content" => $this->faker->sentence(8)
                    ),
                    array(
                        "type" => 'text',
                        "content" => $this->faker->sentence(8)
                    ),
                ),
            ),
            array(
                'title' => 'Provenance',
                'blocks' => array(
                    array(
                        "type" => 'text',
                        "content" => $this->generateParagraph(12)
                    ),
                ),
            ),
            array(
                'title' => 'Catalogue Raisonne',
                'blocks' => array(
                    array(
                        "type" => 'text',
                        "content" => $this->generateParagraph(12)
                    ),
                ),
            ),
            array(
                'title' => 'Multimedia',
                'blocks' => array(
                    array(
                        "type" => 'listing',
                        "subtype" => 'media',
                        "items" => $this->getMedias(2),
                    ),
                ),
            ),
            array(
                'title' => 'Educational Resources',
                'blocks' => array(
                    array(
                        "type" => 'link-list',
                        "links" => array(
                              array('label' => $this->faker->sentence(8), 'href' => '#', 'iconAfter' => 'new-window'),
                              array('label' => $this->faker->sentence(8), 'href' => '#'),
                              array('label' => $this->faker->sentence(8), 'href' => '#'),
                          )
                    ),
                ),
            ),
        )
    ));
    array_push($blocks, array(
        "type" => 'hr',
    ));
    array_push($blocks, array(
        "type" => 'text',
        'subtype' => 'secondary',
        "content" => $this->generateParagraph()
    ));
    return $blocks;
  }

  private function generateHeading($num = 6, $tag = 'h2') {
    return '<'.$tag.'>'.$this->faker->sentence($num).'</'.$tag.'>';
  }

  private function generateParagraph($num = 6, $variableLength = true) {
    return '<p>'.$this->faker->paragraph($num, $variableLength).'</p>';
  }

  private function generateBlocks($num = 3) {

    $blocks = array();

    array_push($blocks, array(
        "type" => 'text',
        "content" => '<p>Curabitur velit libero, pretium sed ullamcorper eget, rutrum a nisl. Maecenas lacinia sit amet magna dignissim dapibus. Cras convallis <a href="#">lectus eget pulvinar tristique</a>. Maecenas <strong>consequat</strong> egestas est, in <em>luctus urna</em> porta rhoncus. Quisque id massa tristique, tincidunt risus vel, gravida justo.</p><h2>Quisque id massa tristique</h2><p>Curabitur velit libero, pretium sed ullamcorper eget, rutrum a nisl. Maecenas lacinia sit amet magna dignissim dapibus. Cras convallis <a href="#">lectus eget pulvinar tristique</a>. Maecenas <strong>consequat</strong> egestas est, in <em>luctus urna</em> porta rhoncus. Quisque id massa tristique, tincidunt risus vel, gravida justo.</p><h3>Quisque id massa tristique</h3><p>Curabitur velit libero, pretium sed ullamcorper eget, rutrum a nisl. Maecenas lacinia sit amet magna dignissim dapibus. Cras convallis <a href="#">lectus eget pulvinar tristique</a>. Maecenas <strong>consequat</strong> egestas est, in <em>luctus urna</em> porta rhoncus. Quisque id massa tristique, tincidunt risus vel, gravida justo.</p><h2>Quisque id massa tristique</h2><p>Curabitur velit libero, pretium sed ullamcorper eget, rutrum a nisl. Maecenas lacinia sit amet magna dignissim dapibus.</p><ul><li>Qui sunt sint non repudiandae culpa.</li><li>Dignissimos unde et optio quam consequatur excepturi sunt.</li><li>In saepe quia explicabo quidem eos asperiores iure voluptatem.</li></ul><p>Curabitur velit libero, pretium sed ullamcorper eget, rutrum a nisl. Maecenas lacinia sit amet magna dignissim dapibus. Cras convallis <a href="#">lectus eget pulvinar tristique</a>. Maecenas <strong>consequat</strong> egestas est, in <em>luctus urna</em> porta rhoncus. Quisque id massa tristique, tincidunt risus vel, gravida justo.</p><ol><li>Qui sunt sint non repudiandae culpa.</li><li>Dignissimos unde et optio quam consequatur excepturi sunt.</li><li>In saepe quia explicabo quidem eos asperiores iure voluptatem.</li></ol>'
    ));
    /*
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
        "content" => $this->generateParagraph(12, false)
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
        "type" => 'intro',
        "content" => $this->faker->paragraph(6, false)
    ));
    array_push($blocks, array(
        "type" => 'text',
        "content" => $this->generateParagraph(12, false)
    ));
    */
    array_push($blocks, array(
      "type" => 'deflist',
      "items" => array(
        array('key' => $this->faker->sentence(3), 'value' => $this->faker->paragraph(5)),
        array('key' => $this->faker->sentence(3), 'value' => $this->faker->paragraph(5)),
        array('key' => $this->faker->sentence(3), 'value' => $this->faker->paragraph(5)),
        array('key' => $this->faker->sentence(3), 'value' => $this->faker->paragraph(5)),
        array('key' => $this->faker->sentence(3), 'value' => $this->faker->paragraph(5)),
      )
    ));
    array_push($blocks, array(
        "type" => 'text',
        "content" => $this->generateParagraph(12, false)
    ));
    array_push($blocks, array(
        "type" => 'quote',
        "content" => $this->faker->paragraph(6, false)
    ));
    array_push($blocks, array(
        "type" => 'text',
        "content" => $this->generateParagraph(2)
    ));
    array_push($blocks, array(
        "type" => 'info-bar',
        "icon" => 'icon--info',
        "blocks" => array(
            array(
                "type" => 'text',
                "content" => $this->generateParagraph(2)
            ),
        ),
    ));
    array_push($blocks, array(
        "type" => 'text',
        "content" => $this->generateParagraph(2)
    ));
    array_push($blocks, array(
        "type" => 'media',
        "content" => array(
            'type' => 'image',
            'size' => 's',
            'media' => $this->getImage(),
            'caption' => $this->faker->paragraph(3, false)
        )
    ));
    array_push($blocks, array(
        "type" => 'media',
        "content" => array(
            'type' => 'image',
            'size' => 'm',
            'media' => $this->getImage(),
            'caption' => $this->faker->paragraph(3, false)
        )
    ));
    array_push($blocks, array(
        "type" => 'media',
        "content" => array(
            'type' => 'image',
            'size' => 'l',
            'media' => $this->getImage(),
            'caption' => $this->faker->paragraph(3, false)
        )
    ));
    array_push($blocks, array(
        "type" => 'media',
        "content" => array(
            'type' => 'video',
            'size' => 's',
            'media' => $this->getVideo(),
            "poster" => $this->getImage(),
            'caption' => $this->faker->paragraph(3, false)
        )
    ));
    array_push($blocks, array(
        "type" => 'media',
        "content" => array(
            'type' => 'embed',
            'size' => 's',
            'media' => $this->getEmbed(),
            "poster" => $this->getImage(),
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
        "content" => $this->generateParagraph(6, false)
    ));
    array_push($blocks, array(
        "type" => 'listing',
        "subtype" => 'media',
        "items" => $this->getMedias(3),
    ));
    array_push($blocks, array(
        "type" => 'text',
        "content" => $this->generateParagraph(6, false)
    ));
    array_push($blocks, array(
        "type" => 'listing',
        "subtype" => 'event',
        "items" => $this->getEvents(3),
    ));
    array_push($blocks, array(
        "type" => 'text',
        "content" => $this->generateParagraph(6, false)
    ));
    array_push($blocks, array(
        "type" => 'listing',
        "subtype" => 'product',
        "items" => $this->getProducts(3),
    ));
    array_push($blocks, array(
        "type" => 'text',
        "content" => $this->generateParagraph(6, false)
    ));
    array_push($blocks, array(
        "type" => 'aside',
        "subtype" => 'event',
        "items" => $this->getEvents(1),
    ));
    array_push($blocks, array(
        "type" => 'text',
        "content" => $this->generateParagraph(6, false)
    ));
    array_push($blocks, array(
        "type" => 'aside',
        "subtype" => 'event',
        "items" => $this->getEvents(3),
    ));
    array_push($blocks, array(
        "type" => 'text',
        "content" => $this->generateParagraph(6, false)
    ));
    array_push($blocks, array(
        "type" => 'aside',
        "subtype" => 'exhibition',
        "items" => $this->getExhibitions(1),
    ));
    array_push($blocks, array(
        "type" => 'text',
        "content" => $this->generateParagraph(6, false)
    ));
    array_push($blocks, array(
        "type" => 'aside',
        "subtype" => 'exhibition',
        "items" => $this->getExhibitions(3),
    ));
    array_push($blocks, array(
        "type" => 'text',
        "content" => $this->generateParagraph(6, false)
    ));
    array_push($blocks, array(
        "type" => 'aside',
        "subtype" => 'product',
        "items" => $this->getProducts(1),
    ));
    array_push($blocks, array(
        "type" => 'text',
        "content" => $this->generateParagraph(6, false)
    ));
    array_push($blocks, array(
        "type" => 'aside',
        "subtype" => 'product',
        "items" => $this->getProducts(3),
    ));
    array_push($blocks, array(
        "type" => 'text',
        "content" => $this->generateParagraph(6, false)
    ));
    array_push($blocks, array(
        "type" => 'text',
        "content" => $this->generateParagraph(6, false)
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
        "content" => $this->generateParagraph(6)
    ));
    array_push($blocks, array(
        "type" => 'accordion',
        "content" => array(
            array(
                'title' => $this->faker->sentence(6),
                'blocks' => array(
                    array(
                        "type" => 'text',
                        "content" => $this->generateParagraph(8)
                    ),
                    array(
                        "type" => 'text',
                        "content" => $this->generateParagraph(8)
                    ),
                ),
            ),
            array(
                'title' => $this->faker->sentence(6),
                'blocks' => array(
                    array(
                        "type" => 'text',
                        "content" => $this->generateParagraph(8)
                    ),
                    array(
                        "type" => 'text',
                        "content" => $this->generateParagraph(8)
                    ),
                ),
            ),
            array(
                'title' => $this->faker->sentence(6),
                'blocks' => array(
                    array(
                        "type" => 'text',
                        "content" => $this->generateParagraph(8)
                    ),
                    array(
                        "type" => 'text',
                        "content" => $this->generateParagraph(8)
                    ),
                ),
            ),
        )
    ));
    array_push($blocks, array(
        "type" => 'text',
        "content" => $this->generateParagraph(6)
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
        "content" => $this->generateParagraph(6)
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
        "content" => $this->generateParagraph(6)
    ));

    $blocks = array_merge($blocks, $this->generateGenericForm());

    array_push($blocks, array(
        "type" => 'text',
        "content" => $this->generateParagraph(6)
    ));

    array_push($blocks, array(
        "type" => 'inline-listing',
        "subtype" => 'page',
        "items" => $this->getPages(1)
    ));

    array_push($blocks, array(
        "type" => 'inline-grid',
        "subtype" => 'page',
        "items" => $this->getPages(2)
    ));

    array_push($blocks, array(
        "type" => 'text',
        "content" => $this->generateParagraph(6)
    ));

    array_push($blocks, array(
        "type" => 'artwork',
        "item" => $this->getArtwork(),
    ));

    array_push($blocks, array(
        "type" => 'text',
        "content" => $this->generateParagraph(6)
    ));

    array_push($blocks, array(
        "type" => 'gallery',
        "subtype" => 'slider',
        "title" => 'Slider Gallery',
        "caption" => $this->faker->paragraph(3, false),
        "items" => $this->getGalleryImages(6,'artworks'),
    ));

    array_push($blocks, array(
        "type" => 'text',
        "content" => $this->generateParagraph(6)
    ));


    if ($num === 'all') {
      return $blocks;
    } else {
      $generatedBlocks = array();
      for ($i = 0; $i < $num; $i++) {
        array_push($generatedBlocks, array(
          "type" => 'text',
          "content" => $this->generateParagraph(10)
        ));
      }
      return $generatedBlocks;
    }
  }

  private function generateFilterList($num = 20) {
    $filters = array();
    for ($i = 0; $i < $num; $i++) {
      array_push($filters,
        array(
          'href' => '/statics/collection?filter='.$i,
          'label' => $this->faker->word(),
          'count' => $this->faker->numberBetween(13,1312),
          'enabled' => false,
        )
      );
    }
    return $filters;
  }

  private function generateTags($num = 55) {
    $tags = array();
    for ($i = 0; $i < $num; $i++) {
      array_push($tags,
        array(
          'href' => '/statics/collection?filter='.$i,
          'label' => $this->faker->sentence(2,true),
        )
      );
    }
    return $tags;
  }

  private function generateCollectionFilterCategories() {

    $filtersCategories = array();

    array_push($filtersCategories, array(
        'type' => 'dropdown',
        'collapsible' => true,
        'title' => 'Sort By',
        'active' => false,
        'list' => $this->generateFilterList(5),
    ));

    array_push($filtersCategories, array(
        'type' => 'date',
        'title' => 'Date',
        'active' => false,
    ));

    array_push($filtersCategories, array(
        'type' => 'list',
        'title' => 'Geography',
        'active' => true,
        'listSearch' => true,
        'listSearchUrl' => '/statics/collection_filters_search',
        'list' => $this->generateFilterList(5),
    ));

    array_push($filtersCategories, array(
        'type' => 'list',
        'title' => 'Object Type',
        'active' => true,
        'list' => $this->generateFilterList(40),
    ));

    array_push($filtersCategories, array(
        'type' => 'list',
        'title' => 'Artist',
        'active' => true,
        'listSearch' => true,
        'listSearchUrl' => '/statics/collection_filters_search',
        'list' => $this->generateFilterList(5),
    ));

    array_push($filtersCategories, array(
        'type' => 'list',
        'title' => 'Classification',
        'list' => $this->generateFilterList(40),
    ));

    array_push($filtersCategories, array(
        'type' => 'list',
        'title' => 'Subject',
        'list' => $this->generateFilterList(5),
    ));

    array_push($filtersCategories, array(
        'type' => 'list',
        'title' => 'Medium',
        'list' => $this->generateFilterList(10),
    ));

    array_push($filtersCategories, array(
        'type' => 'list',
        'title' => 'Department',
        'list' => $this->generateFilterList(5),
    ));

    array_push($filtersCategories, array(
        'type' => 'list',
        'collapsible' => false,
        'title' => 'Show Only',
        'active' => true,
        'list' => $this->generateFilterList(5),
    ));

    return $filtersCategories;

  }

  function getArtistTag($intro = false) {
    $exploreFurtherTab = (isset($_GET['exploreFurtherTab'])) ? $_GET['exploreFurtherTab'] : 1;
    $article = $this->getArtist($intro);
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
    $article->push('artworks', $this->getArtworks(6));
    $article->push('artworksMoreLink', array(
        'href' => '#',
        'label' => 'See all 341 artworks',
        'variation' => 'btn--secondary',
    ));
    $article->push('exhibitions', $this->getExhibitions(2));
    $article->push('recentlyViewedArtworks', $this->getArtworks($this->faker->numberBetween(6,20)));
    $article->push('exploreFurther', array(
      'items' => ($exploreFurtherTab !== 4) ? $this->getArtworks(8) : null,
      'tags' => ($exploreFurtherTab === 4) ? $this->generateTags() : null,
      'nav' => array(
        array(
          'href' => '/statics/artist_tag?exploreFurtherTab=1',
          'label' => "Renaissance",
          'active' => ($exploreFurtherTab === 1) ? true : false,
          'ajaxTabTarget' => 'exploreFurther',
        ),
        array(
          'href' => '/statics/artist_tag?exploreFurtherTab=2',
          'label' => "Arms",
          'active' => ($exploreFurtherTab === 2) ? true : false,
          'ajaxTabTarget' => 'exploreFurther',
        ),
        array(
          'href' => '/statics/artist_tag?exploreFurtherTab=3',
          'label' => "Northern Italy",
          'active' => ($exploreFurtherTab === 3) ? true : false,
          'ajaxTabTarget' => 'exploreFurther',
        ),
        array(
          'href' => '/statics/artist_tag?exploreFurtherTab=4',
          'label' => "All tags",
          'active' => ($exploreFurtherTab === 4) ? true : false,
          'ajaxTabTarget' => 'exploreFurther',
        ),
      ),
    ));
    $article->push('exploreMoreLink', array(
        'href' => '#',
        'label' => 'See all 2,348 artworks',
    ));
    $article->push('relatedArticles', $this->getArticles(3));

    return $article;
  }

  private function generateGenericForm() {
    $blocks = array();
    $formBlocks = array();
    $formFields1 = array();
    $formFields2 = array();

    // build form fields
    array_push($formFields1, array(
        'variation' => null,
        'blocks' => array(
            array(
              "type" => 'input',
              'variation' => null,
              'id' => 'tinput0',
              'placeholder' => 'placeholder text',
              'textCount' => false,
              'value' => null,
              'error' => null,
              'optional' => null,
              'hint' => null,
              'disabled' => false,
              'label' => 'Basic',
            ),
        ),
    ));
    array_push($formFields1, array(
        'variation' => null,
        'blocks' => array(
            array(
              "type" => 'input',
              'variation' => null,
              'id' => 'tinput1',
              'placeholder' => 'placeholder text',
              'textCount' => false,
              'value' => null,
              'error' => null,
              'optional' => true,
              'hint' => null,
              'disabled' => false,
              'label' => 'Basic',
            ),
        ),
    ));
    array_push($formFields1, array(
        'variation' => null,
        'blocks' => array(
            array(
              "type" => 'input',
              'variation' => null,
              'id' => 'tinput2',
              'placeholder' => 'placeholder text',
              'textCount' => true,
              'value' => null,
              'error' => null,
              'optional' => null,
              'hint' => null,
              'disabled' => false,
              'label' => 'With text counter',
            ),
        ),
    ));
    array_push($formFields1, array(
        'variation' => null,
        'blocks' => array(
            array(
              "type" => 'input',
              'variation' => null,
              'id' => 'tinput3',
              'placeholder' => 'placeholder text',
              'textCount' => false,
              'value' => null,
              'error' => null,
              'optional' => null,
              'hint' => null,
              'disabled' => 'disabled',
              'label' => 'Disabled input',
            ),
        ),
    ));
    array_push($formFields1, array(
        'variation' => null,
        'blocks' => array(
            array(
              "type" => 'input',
              'variation' => null,
              'id' => 'tinput4',
              'placeholder' => 'placeholder text',
              'textCount' => false,
              'value' => null,
              'error' => "Error message",
              'optional' => null,
              'hint' => null,
              'disabled' => false,
              'label' => 'With error',
            ),
        ),
    ));
    array_push($formFields1, array(
        'variation' => null,
        'blocks' => array(
            array(
              "type" => 'input',
              'variation' => null,
              'id' => 'tinput5',
              'placeholder' => 'placeholder text',
              'textCount' => false,
              'value' => "Existing value",
              'error' => null,
              'optional' => null,
              'hint' => null,
              'disabled' => false,
              'label' => 'Pre-populated',
            ),
        ),
    ));
    array_push($formFields1, array(
        'variation' => null,
        'blocks' => array(
            array(
              "type" => 'input',
              'variation' => null,
              'id' => 'tinput6',
              'placeholder' => 'placeholder text',
              'textCount' => false,
              'value' => null,
              'error' => null,
              'optional' => null,
              'hint' => 'Hint for field',
              'disabled' => false,
              'label' => 'With hint',
            ),
        ),
    ));
    array_push($formFields1, array(
        'variation' => null,
        'blocks' => array(
            array(
              "type" => 'input',
              'variation' => 'm-fieldset__input-narrow',
              'id' => 'tinput7',
              'placeholder' => 'placeholder text',
              'textCount' => false,
              'value' => null,
              'error' => null,
              'optional' => null,
              'hint' => null,
              'disabled' => false,
              'label' => 'Narrow',
            ),
        ),
    ));
    array_push($formFields1, array(
        'variation' => null,
        'blocks' => array(
            array(
              "type" => 'input',
              'variation' => 'm-fieldset__input-narrow',
              'id' => 'tinput7',
              'placeholder' => 'placeholder text',
              'textCount' => false,
              'value' => null,
              'error' => null,
              'optional' => null,
              'hint' => null,
              'disabled' => false,
              'label' => 'Basic',
            ),
            array(
              "type" => 'input',
              'variation' => 'm-fieldset__input-narrow',
              'id' => 'tinput8',
              'placeholder' => 'placeholder text',
              'textCount' => false,
              'value' => null,
              'error' => null,
              'optional' => null,
              'hint' => null,
              'disabled' => false,
              'label' => 'Basic',
            ),
        ),
    ));
    array_push($formFields1, array(
        'variation' => null,
        'blocks' => array(
            array(
              "type" => 'textarea',
              'variation' => null,
              'id' => 'tinput9',
              'placeholder' => 'placeholder text',
              'value' => null,
              'error' => null,
              'optional' => null,
              'hint' => null,
              'disabled' => false,
              'label' => 'Basic',
            ),
        ),
    ));
    array_push($formFields1, array(
        'variation' => null,
        'blocks' => array(
            array(
              "type" => 'textarea',
              'variation' => null,
              'id' => 'tinput10',
              'placeholder' => 'placeholder text',
              'value' => null,
              'error' => null,
              'optional' => null,
              'hint' => 'Hint for textarea',
              'disabled' => false,
              'label' => 'With hint',
            ),
        ),
    ));
    array_push($formFields2, array(
        'variation' => null,
        'blocks' => array(
            array(
              "type" => 'select',
              'variation' => '',
              'id' => 'select1',
              'error' => null,
              'optional' => null,
              'hint' => null,
              'disabled' => false,
              'label' => 'Select',
              'options' => array(array('value' => '1', 'label' => 'Option 1'), array('value' => '2', 'label' => 'Option 2'), array('value' => '3', 'label' => 'Option 3')),
            ),
        ),
    ));
    array_push($formFields2, array(
        'variation' => 'm-fieldset__field--checkbox',
        'blocks' => array(
            array(
              "type" => 'checkbox',
              'variation' => '',
              'id' => 'coption1',
              'error' => null,
              'optional' => null,
              'hint' => null,
              'disabled' => false,
              'checked' => false,
              'label' => 'Option 1',
            ),
        ),
    ));
    array_push($formFields2, array(
        'variation' => 'm-fieldset__field--checkbox',
        'blocks' => array(
            array(
              "type" => 'checkbox',
              'variation' => '',
              'id' => 'coption2',
              'error' => null,
              'optional' => null,
              'hint' => null,
              'disabled' => false,
              'checked' => false,
              'label' => 'Option 2',
            ),
        ),
    ));
    array_push($formFields2, array(
        'variation' => 'm-fieldset__field--radio',
        'blocks' => array(
            array(
              "type" => 'radio',
              'variation' => '',
              'name' => 'roptions1',
              'id' => 'roption1',
              'error' => null,
              'optional' => null,
              'hint' => null,
              'disabled' => false,
              'checked' => false,
              'label' => 'Option 1',
            ),
        ),
    ));
    array_push($formFields2, array(
        'variation' => 'm-fieldset__field--radio',
        'blocks' => array(
            array(
              "type" => 'radio',
              'variation' => '',
              'name' => 'roptions1',
              'id' => 'roption2',
              'error' => null,
              'optional' => null,
              'hint' => null,
              'disabled' => false,
              'checked' => false,
              'label' => 'Option 2',
            ),
        ),
    ));
    array_push($formFields2, array(
        'variation' => null,
        'blocks' => array(
            array(
              "type" => 'select',
              'variation' => 'm-fieldset__input-narrow',
              'id' => 'select2',
              'error' => null,
              'optional' => null,
              'hint' => null,
              'disabled' => false,
              'label' => 'Select',
              'options' => array(array('value' => '1', 'label' => 'Option 1'), array('value' => '2', 'label' => 'Option 2'), array('value' => '3', 'label' => 'Option 3')),
            ),
            array(
              "type" => 'input',
              'variation' => 'm-fieldset__input-narrow',
              'id' => 'tinput11',
              'placeholder' => 'placeholder text',
              'textCount' => false,
              'value' => null,
              'error' => null,
              'optional' => null,
              'hint' => null,
              'disabled' => false,
              'label' => 'Basic',
            ),
        ),
    ));
    array_push($formFields2, array(
        'variation' => 'm-fieldset__field--group',
        'blocks' => array(
            array(
              "type" => 'label',
              'variation' => 'm-fieldset__group-label',
              'error' => null,
              'optional' => null,
              'hint' => null,
              'label' => 'Group of checkboxes',
            ),
            array(
              "type" => 'checkbox',
              'variation' => '',
              'id' => 'coption3',
              'error' => null,
              'optional' => null,
              'hint' => null,
              'disabled' => false,
              'checked' => 'checked',
              'label' => 'Option 3, checked by default',
            ),
            array(
              "type" => 'checkbox',
              'variation' => '',
              'id' => 'coption4',
              'error' => null,
              'optional' => null,
              'hint' => null,
              'disabled' => false,
              'checked' => false,
              'label' => 'Option 4',
            ),
        ),
    ));
    array_push($formFields2, array(
        'variation' => 'm-fieldset__field--group',
        'blocks' => array(
            array(
              "type" => 'label',
              'variation' => 'm-fieldset__group-label',
              'error' => null,
              'optional' => null,
              'hint' => null,
              'label' => 'Group of radios',
            ),
            array(
              "type" => 'radio',
              'variation' => '',
              'name' => 'roptions2',
              'id' => 'roption3',
              'error' => null,
              'optional' => null,
              'hint' => null,
              'disabled' => false,
              'checked' => 'checked',
              'label' => 'Option 3, checked by default',
            ),
            array(
              "type" => 'radio',
              'variation' => '',
              'name' => 'roptions2',
              'id' => 'roption4',
              'error' => null,
              'optional' => null,
              'hint' => null,
              'disabled' => false,
              'checked' => false,
              'label' => 'Option 4',
            ),
        ),
    ));
    array_push($formFields2, array(
        'variation' => null,
        'blocks' => array(
            array(
              "type" => 'date-select',
              'variation' => 'm-fieldset__input-narrow',
              'id' => 'tinput99',
              'placeholder' => 'dd/mm/yy',
              'value' => null,
              'error' => null,
              'optional' => null,
              'hint' => null,
              'disabled' => false,
              'label' => 'Date selector',
            ),
        ),
    ));



    // build form blocks
    array_push($formBlocks, array(
      "type" => 'fieldset',
      'variation' => null,
      'fields' => $formFields1,
      'legend' => 'Contact Information',
    ));
    array_push($formBlocks, array(
      "type" => 'fieldset',
      'variation' => null,
      'fields' => $formFields2,
      'legend' => 'Visit Information',
    ));

    // build page blocks
    array_push($blocks, array(
        "type" => 'media',
        "content" => array(
            'type' => 'image',
            'size' => 's',
            'media' => $this->getImage(),
            'hideCaption' => true,
        )
    ));
    array_push($blocks, array(
      "type" => 'text',
      "content" => $this->generateParagraph(5)
    ));
    array_push($blocks, array(
      "type" => 'text',
      "content" => $this->generateParagraph(5)
    ));
    array_push($blocks, array(
        "type" => 'form',
        'variation' => null,
        'action' => '/statics/',
        'method' => 'GET',
        "blocks" => $formBlocks,
        "actions" => array(
            array(
                'variation' => null,
                'type' => 'submit',
                'label' => "Send",
            ),
            array(
                'variation' => 'btn--secondary',
                'type' => 'reset',
                'label' => "Cancel",
            ),
        )
    ));

    return $blocks;
  }

  private function searchResultsNavLinks($active = 'all') {
    return array(
      array('label' => 'All (1,312)', 'href' => '#', 'active' => ($active === 'all')),
      array('label' => 'Artists (124)', 'href' => '#', 'active' => ($active === 'artists')),
      array('label' => 'Pages (6)', 'href' => '#', 'active' => ($active === 'pages')),
      array('label' => 'Artworks (1,242)', 'href' => '#', 'active' => ($active === 'artworks')),
      array('label' => 'Exhibitions &amp; Events (6)', 'href' => '#', 'active' => ($active === 'exhibitionsAndEvents')),
      array('label' => 'Writings (3)', 'href' => '#', 'active' => ($active === 'articlesAndPublications')),
      array('label' => 'Resources (11)', 'href' => '#', 'active' => ($active === 'researchAndResources')),
    );
  }

  public function getHomepageItems(){
    return [
      'contrastHeader' => true,
      'filledLogo' => true,
      'intro' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus eget laoreet tortor. Quisque tristique laoreet lectus sit amet tempus. Aliquam vel eleifend nisi.',
      'heroItems' => $this->getExhibitions(3),
      'exhibitions' => $this->getExhibitions(2),
      'events' => $this->getEvents(4),
      'products' => $this->getProducts(5),
      'theCollection' => $this->generateCollection(),
       'membership_module_image' => $this->getImage(),
       'membership_module_url' => ''
    ];
  }

  public function autocomplete($slug) {
    return view('partials/_autocomplete', [
        'term' => $slug,
        'resultCount' => $this->faker->numerify('#,###'),
        'items' => (object) [
            [
                'url' => '#',
                'image' => $this->getImage(),
                'text' => $this->faker->sentence(6, true),
            ],
            [
                'url' => '#',
                'image' => $this->getImage(),
                'text' => $this->faker->sentence(6, true),
            ],
            [
                'url' => '#',
                'image' => $this->getImage(),
                'text' => $this->faker->sentence(6, true),
            ],
            [
                'url' => '#',
                'image' => $this->getImage(),
                'text' => $this->faker->sentence(6, true),
            ],
            [
                'url' => '#',
                'image' => $this->getImage(),
                'text' => $this->faker->sentence(6, true),
            ],
            [
                'url' => '#',
                'image' => $this->getImage(),
                'text' => $this->faker->sentence(6, true),
            ],
            [
                'url' => '#',
                'image' => $this->getImage(),
                'text' => $this->faker->sentence(6, true),
            ],
            [
                'url' => '#',
                'image' => $this->getImage(),
                'text' => $this->faker->sentence(6, true),
            ],
        ]
    ]);
  }

  public function exhibitions_load_more() {
    $page = request('page');

    $maxPages = 4;
    $page = ($page == $maxPages ? '' : $page + 1);

    $events = $this->makeEventsByDates(4);

    return [
        'page' => $page,
        'html' => view('statics.exhibitions_load_more', [
            'items' => $events
        ])->render(),
    ];
  }

  public function getVisitItems(){
    return [
        'primaryNavCurrent' => 'visit',
        'contrastHeader' => true,
        'filledLogo' => true,
        'headerMedia' => array(
          'type' => 'image',
          'size' => 'hero',
          'media' => $this->getImage(),
          'hideCaption' => true,
         ),
        'title' => 'Plan Your Visit',
        'hours' => array(
          'media' => array(
              'type' => 'image',
              'size' => 's',
              'media' => $this->getImage(),
              'hideCaption' => true,
          ),
          'primary' => $this->faker->sentence(8),
          'secondary' => $this->faker->sentence(8),
          'sections' => array(
              array(
                  'title' => 'The Ryan Learning Center',
                  'link' => '#',
                  'text' => '<p>10:30-5:00 and Thursday until 8:00 <br>Free Admission</p>',
              ),
              array(
                  'title' => 'The Ryerson and Burnham Libraries',
                  'link' => '#',
                  'text' => '<p>Monday-Wednesday 1:00-5:00 <br>Thursday 10:30-8:00 <br>Friday 1:00-5:00 <br>Saturday-Sunday Closed</p>',
              ),
              array(
                  'title' => 'Museum Shops',
                  'link' => '#',
                  'text' => '<p>10:30-5:00 and Thursday until 8:00</p>',
              ),
           )
         ),
        'admission' => array(
          'text' => '<p class="f-secondary">Curabitur velit libero, pretium sed ullamcorper eget, rutrum a nisl. Maecenas lacinia sit amet magna dignissim dapibus.</p>',
          'cityPass' => array(
              'title' => 'CityPass',
              'text' => $this->faker->paragraph(3),
              'image' => $this->getImage(),
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
         ),
        'directions' => array(
          'intro' => $this->faker->paragraph(),
          'image' => array(
              'type' => 'image',
              'size' => 's',
              'media' => $this->getImage(),
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
         ),
        'dining' => array(
          'options' => $this->generateDiningOptions(),
        ),
        'faq' => array(
          'questions' => array(
              array(
                'href' => '/statics/faq#'.getUtf8Slug('Static question title 2'),
                'label' => "Static question title 2",
              ),
              array(
                'href' => '/statics/faq#'.getUtf8Slug('Static question title 3'),
                'label' =>"Static question title 3",
              ),
              array(
                'href' => '/statics/faq#'.getUtf8Slug('Static question title 4'),
                'label' => "Static question title 4",
              ),
              array(
                'href' => '/statics/faq#'.getUtf8Slug('Static question title 5'),
                'label' => "Static question title 5",
              ),
          ),
        ),
        'tours' => array(
              array(
                  'title' => $this->faker->sentence(2),
                  'titleLink' => '#',
                  'image' => $this->getImage(),
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
                  'image' => $this->getImage(),
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
                  'image' => $this->getImage(),
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
                  'image' => $this->getImage(),
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
                  'image' => $this->getImage(),
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
                  'image' => $this->getImage(),
                  'text' => $this->faker->paragraph(3),
                  'links' => array(
                      array(
                        'href' => '#',
                        'label' => $this->faker->sentence(2),
                      ),
                  )
              ),
         ),
    ];
  }

  function getEventPageContents($headerType = null) {
    // make some left rail links
    $locationLink = array('label' => 'Rubloff Auditorium', 'href' => '#', 'iconBefore' => 'location');
    $registrationLink = array('label' => 'Registration required', 'href' => "#", 'iconBefore' => 'pencil');
    // make left rail nav array
    $nav = array();
    array_push($nav, $locationLink);
    array_push($nav, $registrationLink);
    // make blocks
    $blocks = array();
    array_push($blocks, array(
        "type" => 'text',
         "content" => $this->generateParagraph(1)
    ));
    array_push($blocks, array(
        "type" => 'text',
         "content" => '<h2>Captions hidden, inline playing (no posters):</h2>'
    ));
    array_push($blocks, array(
        "type" => 'media',
        "content" => array(
            'type' => 'embed',
            'size' => 's',
            'media' => $this->getEmbed('soundcloud'),
            'hideCaption' => true
        )
    ));
    array_push($blocks, array(
        "type" => 'text',
         "content" => $this->generateParagraph(1)
    ));
    array_push($blocks, array(
        "type" => 'media',
        "content" => array(
            'type' => 'embed',
            'size' => 'm',
            'media' => $this->getEmbed('youtube'),
            'hideCaption' => true
        )
    ));

    array_push($blocks, array(
        "type" => 'text',
         "content" => '<h2>Captions, inline playing (no posters):</h2>'
    ));
    array_push($blocks, array(
        "type" => 'media',
        "content" => array(
            'type' => 'embed',
            'size' => 's',
            'media' => $this->getEmbed('soundcloud'),
            'caption' => 'Soundcloud with caption'
        )
    ));
    array_push($blocks, array(
        "type" => 'text',
         "content" => $this->generateParagraph(1)
    ));
    array_push($blocks, array(
        "type" => 'media',
        "content" => array(
            'type' => 'embed',
            'size' => 'm',
            'media' => $this->getEmbed('youtube'),
            'caption' => 'Youtube with caption'
        )
    ));
    array_push($blocks, array(
        "type" => 'text',
         "content" => '<h2>Captions hidden, inline playing, with posters:</h2>'
    ));
    array_push($blocks, array(
        "type" => 'media',
        "content" => array(
            'type' => 'embed',
            'size' => 's',
            'media' => $this->getEmbed('soundcloud'),
            "poster" => $this->getImage(),
            'hideCaption' => true
        )
    ));
    array_push($blocks, array(
        "type" => 'text',
         "content" => $this->generateParagraph(1)
    ));
    array_push($blocks, array(
        "type" => 'media',
        "content" => array(
            'type' => 'embed',
            'size' => 'm',
            'media' => $this->getEmbed('youtube'),
            "poster" => $this->getImage(),
            'hideCaption' => true
        )
    ));
    array_push($blocks, array(
        "type" => 'text',
         "content" => '<h2>Captions hidden, modal player, with posters:</h2>'
    ));
    array_push($blocks, array(
        "type" => 'media',
        "content" => array(
            'type' => 'embed',
            'size' => 's',
            'media' => $this->getEmbed('soundcloud'),
            "poster" => $this->getImage(),
            'hideCaption' => true,
            'fullscreen' => true,
        )
    ));
    array_push($blocks, array(
        "type" => 'text',
         "content" => $this->generateParagraph(1)
    ));
    array_push($blocks, array(
        "type" => 'media',
        "content" => array(
            'type' => 'embed',
            'size' => 's',
            'media' => $this->getEmbed('youtube'),
            "poster" => $this->getImage(),
            'hideCaption' => true,
            'fullscreen' => true,
        )
    ));
    array_push($blocks, array(
        "type" => 'text',
         "content" => '<h2>As a listing block, they have images, play fullscreen:</h2>'
    ));
    array_push($blocks, array(
        "type" => 'listing',
        "subtype" => 'media',
        "items" => $this->getMedias(2),
    ));
    array_push($blocks, array(
        "type" => 'text',
         "content" => $this->generateParagraph(1)
    ));
    array_push($blocks, array(
        "type" => 'gallery',
        "subtype" => 'slider',
        "title" => 'Slider Gallery',
        "caption" => $this->faker->paragraph(3, false),
        "items" => $this->getGalleryImages(6),
        "allLink" => array(
          'href' => '#',
          'label' => "See all exhibition objects",
        ),
    ));
    array_push($blocks, array(
        "type" => 'time-line',
        "items" => $this->getTimelineEvents(3)
    ));
    array_push($blocks, array(
        "type" => 'newsletter-sign-up',
    ));

    // get an event
    $article = $this->getEvent();
    $article->push('articleType', 'event');
    $article->push('headerType', $headerType ?? null);
    $article->push('headerImage', $this->getImage(true));
    $article->push('blocks', $blocks);
    $article->push('intro', $this->faker->paragraph(6, false));
    $article->push('speakers', array(
        array(
          'img' => $this->getImage(),
          'title' => $this->faker->firstName.' '.$this->faker->lastName,
          'text' => $this->faker->paragraph(5),
        ),
      )
    );
    $article->push('sponsors', $this->generateBlocks(2));
    $article->push('futherSupport', array(
      'logo' => $this->getImage(),
      'title' => "Further support has been provided by",
      'text' => $this->faker->paragraph(5),
    ));
    $article->push('ticketLink', '#');
    $article->push('ticketPrices', '<p>$10 students</p><p>$20 members</p><p>$30 non-members</p>');
    $article->push('nav', $nav);

    return $article;
  }
}
