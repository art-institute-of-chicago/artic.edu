<?php

Route::module('pages');

Route::group(['prefix' => 'homepage'], function () {
    Route::name('homepage.landing')->get('landing', 'PageController@home');
    Route::module('homeFeatures');
});

Route::group(['prefix' => 'visit'], function () {
    Route::name('visit.landing')->get('landing', 'PageController@visit');
    Route::module('hours');
    Route::module('closures');
    Route::module('sponsors');
    Route::module('questions');
    Route::module('feeAges');
    Route::module('feeCategories');
    Route::name('visit.fees')->get('fees', 'FeeController@index');
    Route::name('visit.fees.update')->post('fees', 'FeeController@update');

    Route::module('galleries');
    Route::name('visit.galleries.augment')->get('galleries/augment/{datahub_id}', 'GalleryController@augment');

    Route::module('departments');
    Route::name('visit.departments.augment')->get('departments/augment/{datahub_id}', 'DepartmentController@augment');
});

Route::group(['prefix' => 'exhibitions_events'], function () {
    Route::name('exhibitions_events.landing')->get('landing', 'PageController@exhibitions');

    Route::module('exhibitions');
    Route::name('exhibitions_events.exhibitions.augment')->get('exhibitions/augment/{datahub_id}', 'ExhibitionController@augment');

    Route::module('events');

    Route::name('exhibitions_events.history')->get('history', 'PageController@exhibitionHistory');
});

Route::group(['prefix' => 'collection'], function () {
    Route::name('collection.landing')->get('landing', 'PageController@collection');
    Route::module('artworks');
    Route::name('collection.artworks.augment')->get('artworks/augment/{datahub_id}', 'ArtworkController@augment');
    Route::module('artists');
    Route::name('collection.artists.augment')->get('artists/augment/{datahub_id}', 'ArtistController@augment');

    Route::group(['prefix' => 'articles_publications'], function () {
        Route::name('collection.articles_publications.landing')->get('landing', 'PageController@art');
        Route::module('articles');
        Route::module('categories');
    });

    Route::module('selections');

});

Route::group(['prefix' => 'whatson'], function () {
    Route::module('shopItems');
});
//
// Route::group(['prefix' => 'general'], function () {
//     Route::module('categories');
//     Route::module('siteTags');
//     Route::module('sponsors');
//     Route::module('admissions');
//     Route::module('locations');
//     Route::module('shopItems');
//     Route::module('searchTerms');
// });

Route::get('/', function () {
    return redirect()->route('admin.homepage.landing');
})->name('home');
