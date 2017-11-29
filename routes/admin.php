<?php

Route::name('home')->get('/', 'PageController@home');

Route::module('pages');

Route::group(['prefix' => 'landing'], function () {
    Route::name('landing.exhibitions')->get('exhibitions', 'PageController@exhibitions');
    Route::name('landing.art')->get('art', 'PageController@art');
});

Route::group(['prefix' => 'whatson'], function () {
    Route::module('events');
    Route::module('exhibitions');
});

Route::group(['prefix' => 'general'], function () {
  Route::module('hours');
  Route::module('categories');
  Route::module('siteTags');
  Route::module('segments');
});
