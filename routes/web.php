<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ArticlesPublicationsController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\ArtworkController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DigitalPublicationsController;
use App\Http\Controllers\DigitalPublicationSectionController;
use App\Http\Controllers\EducatorResourcesController;
use App\Http\Controllers\ExhibitionsController;
use App\Http\Controllers\ExhibitionHistoryController;
use App\Http\Controllers\ExhibitionPressRoomController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\GenericPagesController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HighlightsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InteractiveFeatureExperiencesController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\IssueArticleController;
use App\Http\Controllers\MagazineIssueController;
use App\Http\Controllers\MiradorController;
use App\Http\Controllers\PressReleasesController;
use App\Http\Controllers\PreviewController;
use App\Http\Controllers\PrintedPublicationsController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\ResearchController;
use App\Http\Controllers\ResearchGuidesController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SubscribeController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\VirtualTourController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\Forms\EducatorAdmissionController;
use App\Http\Controllers\Forms\EmailSubscriptionsController;
use App\Http\Controllers\Forms\EventPlanningContactController;
use App\Http\Controllers\Forms\FilmingAndPhotoShootProposalController;
use App\Http\Controllers\Forms\GroupReservationsController;
use App\Http\Controllers\Forms\RyersonClassVisitController;

Route::name('previewLink')->get('p/{hash}', [PreviewController::class, 'show']);

Route::name('today')->get('/today', [RedirectController::class, 'today']);

Route::name('target')->get('/target', [HomeController::class, 'target']);

Route::name('home')->get('/', [HomeController::class, 'index']);

// Collection routes
Route::name('collection')->get('/collection', [CollectionController::class, 'index']);
/*Route::name('collection.autocomplete')->get('/collection/autocomplete', [CollectionController::class, 'autocomplete']);
Route::name('collection.autocomplete')->get('/collection/autocomplete', function(){
return redirect('//api.artic.edu/api/v1/autocomplete?q='.request('q'));
});
 */
Route::group([
    'domain' => config('api.public_uri'),
], function () {
    Route::get('api/v1/msuggest')->name('collection.autocomplete');
});
Route::name('collection.categorySearch')->get('/collection/categorySearch/{categoryName}', [CollectionController::class, 'categorySearch']);

// Collection Publications Printed Publications
Route::name('collection.publications.printed-publications')->get('/print-publications', [PrintedPublicationsController::class, 'index']);
Route::name('collection.publications.printed-publications.show')->get('/print-publications/{id}/{slug?}', [PrintedPublicationsController::class, 'show']);
// Collection Publications Digital Publications
Route::name('collection.publications.digital-publications')->get('/digital-publications', [DigitalPublicationsController::class, 'index']);
Route::name('collection.publications.digital-publications.show')->get('/digital-publications/{id}/{slug?}', [DigitalPublicationsController::class, 'show']);
Route::name('collection.publications.digital-publications-sections.show')->get('/digital-publications/{pubId}/{pubSlug}/{id}/{slug?}', [DigitalPublicationSectionController::class, 'show']);

// Collection Research
Route::name('collection.research_resources')->get('/collection/research_resources', [ResearchController::class, 'index']);

// Collection Resources - Research Guides
Route::name('collection.resources.research-guides')->get('/collection/resources/research-guides', [ResearchGuidesController::class, 'index']);
Route::name('collection.resources.research-guides.show')->get('/collection/resources/research-guides/{id}', [ResearchGuidesController::class, 'show']);

// Collection Resources Educator Resources
Route::name('collection.resources.educator-resources')->get('/learn-with-us/educators/tools-for-my-classroom/resource-finder', [EducatorResourcesController::class, 'index']);
Route::name('collection.resources.educator-resources.show')->get('/collection/resources/educator-resources/{id}', [EducatorResourcesController::class, 'show']);

// Newsletter subscription
Route::name('subscribe')->post('/subscribe', [SubscribeController::class, 'store']);

// Visit routes
Route::name('visit')->get('/visit', [VisitController::class, 'index']);

// Search routes
Route::name('search')->get('/search', [SearchController::class, 'index']);
Route::name('search.autocomplete')->get('/search/autocomplete', [SearchController::class, 'autocomplete']);
Route::name('search.artists')->get('/search/artists', [SearchController::class, 'artists']);
Route::name('search.articles')->get('/search/articles', [SearchController::class, 'articles']);
Route::name('search.events')->get('/search/events', [SearchController::class, 'events']);
Route::name('search.pages')->get('/search/pages', [SearchController::class, 'pages']);
Route::name('search.publications')->get('/search/publications', [SearchController::class, 'publications']);
Route::name('search.artworks')->get('/search/artworks', [SearchController::class, 'artworks']);
Route::name('search.press-releases')->get('/search/press-releases', [SearchController::class, 'pressReleases']);
Route::name('search.research-guides')->get('/search/research-guides', [SearchController::class, 'researchGuides']);
Route::name('search.exhibitions')->get('/search/exhibitions', [SearchController::class, 'exhibitions']);
Route::name('search.interactive-features')->get('/search/interactive-features', [SearchController::class, 'interactiveFeatures']);
Route::name('search.highlights')->get('/search/highlights', [SearchController::class, 'highlights']);

