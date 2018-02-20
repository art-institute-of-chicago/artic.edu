<?php

namespace App\Http\Controllers;

use App\Repositories\Api\ArtworkRepository;
use A17\CmsToolkit\Http\Controllers\Front\Controller;
use App\Models\Page;

use LakeviewImageService;

class ArtworkController extends Controller
{
    protected $apiRepository;

    public function __construct(ArtworkRepository $repository)
    {
        $this->apiRepository = $repository;

        parent::__construct();
    }

    public function show($id)
    {
        // The ID is a datahub_id not a local ID
        // get an artwork
        $item = $this->apiRepository->getById($id);
        //dd($item);

        $item->articleType = 'artwork';
        $item->headerType = 'gallery';

        $galleryImages = collect();
        if ($item->image_id) {
            // $dimensions = LakeviewImageService::getDimensions($item->image_id);
            $galleryImages[] = LakeviewImageService::getImage($item->image_id);
        }
        // dd($galleryImages);
        $item->galleryImages = $galleryImages;

        // generate some blocks
        // $blocks = $this->generateArtworkBlocks();
        // dd($item);
        $blocks = [];

        $details = [];
        $details[] = array('key' => 'Artist', 'value' => 'The Artist Name');
        if (!empty($item->date_display)) $details[] = array('key' => 'Date', 'value' => $item->date_display);
        if (!empty($item->medium)) $details[] = array('key' => 'Medium', 'value' => $item->medium);
        if (!empty($item->dimensions)) $details[] = array('key' => 'Dimensions', 'value' => $item->dimensions);
        if (!empty($item->credit_line)) $details[] = array('key' => 'Credit line', 'value' => $item->credit_line);
        if (!empty($item->main_reference_number)) $details[] = array('key' => 'Reference Number', 'value' => $item->main_reference_number);
        if (!empty($item->copyright_notice)) $details[] = array('key' => 'Copyright', 'value' => $item->copyright_notice);

        array_push($blocks, array(
          "type" => 'deflist',
          "items" =>$details
        ));
        $item->blocks = $blocks;

        // update and add some items (I ran into memory issues doing this in the main getartwork func..)
        // $article->push('nextArticle', $this->getArtwork());
        // $article->push('prevArticle', $this->getArtwork());
        // $article->push('onView', array('label' => 'European Painting and Sculpture, Galleries 239', 'href' => '#'));
        // $article->push('exploreFuther', array(
        //   'items' => $this->getArtworks(8),
        //   'nav' => array(
        //     array(
        //       'href' => '#',
        //       'label' => "Renaissance",
        //     ),
        //     array(
        //       'href' => '#',
        //       'label' => "Arms",
        //       'active' => true,
        //     ),
        //     array(
        //       'href' => '#',
        //       'label' => "Northern Italy",
        //     ),
        //     array(
        //       'href' => '#',
        //       'label' => "All tags",
        //     ),
        //   ),
        // ));
        // $article->push('galleryImages', $this->getImages($this->faker->numberBetween(1,5)));
        // $article->push('recentlyViewedArtworks', $this->getArtworks($this->faker->numberBetween(6,20)));
        // $article->push('interestedThemes', array(
        //   array(
        //     'href' => '#',
        //     'label' => "Picasso",
        //   ),
        //   array(
        //     'href' => '#',
        //     'label' => "Modern Art",
        //   ),
        //   array(
        //     'href' => '#',
        //     'label' => "European Art",
        //   ),
        // ));
        // $article->push('featuredRelated', array(
        //   'type' => 'article',
        //   'items' => $this->getArticles(1),
        // ));
        // now push to a view
        return view('site.articleDetail', [
          'contrastHeader' => ($item->headerType === 'hero'),
          'item' => $item,
        ]);
    }

}
