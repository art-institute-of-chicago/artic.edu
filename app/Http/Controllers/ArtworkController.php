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
        // dd($item);
        // dd($item->categories);

        $item->articleType = 'artwork';
        $item->headerType = 'gallery';

        $galleryImages = collect();
        if ($item->image_id) {
            // $dimensions = LakeviewImageService::getDimensions($item->image_id);
            $image = LakeviewImageService::getImage($item->image_id);
            // dd($image);
            // add copyright to each image
            // "shareUrl" => '#',
            // "shareTitle" => $shareTitle,
            // "downloadUrl" => $src,
            // "downloadName" => $downloadName,
            // "credit" => $credit,
            // "creditUrl" => $creditUrl,
            //
            $galleryImages[] = $image;
        }
        // dd($galleryImages);
        $item->galleryImages = $galleryImages;

        $blocks = [];
        array_push($blocks, array(
          "type" => 'text',
          "content" => $item->description
        ));

        if ($item->is_on_view) {
            $label = '';
            if (!empty($item->collection_status)) {
                $label .= $item->collection_status . ', ';
            }
            if (!empty($item->gallery_title)) {
                $label .= $item->gallery_title;
            }
            $item->onView = array('label' => $label, 'href' => route('galleries.show', [$item->gallery_id]));
        }

        array_push($blocks, $item->getArtworkDetailsBlock());
        array_push($blocks, $item->getArtworkDescriptionBlocks());
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
