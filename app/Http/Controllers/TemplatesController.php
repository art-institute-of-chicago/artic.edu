<?php

namespace App\Http\Controllers;

// use A17\CmsToolkit\Http\Controllers\Front\Controller;

class TemplatesController extends Controller {
  public function index($slug ="") {
    if (!empty($slug) && method_exists($this,$slug)) {
      return $this->{$slug}();
    }

    // find view, assign the variable
    return view(($slug != "") ? "statics/{$slug}" : "statics/index");
  }

  public function typespec() {
    return view("templates.typespec");
  }

  public function toybox() {
    return view("templates.toybox");
  }

  public function icons() {
    return view("templates.icons");
  }

  public function home() {
    return view("templates.home");
  }
}
