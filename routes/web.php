<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
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
use App\Http\Controllers\InteractiveFeatureExperiencesController;
use App\Http\Controllers\LandingPagesController;
use App\Http\Controllers\MagazineIssueController;
use App\Http\Controllers\MiradorController;
use App\Http\Controllers\MyMuseumTourController;
use App\Http\Controllers\PressReleasesController;
use App\Http\Controllers\PreviewController;
use App\Http\Controllers\PrintedPublicationsController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\ResearchController;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SubscribeController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\VirtualTourController;
use App\Http\Controllers\Forms\EducatorAdmissionController;
use App\Http\Controllers\Forms\EmailSubscriptionsController;
use App\Http\Controllers\Forms\FilmingAndPhotoShootProposalController;
use App\Models\Slugs\LandingPageSlug;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('p/{hash}', [PreviewController::class, 'show'])->name('previewLink');

Route::get('/today', [RedirectController::class, 'today'])->name('today');

Route::get('/robots.txt', [RobotsController::class, 'index'])->name('robots-txt');

// Landing Page
Route::get('/', [LandingPagesController::class, 'slugHome'])->name('home');
Route::get('/landingpages/{id}/{slug?}', [LandingPagesController::class, 'show'])->name('landingPages.show');

// Collection routes
Route::get('/collection', [CollectionController::class, 'index'])->name('collection');
/*Route::get('/collection/autocomplete', [CollectionController::class, 'autocomplete'])->name('collection.autocomplete');
Route::get('/collection/autocomplete', function(){
return redirect('//api.artic.edu/api/v1/autocomplete?q='.request('q'));
})->name('collection.autocomplete');
 */
Route::group([
    'domain' => config('api.public_uri'),
], function () {
    Route::get('api/v1/msuggest')->name('collection.autocomplete');
});
Route::get('/collection/categorySearch/{categoryName}', [CollectionController::class, 'categorySearch'])->name('collection.categorySearch');

// Collection Publications Printed Publications
Route::get('/print-publications', [PrintedPublicationsController::class, 'index'])->name('collection.publications.printed-publications');
Route::get('/print-publications/{id}/{slug?}', [PrintedPublicationsController::class, 'show'])->name('collection.publications.printed-publications.show');
// Collection Publications Digital Publications
Route::get('/digital-publications', [DigitalPublicationsController::class, 'index'])->name('collection.publications.digital-publications');
Route::get('/digital-publications/{id}/{slug?}', [DigitalPublicationsController::class, 'show'])->name('collection.publications.digital-publications.show');
Route::get('/digital-publications/{pubId}/{pubSlug}/{id}/{slug?}', [DigitalPublicationSectionController::class, 'show'])->name('collection.publications.digital-publications-sections.show');

// Collection Research
Route::get('/collection/research_resources', [ResearchController::class, 'index'])->name('collection.research_resources');

// Collection Resources Educator Resources
Route::get('/learn-with-us/educators/tools-for-my-classroom/resource-finder', [EducatorResourcesController::class, 'index'])->name('collection.resources.educator-resources');
Route::get('/collection/resources/educator-resources/{id}', [EducatorResourcesController::class, 'show'])->name('collection.resources.educator-resources.show');

// Newsletter subscription
Route::post('/subscribe', [SubscribeController::class, 'store'])->name('subscribe');

// Search routes
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/search/autocomplete', [SearchController::class, 'autocomplete'])->name('search.autocomplete');
Route::get('/search/artists', [SearchController::class, 'artists'])->name('search.artists');
Route::get('/search/articles', [SearchController::class, 'articles'])->name('search.articles');
Route::get('/search/events', [SearchController::class, 'events'])->name('search.events');
Route::get('/search/pages', [SearchController::class, 'pages'])->name('search.pages');
Route::get('/search/publications', [SearchController::class, 'publications'])->name('search.publications');
Route::get('/search/artworks', [SearchController::class, 'artworks'])->name('search.artworks');
Route::get('/search/press-releases', [SearchController::class, 'pressReleases'])->name('search.press-releases');
Route::get('/search/educator-resources', [SearchController::class, 'educatorResources'])->name('search.educator-resources');
Route::get('/search/exhibitions', [SearchController::class, 'exhibitions'])->name('search.exhibitions');
Route::get('/search/interactive-features', [SearchController::class, 'interactiveFeatures'])->name('search.interactive-features');
Route::get('/search/highlights', [SearchController::class, 'highlights'])->name('search.highlights');

