<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\Api\ExhibitionRepository;

use App\Models\Api\Exhibition;
use App\Models\Page;

class ExhibitionHistoryController extends Controller
{

    protected $apiRepository;

    public function __construct(ExhibitionRepository $repository)
    {
        $this->apiRepository = $repository;
    }

    public function index(Request $request)
    {
        $page = Page::forType('Exhibition History')->firstOrFail();

        $blocks = [];
        $blocks[] = [
            "type" => 'text',
            "content" => '<p>'.$page->exhibition_history_intro_copy.'</p>'
        ];

        $year = intval($request->get('year', date('Y')));
        $years = [];
        for($i=2010; $i<2020; $i++) {
            $y = [
                'href' => '?year='.$i
            ,   'label' => $i
            ];
            if ($i == $year) {
                $y['active'] = true;
            } else {
                $y['active'] = false;
            }

            $years[] = $y;
        }
        // dd($years);
        $exhibitions = $this->apiRepository->history($year);

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
            'years' => $years,
            'year' => $year,
            'exhibitions' => $exhibitions,
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
