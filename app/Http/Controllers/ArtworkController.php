<?php

namespace App\Http\Controllers;

use App\Repositories\Api\ArtworkRepository;
use App\Repositories\Api\SearchRepository;

use App\Models\Page;

use LakeviewImageService;

class ArtworkController extends FrontController
{
    protected $apiRepository;
    protected $searchRepository;

    public function __construct(ArtworkRepository $repository, SearchRepository $search)
    {
        $this->apiRepository = $repository;
        $this->searchRepository = $search;

        parent::__construct();
    }

    public function show($idSlug)
    {
        // The ID is a datahub_id not a local ID
        // get an artwork
        $item = $this->apiRepository->getById((Integer) $idSlug);
        if (empty($item)) {
            abort(404);
        }

        $artworkMultimedia = $this->searchRepository->multimedia((Integer) $idSlug);
        $artworkClassrommResources = $this->searchRepository->classroomResources((Integer) $idSlug);

        $item->subtitle = $item->place_of_origin . ', ' . $item->date_display;
        $item->articleType = 'artwork';
        $item->headerType = 'gallery';

        $galleryImages = collect();
        if ($item->image_id) {
            $image = $item->imageFront('hero');
            $image['credit'] = $item->getImageCopyright();
            $galleryImages[] = $image;
            $item->image = $image;
        }
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

            array_push($blocks, array(
              "type" => 'deflist',
              "variation" => 'deflist--free-spacing u-hide@large+',
              "items" => array(
                array('key' => 'On View', 'value' => $label),
              )
            ));
        }

        array_push($blocks, $item->getArtworkDetailsBlock());
        array_push($blocks, $item->getArtworkDescriptionBlocks($artworkMultimedia, $artworkClassrommResources));
        $item->blocks = $blocks;

        aic_addToRecentlyViewedArtworks($item);
        $recentlyViewed = aic_getRecentlyViewedArtworks();

        if (sizeof($recentlyViewed) > 2) {
            $item->recentlyViewedArtworks = $recentlyViewed;
        }

        return view('site.articleDetail', [
          'contrastHeader' => $item->present()->contrastHeader,
          'item' => $item
        ]);
    }

}
