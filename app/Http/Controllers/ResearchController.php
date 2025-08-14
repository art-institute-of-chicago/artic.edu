<?php

namespace App\Http\Controllers;

use App\Models\Page;

class ResearchController extends FrontController
{
    public function index()
    {
        $page = Page::forType('Research and Resources')->first();
        $artIdeasPage = Page::forType('Art and Ideas')->first();

        $this->seo->setTitle('Research & Resources');
        $this->seo->setDescription($page->resources_landing_intro);
        $this->seo->setImage($page->imageFront('research_landing_image'));

        $featuredPages = $page->researchResourcesFeaturePages;

        // WEB-2255: Building links should be moved away from the controller to a presenter.
        $features = [];

        foreach ($featuredPages as $item) {
            $links = [];

            foreach ($item->children()->orderBy('position')->published()->get() as $index => $child) {
                if ($index == 4) {
                    break; // Show only the top 4 children.
                }

                array_push($links, [
                    'href' => $child->url,
                    'label' => $child->title,
                    'external' => $child->is_redirect_url_external
                ]);
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

        foreach ($page->researchResourcesStudyRooms as $room) {
            array_push($studyRooms, [
                'title' => $room->title,
                'titleLink' => $room->url,
                'text' => $room->listing_description,
            ]);
        }

        $studyRoomsLink = '';

        foreach ($page->researchResourcesStudyRoomMore as $room) {
            $studyRoomsLink = $room->url;
        }

        return view('site.research_resources.index', [
            'primaryNavCurrent' => 'collection',
            'title' => 'The Collection',
            'intro' => $artIdeasPage->art_intro,
            'page' => $page,
            'linksBar' => [
                [
                    'href' => route('collection'),
                    'label' => 'Artworks',
                ],
                [
                    'href' => '/publications',
                    'label' => 'Publications',
                ],
                [
                    'href' => route('collection.research_resources'),
                    'label' => 'Research',
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
