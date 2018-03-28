<?php

Route::name('home')->get('/', 'HomeController@index');

if (!app()->environment('production')) {
  Route::get('/autocomplete/{slug?}', 'StaticsController@autocomplete');
  Route::get('/collections/search/{slug?}', 'StaticsController@collectionsAutocomplete');
  Route::get('/exhibitions_load_more', 'StaticsController@exhibitions_load_more');
  Route::get('/statics/{slug?}', 'StaticsController@index');
}

// Routes related to session

// Collection routes
Route::name('collection')->get('/collection', 'CollectionController@index');
Route::name('collection.autocomplete')->get('/collection/autocomplete', 'CollectionController@autocomplete');
Route::name('collection.recently-viewed.clear')->get('/collection/recently-viewed/clear', 'CollectionController@clearRecentlyViewed');

// Newsletter subscription
Route::name('subscribe')->post('/subscribe', 'SubscribeController@store');

// Visit routes
Route::name('visit')->get('/visit', 'VisitController@index');

// Search routes
Route::name('search')->get('/search', 'SearchController@index');
Route::name('search.autocomplete')->get('/search/autocomplete', 'SearchController@autocomplete');
Route::name('search.artists')->get('/search/artists', 'SearchController@artists');
Route::name('search.artworks')->get('/search/artworks', 'SearchController@artworks');
Route::name('search.exhibitionsEvents')->get('/search/exhibitions_and_events', 'SearchController@exhibitionsEvents');

// Events routes
Route::name('events')->get('/events', 'EventsController@index');
Route::name('events.more')->get('/events-more', 'EventsController@indexMore');
Route::moduleShowWithPreview('events');

// Articles routes
Route::name('articles')->get('/articles', 'ArticleController@index');
Route::name('articles.show')->get('/articles/{id}', 'ArticleController@show');

// Videos routes
Route::name('videos.show')->get('/videos/{slug}', 'VideoController@show');

// Exhibition history routes
// Must remain before exhibition routes
Route::name('exhibitions.history')->get('exhibitions/history', 'ExhibitionHistoryController@index');
Route::name('exhibitions.history.show')->get('exhibitions/history/{id}', 'ExhibitionHistoryController@show');

// Exhibition routes
Route::name('exhibitions')->get('/exhibitions', 'ExhibitionsController@index');
Route::name('exhibitions.upcoming')->get('/exhibitions/upcoming', 'ExhibitionsController@upcoming');
Route::name('exhibitions.loadMoreRelatedEvents')->get('/exhibitions/{id}/relatedEvents', 'ExhibitionsController@loadMoreRelatedEvents');
Route::moduleShowWithPreview('exhibitions');

// Artwork routes
Route::name('artworks.show')->get('/artworks/{id}', 'ArtworkController@show');

// Gallery / tag page
Route::name('galleries.show')->get('/galleries/{id}', 'GalleryController@show');

// Selections
Route::name('selections.show')->get('/selections/{id}', 'SelectionsController@show');

// Generic Page
// This MUST be the last route
Route::get('{any}', ['as' => 'genericpages.show', 'uses' => 'GenericPagesController@show'])->where('any', '.*');