// Events routes
Route::name('events')->get('/events', [EventsController::class, 'index']);
Route::name('events.more')->get('/events-more', [EventsController::class, 'indexMore']);
Route::name('events.ics')->get('/events/{id}/ics', [EventsController::class, 'ics']);
Route::name('events.show')->get('/events/{id}/{slug?}', [EventsController::class, 'show']);

// Articles & Publications routes
Route::name('articles_publications')->get('/articles_publications', [ArticlesPublicationsController::class, 'index']);

// Articles routes
Route::name('articles')->get('/articles', [ArticleController::class, 'index']);
Route::name('articles.show')->get('/articles/{id}/{slug?}', [ArticleController::class, 'show']);

// Journal routes
Route::name('issues.latest')->get('/artinstitutereview', [IssueController::class, 'latest']);
Route::name('issues.show')->get('/artinstitutereview/issues/{issueNumber}/{slug?}', [IssueController::class, 'show']);
Route::name('issue-articles.show')->get('/artinstitutereview/articles/{id}/{slug?}', [IssueArticleController::class, 'show']);

// PUB-148: Redirect legacy journal URLs via cannonical functionality
Route::name('alt-issues.latest')->get('/journal', [IssueController::class, 'latest']);
Route::name('alt-issues.show')->get('/journal/issues/{issueNumber}/{slug?}', [IssueController::class, 'show']);
Route::name('alt-issue-articles.show')->get('/journal/articles/{id}/{slug?}', [IssueArticleController::class, 'show']);

// Magazine issue routes
Route::name('magazine-issues.show')->get('/magazine/issues/{id}/{slug?}', [MagazineIssueController::class, 'show']);
Route::name('magazine-issues.latest')->get('/magazine', [MagazineIssueController::class, 'latest']);

// Author routes
Route::name('authors.index')->get('/authors', [AuthorController::class, 'index']);
Route::name('authors.show')->get('/authors/{id}/{slug?}', [AuthorController::class, 'show']);

// Videos routes
Route::name('videos')->get('videos', function () {
    return abort(404);
});
Route::name('videos.show')->get('/videos/{id}/{slug?}', [VideoController::class, 'show']);

// Virtual Tours routes
Route::name('virtualTours')->get('virtual-tours', function () {
    return abort(404);
});
Route::name('virtualTours.show')->get('/virtual-tours/{id}/{slug?}', [VirtualTourController::class, 'show']);

// Mirador kiosk routes
Route::name('mirador')->get('mirador', function () {
    return abort(404);
});
Route::name('mirador.show')->get('/mirador/{id}/{slug?}', [MiradorController::class, 'show']);

// Exhibition history routes
// Must remain before exhibition routes
Route::name('exhibitions.history')->get('exhibitions/history', [ExhibitionHistoryController::class, 'index']);
Route::name('exhibitions.history.show')->get('exhibitions/history/{id}', [ExhibitionHistoryController::class, 'show']);

// Exhibition routes
Route::name('exhibitions')->get('/exhibitions', [ExhibitionsController::class, 'index']);
Route::name('exhibitions.upcoming')->get('/exhibitions/upcoming', [ExhibitionsController::class, 'upcoming']);
Route::name('exhibitions.waitTime')->get('/exhibitions/waitTime/{id}/{slug?}/{variation?}', [ExhibitionsController::class, 'waitTime']);
Route::name('exhibitions.loadMoreRelatedEvents')->get('/exhibitions/{id}/relatedEvents', [ExhibitionsController::class, 'loadMoreRelatedEvents'])->where('id', '(.*)');
Route::name('exhibitions.show')->get('/exhibitions/{id}/{slug?}', [ExhibitionsController::class, 'show']);

// Artwork routes
Route::name('artworks.recentlyViewed')->get('/artworks/recentlyViewed', [ArtworkController::class, 'recentlyViewed']);
Route::name('artworks.clearRecentlyViewed')->get('/artworks/clearRecentlyViewed', [ArtworkController::class, 'clearRecentlyViewed']);
Route::name('artworks.addRecentlyViewed')->get('/artworks/addRecentlyViewed/{id}/{slug?}', [ArtworkController::class, 'addRecentlyViewed']);
Route::name('artworks.exploreFurther')->get('/artworks/{id}/exploreFurther', [ArtworkController::class, 'exploreFurther']);
Route::name('artworks.show')->get('/artworks/{id}/{slug?}', [ArtworkController::class, 'show']);

// Gallery / tag page
Route::name('galleries.show')->get('/galleries/{id}/{slug?}', [GalleryController::class, 'show']);

// Artist / tag page
Route::name('artists.show')->get('/artists/{id}/{slug?}', [ArtistController::class, 'show']);

