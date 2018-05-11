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
Route::name('collection.more')->get('/collection/more', 'CollectionController@index');
Route::name('collection.autocomplete')->get('/collection/autocomplete', 'CollectionController@autocomplete');
Route::name('collection.categorySearch')->get('/collection/categorySearch/{categoryName}', 'CollectionController@categorySearch');

// Collection Publications ???
// Route::name('collection.publications')->get('/collection/publications', 'PublicationsController@index');
// Collection Publications Printed Catalogs
Route::name('collection.publications.printed-catalogs')->get('/collection/publications/printed-catalogs', 'PrintedCatalogsController@index');
Route::name('collection.publications.printed-catalogs.show')->get('/collection/publications/printed-catalogs/{id}', 'PrintedCatalogsController@show');
// Collection Publications Digital Catalogs
Route::name('collection.publications.digital-catalogs')->get('/collection/publications/digital-catalogs', 'DigitalCatalogsController@index');
Route::name('collection.publications.digital-catalogs.show')->get('/collection/publications/digital-catalogs/{id}', 'DigitalCatalogsController@show');
// Collection Publications Scholarly Journals
Route::name('collection.publications.scholarly-journals')->get('/collection/publications/scholarly-journals', 'ScholarlyJournalsController@index');
Route::name('collection.publications.scholarly-journals.show')->get('/collection/publications/scholarly-journals/{id}', 'ScholarlyJournalsController@show');

// Collection Research and Resources ???
Route::name('collection.research_resources')->get('/collection/research_resources', 'ResearchController@index');
// Collection Resources Research Guides
Route::name('collection.resources.research-guides')->get('/collection/resources/research-guides', 'ResearchGuidesController@index');
Route::moduleShowWithPreview('researchguides');
Route::name('collection.resources.research-guides.show')->get('/collection/resources/research-guides/{id}', 'ResearchGuidesController@show');
// Collection Resources Educator Resources
Route::name('collection.resources.educator-resources')->get('/collection/resources/educator-resources', 'EducatorResourcesController@index');
Route::moduleShowWithPreview('educatorresources');
Route::name('collection.resources.educator-resources.show')->get('/collection/resources/educator-resources/{id}', 'EducatorResourcesController@show');

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
Route::name('events.ics')->get('/events/{id}/ics', 'EventsController@ics');

// Articles & Publications routes
Route::name('articles_publications')->get('/articles_publications', 'ArticlesPublicationsController@index');

// Articles routes
Route::name('articles')->get('/articles', 'ArticleController@index');
Route::name('articles.show')->get('/articles/{id}', 'ArticleController@show');

// Videos routes
Route::name('videos')->get('videos', function() { return abort(404); });
// Route::moduleShowWithPreview('videos');
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
Route::name('artworks.recentlyViewed')->get('/artworks/recentlyViewed', 'ArtworkController@recentlyViewed');
Route::name('artworks.clearRecentlyViewed')->get('/artworks/clearRecentlyViewed', 'ArtworkController@clearRecentlyViewed');
Route::name('artworks.addRecentlyViewed')->get('/artworks/addRecentlyViewed/{id}', 'ArtworkController@addRecentlyViewed');
Route::name('artworks.show')->get('/artworks/{id}', 'ArtworkController@show');

// Gallery / tag page
Route::name('galleries.show')->get('/galleries/{id}', 'GalleryController@show');

// Artist / tag page
Route::name('artists.show')->get('/artists/{id}', 'ArtistController@show');

// Department / tag page
Route::name('departments.show')->get('/departments/{id}', 'DepartmentController@show');

// Selections
Route::moduleShowWithPreview('selection');
Route::name('selections.show')->get('/selections/{id}', 'SelectionsController@show');

// About
Route::name('about-us')->get('/about', 'GenericPagesController@show');
Route::name('about.press')->get('/about/press', 'PressReleasesController@index');
Route::name('about.press.archive')->get('/about/press/archive', 'PressReleasesController@archive');
Route::moduleShowWithPreview('pressreleases');
Route::name('about.press.show')->get('/about/press/{id}', 'PressReleasesController@show');

// Footer Head Links
Route::name('learn')->get('/learn', 'GenericPagesController@show');
Route::name('support-us')->get('/support-us', 'GenericPagesController@show');


// Sample Form
Route::name('forms.contact')->get('/forms/contact', 'Forms\ContactsController@index');
Route::name('forms.contact.store')->post('/forms/contact', 'Forms\ContactsController@store');
Route::name('forms.contact.thanks')->get('/forms/contact/thanks', 'Forms\ContactsController@thanks');


// Generic Page
// This MUST be the last route
Route::moduleShowWithPreview('genericpages');
Route::get('{any}', ['as' => 'genericpages.show', 'uses' => 'GenericPagesController@show'])->where('any', '.*');
