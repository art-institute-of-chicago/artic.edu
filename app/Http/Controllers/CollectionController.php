<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Libraries\Api\Builders\Connection\AicConnection;

use App\Repositories\Api\ArtworkRepository;
use App\Models\Api\Artwork;

class CollectionController extends Controller
{
    protected $apiRepository;

    public function __construct(ArtworkRepository $repository)
    {
        $this->apiRepository = $repository;
    }

    public function index(Request $request)
    {
        $aicConnection = new AicConnection;
        $q = $request->get('q');
        $items = [];
        if ($q) {
            $results = $aicConnection->get('/api/v1/search', ['q' => $q, 'type' => 'artworks']);
            if ($results->status == 200) {
                foreach($results->body->data as $result_item) {
                    $item_results = $aicConnection->get('/api/v1/'.$result_item->api_model.'/'.$result_item->api_id, ['q' => $q, 'type' => 'artworks']);
                    $item = $this->apiRepository->getById($result_item->id);
                    $item->type = 'artwork';
                    $item->image = ['src' => "//placeimg.com/400/400/nature", 'srcset' => "//placeimg.com/400/400/nature/400w", 'width' => '400', 'height' => '400'];
                    $items[] = $item;
                    // dd($item);
                }
            }
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
          'artworks' => $items,
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
        $results = $aicConnection->get('/api/v1/search', ['q' => $slug, 'type' => 'artworks']);
        // dd($results);
        if ($results->status == 200) {
            $items = [];

            foreach($results->body->data as $result_item) {
                $data = $this->apiRepository->getById($result_item->id);

                $item = [
                    'url' => route('artworks.show', $data->id),
                    'image' => ['src' => "//placeimg.com/40/40/nature", 'width' => 40, 'height' => '40'],
                    'text' => $data->title,
                ];
                $items[] = $item;
            }

            return view('layouts/_autocomplete', [
                'term' => $slug,
                'resultCount' => $results->body->pagination->total,
                'items' => $items,
                'seeAllUrl' => route('collection', ['q' => $slug])
            ]);
        } else {
            abort($results->status);
        }
    }

}
