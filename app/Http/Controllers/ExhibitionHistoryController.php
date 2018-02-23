<?php

namespace App\Http\Controllers;

use App\Models\Api\Exhibition;
use App\Models\Page;

class ExhibitionHistoryController extends Controller
{
    public function index()
    {
        $page = Page::forType('Exhibition History')->firstOrFail();

        $blocks = [];
        $blocks[] = [
            "type" => 'text',
            "content" => '<p>'.$page->exhibition_history_intro_copy.'</p>'
        ];

        $view_data = [
            'title' => 'Exhibition History',
            'intro' => $page->exhibition_history_sub_heading,
            'media' => array(
              'type' => 'image',
              'size' => 's',
              'media' => aic_convertFromImage($page->imageObject('exhibition_history_intro')),
              'hideCaption' => true,
             ),
            'blocks' => $blocks,
            'exhibitions' => [],
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
        ];

        return view('site.exhibitionHistory', $view_data);
    }

    public function show($id)
    {
        $resource = Exhibition::with('artworks')->find($id);
    }
}
