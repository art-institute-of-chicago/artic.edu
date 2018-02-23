<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Libraries\Api\Builders\Connection\AicConnection;

use App\Repositories\Api\ArtworkRepository;
use App\Models\Api\Artwork;

use LakeviewImageService;

class CollectionController extends Controller
{
    protected $apiRepository;

    public function __construct(ArtworkRepository $repository)
    {
        $this->apiRepository = $repository;
    }

    public function index()
    {
        $collection = \App\Models\Api\Search::search(request('q'))->resources(['artworks'])->getSearch();
        foreach($collection as &$item) {
            $item->type = 'artwork';
            $item->image = LakeviewImageService::getImage($item->image_id);
        }

        return view('site.collection.index', [
          'primaryNavCurrent' => 'collection',
          'title' => 'The Collection',
          'intro' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus eget laoreet <em>tortor quisque tristique laoreet</em> lectus sit amet tempus. Aliquam vel eleifend nisi.',
          'quickSearchLinks' => [],
          'filters' => [],
          'filterCategories' => [],
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
          'artworks' => $collection,
          'recentlyViewedArtworks' => [],
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
          'featuredArticlesHero' => [],
          'featuredArticles' => [],
        ]);

    }

    public function search($slug, Request $request)
    {
        $aicConnection = new AicConnection;
        $results = \App\Models\Api\Search::search($slug)->resources(['artworks'])->getSearch();

        $items = [];
        foreach($results as $result_item) {
            $item = $this->apiRepository->getById($result_item->id);
            // dd($item);
            $item->type = 'artwork';
            $item->text = $item->title;
            $item->url = route('artworks.show', $item->id);

            $image = LakeviewImageService::getImage($item->image_id, 30);
            $image['width'] = 30;
            $image['height'] = '';
            $item->image = $image;
            // dd($item->image);
            $items[] = $item;
        }

        return view('layouts/_autocomplete', [
            'term' => $slug,
            'resultCount' => $results->total(),
            'items' => $items,
            'seeAllUrl' => route('collection', ['q' => $slug])
        ]);

        abort(500);
    }

}
