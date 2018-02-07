<?php

Route::name('home')->get('/', 'HomeController@index');

if (!app()->environment('production')) {
  Route::get('/autocomplete/{slug?}', 'StaticsController@autocomplete');
  Route::get('/collections/search/{slug?}', 'StaticsController@collectionsAutocomplete');
  Route::get('/statics/{slug?}', 'StaticsController@index');
}

// Search routes
Route::name('search')->get('/search', 'SearchController@index');

// Events routes
Route::name('events')->get('/events', 'EventController@index');
Route::name('events')->get('/events/{id}', 'EventController@show');

// Articles routes
Route::name('articles')->get('/articles', 'ArticleController@index');
Route::name('articles')->get('/articles/{id}', 'ArticleController@show');

// Exhibition history routes
Route::resource('exhibitionHistory', 'ExhibitionHistoryController', ['only' => ['index', 'show']]);

