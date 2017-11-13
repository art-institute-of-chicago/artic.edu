<?php

namespace App\Http\Controllers;

// use A17\CmsToolkit\Http\Controllers\Front\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index', []);
    }
}
