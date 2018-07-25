<?php

Route::name('home')->get('/', 'HomeController@index');

// Statics routes
if (!app()->environment('production')) {
  Route::get('/autocomplete/{slug?}', 'StaticsController@autocomplete');
  Route::get('/collections/search/{slug?}', 'StaticsController@collectionsAutocomplete');
  Route::get('/exhibitions_load_more', 'StaticsController@exhibitions_load_more');
  Route::get('/statics/{slug?}', 'StaticsController@index');
}

// Collection routes
Route::name('collection')->get('/collection', 'CollectionController@index');
Route::name('collection.more')->get('/collection/more', 'CollectionController@index');
Route::name('collection.autocomplete')->get('/collection/autocomplete', 'CollectionController@autocomplete');
Route::name('collection.categorySearch')->get('/collection/categorySearch/{categoryName}', 'CollectionController@categorySearch');

// Collection Publications Printed Catalogs
Route::name('collection.publications.printed-catalogs')->get('/printed-catalogues', 'PrintedCatalogsController@index');
Route::name('collection.publications.printed-catalogs.show')->get('/printed-catalogues/{id}', 'PrintedCatalogsController@show');
// Collection Publications Digital Catalogs
Route::name('collection.publications.digital-catalogs')->get('/digital-catalogues', 'DigitalCatalogsController@index');
Route::name('collection.publications.digital-catalogs.show')->get('/digital-catalogues/{id}', 'DigitalCatalogsController@show');

// Collection Research
Route::name('collection.research_resources')->get('/collection/research_resources', 'ResearchController@index');

// Collection Resources - Research Guides
Route::name('collection.resources.research-guides')->get('/collection/resources/research-guides', 'ResearchGuidesController@index');
Route::name('collection.resources.research-guides.show')->get('/collection/resources/research-guides/{id}', 'ResearchGuidesController@show');

// Collection Resources Educator Resources
Route::name('collection.resources.educator-resources')->get('/learn-with-us/educators/tools-for-my-classroom/resource-finder', 'EducatorResourcesController@index');
Route::name('collection.resources.educator-resources.show')->get('/collection/resources/educator-resources/{id}', 'EducatorResourcesController@show');

// Newsletter subscription
Route::name('subscribe')->post('/subscribe', 'SubscribeController@store');

// Visit routes
Route::name('visit')->get('/visit', 'VisitController@index');

// Search routes
Route::name('search')->get('/search', 'SearchController@index');
Route::name('search.autocomplete')->get('/search/autocomplete', 'SearchController@autocomplete');
Route::name('search.artists')->get('/search/artists', 'SearchController@artists');
Route::name('search.articles')->get('/search/articles', 'SearchController@articles');
Route::name('search.events')->get('/search/events', 'SearchController@events');
Route::name('search.pages')->get('/search/pages', 'SearchController@pages');
Route::name('search.publications')->get('/search/publications', 'SearchController@publications');
Route::name('search.artworks')->get('/search/artworks', 'SearchController@artworks');
Route::name('search.press-releases')->get('/search/press-releases', 'SearchController@pressReleases');
Route::name('search.research-guides')->get('/search/research-guides', 'SearchController@researchGuides');
Route::name('search.exhibitions')->get('/search/exhibitions', 'SearchController@exhibitions');

// Events routes
Route::name('events')->get('/events', 'EventsController@index');
Route::name('events.more')->get('/events-more', 'EventsController@indexMore');
Route::name('events.ics')->get('/events/{id}/ics', 'EventsController@ics');
Route::name('events.show')->get('/events/{id}/{slug?}', 'EventsController@show');

// Articles & Publications routes
Route::name('articles_publications')->get('/articles_publications', 'ArticlesPublicationsController@index');

// Articles routes
Route::name('articles')->get('/articles', 'ArticleController@index');
Route::name('articles.show')->get('/articles/{id}/{slug?}', 'ArticleController@show');

// Videos routes
Route::name('videos')->get('videos', function() { return abort(404); });
Route::name('videos.show')->get('/videos/{slug}', 'VideoController@show');

// Exhibition history routes
// Must remain before exhibition routes
Route::name('exhibitions.history')->get('exhibitions/history', 'ExhibitionHistoryController@index');
Route::name('exhibitions.history.show')->get('exhibitions/history/{id}', 'ExhibitionHistoryController@show');

// Exhibition routes
Route::name('exhibitions')->get('/exhibitions', 'ExhibitionsController@index');
Route::name('exhibitions.upcoming')->get('/exhibitions/upcoming', 'ExhibitionsController@upcoming');
Route::name('exhibitions.loadMoreRelatedEvents')->get('/exhibitions/{id}/relatedEvents', 'ExhibitionsController@loadMoreRelatedEvents');
Route::name('exhibitions.show')->get('/exhibitions/{id}/{slug?}', 'ExhibitionsController@show');

// Artwork routes
Route::name('artworks.recentlyViewed')->get('/artworks/recentlyViewed', 'ArtworkController@recentlyViewed');
Route::name('artworks.clearRecentlyViewed')->get('/artworks/clearRecentlyViewed', 'ArtworkController@clearRecentlyViewed');
Route::name('artworks.addRecentlyViewed')->get('/artworks/addRecentlyViewed/{id}', 'ArtworkController@addRecentlyViewed');
Route::name('artworks.show')->get('/artworks/{id}/{slug?}', 'ArtworkController@show');

// Gallery / tag page
Route::name('galleries.show')->get('/galleries/{id}/{slug?}', 'GalleryController@show');

// Artist / tag page
Route::name('artists.show')->get('/artists/{id}/{slug?}', 'ArtistController@show');

// Department / tag page
Route::name('departments.show')->get('/departments/{id}/{slug?}', 'DepartmentController@show');

// Selections
Route::name('selections.show')->get('/selections/{id}', 'SelectionsController@show');

// About
Route::name('about.press')->get('/press/press-releases', 'PressReleasesController@index');
Route::name('about.press.archive')->get('/press/archive', 'PressReleasesController@archive');

Route::name('about.exhibitionPressRooms')->middleware(['httpauth'])->get('/press/exhibition-press-room', 'ExhibitionPressRoomController@index');
Route::name('about.exhibitionPressRooms.show')->middleware(['httpauth'])->get('/press/exhibition-press-room/{id}', 'ExhibitionPressRoomController@show');

Route::name('about.press.show')->get('/press/{id}', 'PressReleasesController@show');

// Sample Form
Route::name('forms.contact')->get('/forms/contact', 'Forms\ContactsController@index');
Route::name('forms.contact.store')->post('/forms/contact', 'Forms\ContactsController@store');
Route::name('forms.contact.thanks')->get('/forms/contact/thanks', 'Forms\ContactsController@thanks');

// Feed routes
Route::feeds();

// Generic Page
Route::get('{any}', ['as' => 'genericPages.show', 'uses' => 'GenericPagesController@show'])->where('any', '.*');
