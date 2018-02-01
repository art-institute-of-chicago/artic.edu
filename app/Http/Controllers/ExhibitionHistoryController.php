<?php

namespace App\Http\Controllers;

use App\Models\Api\Exhibition;
use App\Models\Page;

class ExhibitionHistoryController extends Controller
{
    public function index()
    {
        $page = Page::forType('Exhibition History')->first();
    }

    public function show($id)
    {
        $resource = Exhibition::with('artworks')->find($id);
    }
}
