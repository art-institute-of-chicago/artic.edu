<?php

Route::module('pages');

Route::group(['prefix' => 'landing'], function () {
    Route::name('landing.home')->get('home', 'PageController@home');
    Route::name('landing.exhibitions')->get('exhibitions', 'PageController@exhibitions');
    Route::name('landing.art')->get('art', 'PageController@art');
    Route::name('landing.visit')->get('visit', 'PageController@visit');
    Route::name('landing.articles')->get('articles', 'PageController@articles');
});

Route::group(['prefix' => 'whatson'], function () {
    Route::module('exhibitions');
    Route::name('whatson.exhibitions.augment')->get('exhibitions/augment/{datahub_id}', 'ExhibitionController@augment');
    Route::module('artworks');
    Route::name('whatson.artworks.augment')->get('artworks/augment/{datahub_id}', 'ArtworkController@augment');
    Route::module('artists');
    Route::name('whatson.artists.augment')->get('artists/augment/{datahub_id}', 'ArtistController@augment');

    Route::module('shopItems');

    Route::module('events');
    Route::module('articles');
    Route::module('selections');

    Route::module('galleries');
    Route::name('whatson.galleries.augment')->get('galleries/augment/{datahub_id}', 'GalleryController@augment');
});

Route::group(['prefix' => 'general'], function () {
    Route::module('hours');
    Route::module('closures');
    Route::module('categories');
    Route::module('siteTags');
    Route::module('sponsors');
    Route::module('questions');
    Route::module('admissions');
    Route::module('locations');
    Route::module('shopItems');
    Route::module('feeAges');
    Route::module('feeCategories');
    Route::name('general.fees')->get('/fees', 'FeeController@index');
    Route::name('general.fees.update')->post('/fees', 'FeeController@update');
});

Route::get('/', function () {
    return redirect()->route('admin.featured.homepage');
});