// Department / tag page
Route::name('departments.show')->get('/departments/{id}/{slug?}', [DepartmentController::class, 'show']);

// Highlights
Route::name('highlights.show')->get('/highlights/{id}/{slug?}', [HighlightsController::class, 'show']);
Route::name('highlights.index')->get('/highlights', [HighlightsController::class, 'index']);

// About
Route::name('about.press')->get('/press/press-releases', [PressReleasesController::class, 'index']);
Route::name('about.press.archive')->get('/press/archive', [PressReleasesController::class, 'archive']);
Route::name('about.press.show')->get('/press/press-releases/{id}/{slug?}', [PressReleasesController::class, 'show']);

Route::name('about.exhibitionPressRooms')->middleware(['httpauth'])->get('/press/exhibition-press-room', [ExhibitionPressRoomController::class, 'index']);
Route::name('about.exhibitionPressRooms.show')->middleware(['httpauth'])->get('/press/exhibition-press-room/{id}/{slug?}', [ExhibitionPressRoomController::class, 'show']);

// Group reservation form
Route::name('forms.group-reservation')->get('/visit/visiting-with-a-group/reservation-form', [GroupReservationsController::class, 'index']);
Route::name('forms.group-reservation.store')->post('/visit/visiting-with-a-group/reservation-form', [GroupReservationsController::class, 'store']);
Route::name('forms.group-reservation.thanks')->get('/visit/visiting-with-a-group/reservation-form/thanks', [GroupReservationsController::class, 'thanks']);

// Event planning contact
Route::name('forms.event-planning-contact')->get('/venue-rental/contact-us', [EventPlanningContactController::class, 'index']);
Route::name('forms.event-planning-contact.store')->post('/venue-rental/contact-us', [EventPlanningContactController::class, 'store']);
Route::name('forms.event-planning-contact.thanks')->get('/venue-rental/contact-us/thanks', [EventPlanningContactController::class, 'thanks']);

// Educator admission request
Route::name('forms.educator-admission-request')->get('/educators/visit-on-my-own/educator-admission-request', [EducatorAdmissionController::class, 'index']);
Route::name('forms.educator-admission-request.store')->post('/educators/visit-on-my-own/educator-admission-request', [EducatorAdmissionController::class, 'store']);
Route::name('forms.educator-admission-request.thanks')->get('/educators/visit-on-my-own/educator-admission-request/thanks', [EducatorAdmissionController::class, 'thanks']);

// Filming and photo shoot proposal
Route::name('forms.filming-proposal')->get('/press/filming-policy/filming-photo-shoot-proposal-form', [FilmingAndPhotoShootProposalController::class, 'index']);
Route::name('forms.filming-proposal.store')->post('/press/filming-policy/filming-photo-shoot-proposal-form', [FilmingAndPhotoShootProposalController::class, 'store']);
Route::name('forms.filming-proposal.thanks')->get('/press/filming-policy/filming-photo-shoot-proposal-form/thanks', [FilmingAndPhotoShootProposalController::class, 'thanks']);

// Ryerson class visit request
Route::name('forms.ryerson-class-visit')->get('/library/request-a-class-visit/schedule', [RyersonClassVisitController::class, 'index']);
Route::name('forms.ryerson-class-visit.store')->post('/library/request-a-class-visit/schedule', [RyersonClassVisitController::class, 'store']);
Route::name('forms.ryerson-class-visit.thanks')->get('/library/request-a-class-visit/schedule/thanks', [RyersonClassVisitController::class, 'thanks']);

// Email subscriptions request
Route::name('forms.email-subscriptions')->get('/email-subscriptions', [EmailSubscriptionsController::class, 'index']);
Route::name('forms.email-subscriptions.store')->post('/email-subscriptions', [EmailSubscriptionsController::class, 'store']);
Route::name('forms.email-subscriptions.thanks')->get('/email-subscriptions/thanks', [EmailSubscriptionsController::class, 'thanks']);

Route::get('enews', function () {
    return redirect()->route('forms.email-subscriptions', request()->all());
});
Route::get('e-news', function () {
    return redirect()->route('forms.email-subscriptions', request()->all());
});

// Digital labels
Route::name('interactiveFeatures')->get('/interactive-features', [InteractiveFeatureExperiencesController::class, 'index']);
Route::name('interactiveFeatures.show')->get('/interactive-features/{slug}', [InteractiveFeatureExperiencesController::class, 'show']);
Route::name('interactiveFeatures.showKiosk')->get('/interactive-features/kiosk/{slug}', [InteractiveFeatureExperiencesController::class, 'show']);

// Feed routes
Route::feeds();

// Generic Page w/ httpauth
Route::name('about.press.art-institute-images')->middleware(['httpauth'])->get('/press/art-institute-images', function () {
    return App::make(App\Http\Controllers\GenericPagesController::class)->show('/press/art-institute-images');
});

// Generic Page
Route::get('{any}', ['as' => 'genericPages.show', 'uses' => [GenericPagesController::class, 'show']])->where('any', '.*');
