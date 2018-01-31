<?php

namespace App\Http\Controllers;

use App\Models\Api\Artwork;
use App\Models\Api\Artist;
use App\Models\Api\Exhibition;

use App\Repositories\Api\ArtworkRepository;
use App\Repositories\Api\ArtistRepository;

class SearchController extends Controller
{
    public function index(ArtworkRepository $artworks, ArtistRepository $artists)
    {
        $artworksResults = $artworks->forSearchQuery(request('query'));
        $artistsResults  = $artists->forSearchQuery(request('query'));
    }

}
