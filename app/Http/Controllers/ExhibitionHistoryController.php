<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\Api\ExhibitionRepository;

use App\Models\Api\Exhibition;
use App\Models\Page;

class ExhibitionHistoryController extends FrontController
{

    protected $apiRepository;

    public function __construct(ExhibitionRepository $repository)
    {
        $this->apiRepository = $repository;

        parent::__construct();
    }

    public function index(Request $request)
    {
        $page = Page::forType('Exhibition History')->firstOrFail();

        $blocks = [];
        $blocks[] = [
            "type" => 'text',
            "content" => '<p>'.$page->exhibition_history_intro_copy.'</p>'
        ];

        $year = intval($request->get('year', date('Y')-1));

        $decades = collect([]);
        $decade_start = 0;
        $decade_promot = '';
        for($i=1900; $i<date('Y'); $i=$i+10) {

            $end = ($i+9);
            if ($end > date('Y')) {
                $end = date('Y');
            }

            $d = array('href' => '?year='.$i, 'label' => ''.$i.'-'.($end));

            if ($year >= $i && $year < $i+10) {
                $d['active'] = true;
                $decade_start = $i;
                $decade_prompt = $d['label'];
            }

            $decades[] = $d;
        }
        $decades = $decades->reverse();

        $years = collect([]);
        for($i=$decade_start; $i<($decade_start+10); $i++) {
            if ($i <= date('Y')) {
                $y = [
                    'href' => '?year='.$i
                ,   'label' => $i
                ];
                if ($i == $year) {
                    $y['active'] = true;
                }

                $years[] = $y;
            }
        }
        $years = $years->reverse();
        $exhibitions = $this->apiRepository->history($year);

        $view_data = [
            'title' => 'Exhibition History',
            'intro' => $page->exhibition_history_sub_heading,
            'media' => array(
              'type' => 'image',
              'size' => 's',
              'media' => $page->imageFront('exhibition_history_intro'),
              'hideCaption' => true,
             ),
            'blocks' => $blocks,
            'years' => $years,
            'decades' => $decades,
            'decade_prompt' => $decade_prompt,
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
        dd($resource);
    }
}
