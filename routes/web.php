<?php

Route::name('target')->get('/target', 'HomeController@target');

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
/*Route::name('collection.autocomplete')->get('/collection/autocomplete', 'CollectionController@autocomplete');
Route::name('collection.autocomplete')->get('/collection/autocomplete', function(){
return redirect('//aggregator-data-test.artic.edu/api/v1/autocomplete?q='.request('q'));
});
 */
Route::group([
    "domain" => config('api.base_uri'),
], function () {
    Route::get("api/v1/msuggest")->name("collection.autocomplete");
});
Route::name('collection.categorySearch')->get('/collection/categorySearch/{categoryName}', 'CollectionController@categorySearch');

// Collection Publications Printed Publications
Route::name('collection.publications.printed-publications')->get('/print-publications', 'PrintedPublicationsController@index');
Route::name('collection.publications.printed-publications.show')->get('/print-publications/{id}', 'PrintedPublicationsController@show');
// Collection Publications Digital Publications
Route::name('collection.publications.digital-publications')->get('/digital-publications', 'DigitalPublicationsController@index');
Route::name('collection.publications.digital-publications.show')->get('/digital-publications/{id}', 'DigitalPublicationsController@show');

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
if (!app()->environment('production')) {
    Route::name('search.interactive-features')->get('/search/interactive-features', 'SearchController@interactiveFeatures');
}

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
Route::name('videos')->get('videos', function () {return abort(404);});
Route::name('videos.show')->get('/videos/{slug}', 'VideoController@show');

// Exhibition history routes
// Must remain before exhibition routes
Route::name('exhibitions.history')->get('exhibitions/history', 'ExhibitionHistoryController@index');
Route::name('exhibitions.history.show')->get('exhibitions/history/{id}', 'ExhibitionHistoryController@show');

// Exhibition routes
Route::name('exhibitions')->get('/exhibitions', 'ExhibitionsController@index');
Route::name('exhibitions.upcoming')->get('/exhibitions/upcoming', 'ExhibitionsController@upcoming');
Route::name('exhibitions.loadMoreRelatedEvents')->get('/exhibitions/{id}/relatedEvents', 'ExhibitionsController@loadMoreRelatedEvents')->where('id', '(.*)');
Route::name('exhibitions.show')->get('/exhibitions/{id}/{slug?}', 'ExhibitionsController@show');

// Artwork routes
Route::name('artworks.recentlyViewed')->get('/artworks/recentlyViewed', 'ArtworkController@recentlyViewed');
Route::name('artworks.clearRecentlyViewed')->get('/artworks/clearRecentlyViewed', 'ArtworkController@clearRecentlyViewed');
Route::name('artworks.addRecentlyViewed')->get('/artworks/addRecentlyViewed/{id}/{slug?}', 'ArtworkController@addRecentlyViewed');
Route::name('artworks.show')->get('/artworks/{id}/{slug?}', 'ArtworkController@show');

// Gallery / tag page
Route::name('galleries.show')->get('/galleries/{id}/{slug?}', 'GalleryController@show');

// Artist / tag page
Route::name('artists.show')->get('/artists/{id}/{slug?}', 'ArtistController@show');

// Department / tag page
Route::name('departments.show')->get('/departments/{id}/{slug?}', 'DepartmentController@show');

// Selections
Route::name('selections.show')->get('/highlights/{id}/{slug?}', 'SelectionsController@show');

// About
Route::name('about.press')->get('/press/press-releases', 'PressReleasesController@index');
Route::name('about.press.archive')->get('/press/archive', 'PressReleasesController@archive');

Route::name('about.exhibitionPressRooms')->middleware(['httpauth'])->get('/press/exhibition-press-room', 'ExhibitionPressRoomController@index');
Route::name('about.exhibitionPressRooms.show')->middleware(['httpauth'])->get('/press/exhibition-press-room/{id}/{slug?}', 'ExhibitionPressRoomController@show');

Route::name('about.press.show')->get('/press/press-releases/{id}/{slug?}', 'PressReleasesController@show');

// Sample Form
if (!app()->environment('production')) {
    Route::name('forms.contact')->get('/forms/contact', 'Forms\ContactsController@index');
    Route::name('forms.contact.store')->post('/forms/contact', 'Forms\ContactsController@store');
    Route::name('forms.contact.thanks')->get('/forms/contact/thanks', 'Forms\ContactsController@thanks');
}

