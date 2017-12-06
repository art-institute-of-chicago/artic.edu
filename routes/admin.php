<?php

Route::module('pages');

Route::group(['prefix' => 'landing'], function () {
    Route::name('landing.home')->get('home', 'PageController@home');
    Route::name('landing.exhibitions')->get('exhibitions', 'PageController@exhibitions');
    Route::name('landing.art')->get('art', 'PageController@art');

    Route::group(['prefix' => 'visit'], function () {
        Route::name('landing.visit.page')->get('page', 'PageController@visit');
        Route::module('questions');
        Route::module('admissions');
        Route::module('feeAges');
        Route::module('feeCategories');

        Route::name('landing.visit.fees')->get('/fees', 'FeeController@index');
        Route::name('landing.visit.fees.update')->post('/fees', 'FeeController@update');
    });
});

Route::group(['prefix' => 'whatson'], function () {
    Route::module('events');
    Route::module('exhibitions');
});

Route::group(['prefix' => 'general'], function () {
  Route::module('hours');
  Route::module('closures');
  Route::module('categories');
  Route::module('siteTags');
  Route::module('segments');
  Route::module('sponsors');
});

Route::get('/', function() {
    return redirect()->route('admin.featured.homepage');
});
