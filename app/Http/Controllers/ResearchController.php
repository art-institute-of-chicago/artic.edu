<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Page;

class ResearchController extends Controller
{

    public function index()
    {

        $page = Page::forType('Research and Resources')->first();

        $featuredPages = $page->researchResourcesFeaturePages;
        $features = [];
        foreach($featuredPages as $item) {
            $links = [];
            foreach($item->children as $child) {
                array_push($links, array(
                    'href' => $child->url,
                    'label' => $child->title,
                    'external' => $child->is_redirect_url_external
                  ));
            }

            array_push($features, [
                'image' => $item->imageFront('listing'),
                'title' => $item->title,
                'titleLink' => $item->url,
                'text' => $item->short_description,
                'links' => $links
            ]);
        }

        $studyRooms = [];
        foreach($page->researchResourcesStudyRooms as $room) {
            array_push($studyRooms, [
                'title' => $room->title,
                'titleLink' => $room->url,
                'text' => $room->short_description,
            ]);
        }

        $studyRoomsLink = '';
        foreach($page->researchResourcesStudyRoomMore as $room) {
            $studyRoomsLink = $room->url;
        }

        return view('site.research_resources.index', [
            'primaryNavCurrent' => 'collection',
            'title' => 'The Collection',
            'intro' => 'Explore <em>over 100,000 artworks</em> and information about works of art from all areas in our online encyclopedic collections.',
            'page'  => $page,
            'linksBar' => [
                [
                    'href' => route('collection'),
                    'label' => 'Artworks',
                ],
                [
                    'href' => route('articles_publications'),
                    'label' => 'Writings',
                ],
                [
                    'href' => route('collection.research_resources'),
                    'label' => 'Resources',
                    'active' => true,
                ],
            ],
            'hero' => $hero ?? null,
            'items' => $features,
            'studyRooms' => $studyRooms,
            'studyRoomsLink' => $studyRoomsLink
        ]);

    }

}
