<?php

Route::name('home')->get('/', 'HomeController@index');

if (!app()->environment('production')) {
  Route::get('/autocomplete/{slug?}', 'StaticsController@autocomplete');
  Route::get('/collections/search/{slug?}', 'StaticsController@collectionsAutocomplete');
  Route::get('/statics/{slug?}', 'StaticsController@index');
}

// Visit routes
Route::name('visit')->get('/visit', 'VisitController@index');


// Search routes
Route::name('search')->get('/search', 'SearchController@index');

// Events routes
Route::name('events')->get('/events', 'EventController@index');
Route::name('events.show')->get('/events/{id}', 'EventController@show');

// Articles routes
Route::name('articles')->get('/articles', 'ArticleController@index');
Route::name('articles.show')->get('/articles/{slug}', 'ArticleController@show');

// Exhibition routes
Route::name('exhibitions')->get('/exhibitions', 'ExhibitionController@index');
Route::name('exhibitions.show')->get('/exhibitions/{id}', 'ExhibitionController@show');

// Artwork routes
Route::name('artworks')->get('/artworks/{id}', 'ArtworkController@show');

// Exhibition history routes
Route::resource('exhibitionHistory', 'ExhibitionHistoryController', ['only' => ['index', 'show']]);