// Group reservation form
Route::name('forms.group-reservation')->get('/visit/visiting-with-a-group/reservation-form', 'Forms\GroupReservationsController@index');
Route::name('forms.group-reservation.store')->post('/visit/visiting-with-a-group/reservation-form', 'Forms\GroupReservationsController@store');
Route::name('forms.group-reservation.thanks')->get('/visit/visiting-with-a-group/reservation-form/thanks', 'Forms\GroupReservationsController@thanks');

// Event planning contact
Route::name('forms.event-planning-contact')->get('/venue-rental/contact-us', 'Forms\EventPlanningContactController@index');
Route::name('forms.event-planning-contact.store')->post('/venue-rental/contact-us', 'Forms\EventPlanningContactController@store');
Route::name('forms.event-planning-contact.thanks')->get('/venue-rental/contact-us/thanks', 'Forms\EventPlanningContactController@thanks');

// Educator admission request
Route::name('forms.educator-admission-request')->get('/educators/visit-on-my-own/educator-admission-request', 'Forms\EducatorAdmissionController@index');
Route::name('forms.educator-admission-request.store')->post('/educators/visit-on-my-own/educator-admission-request', 'Forms\EducatorAdmissionController@store');
Route::name('forms.educator-admission-request.thanks')->get('/educators/visit-on-my-own/educator-admission-request/thanks', 'Forms\EducatorAdmissionController@thanks');

// Filming and photo shoot proposal
Route::name('forms.filming-proposal')->get('/press/filming-policy/filming-photo-shoot-proposal-form', 'Forms\FilmingAndPhotoShootProposalController@index');
Route::name('forms.filming-proposal.store')->post('/press/filming-policy/filming-photo-shoot-proposal-form', 'Forms\FilmingAndPhotoShootProposalController@store');
Route::name('forms.filming-proposal.thanks')->get('/press/filming-policy/filming-photo-shoot-proposal-form/thanks', 'Forms\FilmingAndPhotoShootProposalController@thanks');

// Ryerson class visit request
Route::name('forms.ryerson-class-visit')->get('/library/request-a-class-visit/schedule', 'Forms\RyersonClassVisitController@index');
Route::name('forms.ryerson-class-visit.store')->post('/library/request-a-class-visit/schedule', 'Forms\RyersonClassVisitController@store');
Route::name('forms.ryerson-class-visit.thanks')->get('/library/request-a-class-visit/schedule/thanks', 'Forms\RyersonClassVisitController@thanks');

// Email subscriptions request
Route::name('forms.email-subscriptions')->get('/email-subscriptions', 'Forms\EmailSubscriptionsController@index');
Route::name('forms.email-subscriptions.store')->post('/email-subscriptions', 'Forms\EmailSubscriptionsController@store');
Route::name('forms.email-subscriptions.thanks')->get('/email-subscriptions/thanks', 'Forms\EmailSubscriptionsController@thanks');

Route::get('enews', function () {
    return redirect()->route('forms.email-subscriptions', request()->all());
});
Route::get('e-news', function () {
    return redirect()->route('forms.email-subscriptions', request()->all());
});

// Digital labels
Route::name('interactiveFeatures')->get('/interactive-features', 'InteractiveFeatureExperiencesController@index');
Route::name('interactiveFeatures.test')->get('/interactive-features/test', 'InteractiveFeatureExperiencesController@test');
Route::name('interactiveFeatures.show')->get('/interactive-features/{slug}', 'InteractiveFeatureExperiencesController@show');
Route::name('interactiveFeatures.showKiosk')->get('/interactive-features/kiosk/{slug}', 'InteractiveFeatureExperiencesController@show');

// Feed routes
Route::feeds();

// Generic Page w/ httpauth
Route::name('about.press.art-institute-images')->middleware(['httpauth'])->get('/press/art-institute-images', function () {
    return App::make(App\Http\Controllers\GenericPagesController::class)->show('/press/art-institute-images');
});

Route::get('blablabla')->name('blablabla');

// Generic Page
Route::get('{any}', ['as' => 'genericPages.show', 'uses' => 'GenericPagesController@show'])->where('any', '.*');
