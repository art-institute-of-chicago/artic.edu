<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Page;

class ResearchController extends Controller
{

    public function index()
    {
        $page = Page::forType('Research and Resources')->first();
        $artIdeasPage = Page::forType('Art and Ideas')->first();

        $featuredPages = $page->researchResourcesFeaturePages;

        // TODO: Building links should be moved away from the controller to a presenter.
        $features = [];
        foreach($featuredPages as $item) {
            $links = [];
            foreach($item->children()->orderBy('position')->published()->get() as $index => $child) {
                if ($index == 4) {
                    break; // Show only the top 4 children.
                }

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
                'text' => $item->listing_description,
                'links' => $links
            ]);
        }

        $studyRooms = [];
        foreach($page->researchResourcesStudyRooms as $room) {
            array_push($studyRooms, [
                'title' => $room->title,
                'titleLink' => $room->url,
                'text' => $room->listing_description,
            ]);
        }

        $studyRoomsLink = '';
        foreach($page->researchResourcesStudyRoomMore as $room) {
            $studyRoomsLink = $room->url;
        }

        return view('site.research_resources.index', [
            'primaryNavCurrent' => 'collection',
            'title' => 'The Collection',
            'intro' => $artIdeasPage->art_intro,
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