// Events routes
Route::get('/events', [EventsController::class, 'index'])->name('events');
Route::get('/events-more', [EventsController::class, 'indexMore'])->name('events.more');
Route::get('/events/{id}/ics', [EventsController::class, 'ics'])->name('events.ics');
Route::get('/events/{id}/{slug?}', [EventsController::class, 'show'])->name('events.show');

// Articles & Publications routes
Route::get('/articles_publications', [ArticlesPublicationsController::class, 'index'])->name('articles_publications');

// Articles routes
Route::get('/articles', [ArticleController::class, 'index'])->name('articles');
Route::get('/articles/{id}/{slug?}', [ArticleController::class, 'show'])->name('articles.show');

// Magazine issue routes
Route::get('/magazine/issues/{id}/{slug?}', [MagazineIssueController::class, 'show'])->name('magazine-issues.show');
Route::get('/magazine', [MagazineIssueController::class, 'latest'])->name('magazine-issues.latest');

// Author routes
Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');
Route::get('/authors/{id}/{slug?}', [AuthorController::class, 'show'])->name('authors.show');

// Videos routes
Route::get('videos', function () {
    return abort(404);
})->name('videos');
Route::get('/videos/{id}/{slug?}', [VideoController::class, 'show'])->name('videos.show');

// Virtual Tours routes
Route::get('virtual-tours', function () {
    return abort(404);
})->name('virtualTours');
Route::get('/virtual-tours/{id}/{slug?}', [VirtualTourController::class, 'show'])->name('virtualTours.show');

// Mirador kiosk routes
Route::get('mirador', function () {
    return abort(404);
})->name('mirador');
Route::get('/mirador/{id}/{slug?}', [MiradorController::class, 'show'])->name('mirador.show');

// Exhibition history routes
// Must remain before exhibition routes
Route::get('exhibitions/history', [ExhibitionHistoryController::class, 'index'])->name('exhibitions.history');
Route::get('exhibitions/history/{id}', [ExhibitionHistoryController::class, 'show'])->name('exhibitions.history.show');

// Exhibition routes
Route::get('/exhibitions', [ExhibitionsController::class, 'index'])->name('exhibitions');
Route::get('/exhibitions/upcoming', [ExhibitionsController::class, 'upcoming'])->name('exhibitions.upcoming');
Route::get('/exhibitions/waitTime/{id}/{slug?}/{variation?}', [ExhibitionsController::class, 'waitTime'])->name('exhibitions.waitTime');
Route::get('/exhibitions/{id}/relatedEvents', [ExhibitionsController::class, 'loadMoreRelatedEvents'])->where('id', '(.*)')->name('exhibitions.loadMoreRelatedEvents');
Route::get('/exhibitions/{id}/{slug?}', [ExhibitionsController::class, 'show'])->name('exhibitions.show');

// Artwork routes
Route::get('/artworks/recentlyViewed', [ArtworkController::class, 'recentlyViewed'])->name('artworks.recentlyViewed');
Route::get('/artworks/clearRecentlyViewed', [ArtworkController::class, 'clearRecentlyViewed'])->name('artworks.clearRecentlyViewed');
Route::get('/artworks/addRecentlyViewed/{id}/{slug?}', [ArtworkController::class, 'addRecentlyViewed'])->name('artworks.addRecentlyViewed');
Route::get('/artworks/{id}/exploreFurther', [ArtworkController::class, 'exploreFurther'])->name('artworks.exploreFurther');
Route::get('/artworks/{id}/{slug?}', [ArtworkController::class, 'show'])->name('artworks.show');

// Gallery / tag page
Route::get('/galleries/{id}/{slug?}', [GalleryController::class, 'show'])->name('galleries.show');

// Artist / tag page
Route::get('/artists/{id}/{slug?}', [ArtistController::class, 'show'])->name('artists.show');

// Department / tag page
Route::get('/departments/{id}/{slug?}', [DepartmentController::class, 'show'])->name('departments.show');

// Highlights
Route::get('/highlights/{id}/{slug?}', [HighlightsController::class, 'show'])->name('highlights.show');
Route::get('/highlights', [HighlightsController::class, 'index'])->name('highlights.index');

// About
Route::get('/press/press-releases', [PressReleasesController::class, 'index'])->name('about.press');
Route::get('/press/archive', [PressReleasesController::class, 'archive'])->name('about.press.archive');
Route::get('/press/press-releases/{id}/{slug?}', [PressReleasesController::class, 'show'])->name('about.press.show');

Route::get('/press/exhibition-press-room', [ExhibitionPressRoomController::class, 'index'])->name('about.exhibitionPressRooms');
Route::get('/press/exhibition-press-room/{id}/{slug?}', [ExhibitionPressRoomController::class, 'show'])->name('about.exhibitionPressRooms.show');

// Educator admission request
Route::get('/educators/visit-on-my-own/educator-admission-request', [EducatorAdmissionController::class, 'index'])->name('forms.educator-admission-request');
Route::post('/educators/visit-on-my-own/educator-admission-request', [EducatorAdmissionController::class, 'store'])->name('forms.educator-admission-request.store');
Route::get('/educators/visit-on-my-own/educator-admission-request/thanks', [EducatorAdmissionController::class, 'thanks'])->name('forms.educator-admission-request.thanks');

// Filming and photo shoot proposal
Route::get('/press/filming-policy/filming-photo-shoot-proposal-form', [FilmingAndPhotoShootProposalController::class, 'index'])->name('forms.filming-proposal');
Route::post('/press/filming-policy/filming-photo-shoot-proposal-form', [FilmingAndPhotoShootProposalController::class, 'store'])->name('forms.filming-proposal.store');
Route::get('/press/filming-policy/filming-photo-shoot-proposal-form/thanks', [FilmingAndPhotoShootProposalController::class, 'thanks'])->name('forms.filming-proposal.thanks');

// Email subscriptions request
Route::get('/email-subscriptions', [EmailSubscriptionsController::class, 'index'])->name('forms.email-subscriptions');
Route::post('/email-subscriptions', [EmailSubscriptionsController::class, 'store'])->name('forms.email-subscriptions.store');
Route::get('/email-subscriptions/thanks', [EmailSubscriptionsController::class, 'thanks'])->name('forms.email-subscriptions.thanks');

Route::get('enews', function () {
    return redirect()->route('forms.email-subscriptions', request()->all());
});
Route::get('e-news', function () {
    return redirect()->route('forms.email-subscriptions', request()->all());
});

// Digital labels
Route::get('/interactive-features', [InteractiveFeatureExperiencesController::class, 'index'])->name('interactiveFeatures');
Route::get('/interactive-features/{slug}', [InteractiveFeatureExperiencesController::class, 'show'])->name('interactiveFeatures.show');
Route::get('/interactive-features/kiosk/{slug}', [InteractiveFeatureExperiencesController::class, 'show'])->name('interactiveFeatures.show-kiosk');

// My Museum Tour routes
Route::get('/my-museum-tour/builder', [MyMuseumTourController::class, 'showMyMuseumTourBuilder'])->name('my-museum-tour.builder');
Route::get('/my-museum-tour/{id}', [MyMuseumTourController::class, 'show'])->name('my-museum-tour.show');

Route::get('/my-museum-tour/{id}/pdf-layout', [MyMuseumTourController::class, 'pdfLayout'])->name('my-museum-tour.pdf-layout');
Route::get('/my-museum-tour/{id}/qrcode.png', [MyMuseumTourController::class, 'qrcode'])->name('my-museum-tour.qrcode');

// Feed routes
Route::feeds();

// Generic Page
Route::get('{slug}', [GenericPagesController::class, 'show'])->where('slug', '.*')->name('pages.slug');
