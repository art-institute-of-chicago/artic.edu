<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ArtworkController;
use App\Http\Controllers\Admin\ArtistController;
use App\Http\Controllers\Admin\CategoryTermController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\DigitalPublicationArticleController;
use App\Http\Controllers\Admin\ExhibitionController;
use App\Http\Controllers\Admin\FeeController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\Vendor\MediaLibraryController;

Route::module('pages');

Route::group(['prefix' => 'homepage'], function () {
    Route::name('homepage.landing')->get('landing', [PageController::class, 'home']);
    Route::module('homeFeatures');
    Route::module('lightboxes');
    Route::module('homeArtists');
});

Route::group(['prefix' => 'visit'], function () {
    Route::name('visit.landing')->get('landing', [PageController::class, 'visit']);
    Route::module('hours');
    Route::module('buildingClosures');
    Route::module('questions');
    Route::module('feeAges');
    Route::module('feeCategories');
    Route::module('shopItems');
    Route::name('visit.fees')->get('fees', [FeeController::class, 'index']);
    Route::name('visit.fees.update')->post('fees', [FeeController::class, 'update']);
    Route::module('virtualTours');
    Route::module('myMuseumTourItems');
});

Route::group(['prefix' => 'exhibitions_events'], function () {
    Route::name('exhibitions_events.landing')->get('landing', [PageController::class, 'exhibitions']);

    Route::module('exhibitions');
    Route::get('exhibitions/augment/{datahub_id}', [ExhibitionController::class, 'augment'])->name('exhibitions_events.exhibitions.augment');

    Route::module('events');
    Route::module('sponsors');
    Route::module('waitTimes');

    Route::module('ticketedEvents');

    Route::get('history', [PageController::class, 'exhibitionHistory'])->name('exhibitions_events.history');

    Route::module('emailSeries');

    Route::module('magazineIssues');

    Route::module('miradors');
});

Route::group(['prefix' => 'collection'], function () {
    Route::get('landing', [PageController::class, 'art'])->name('collection.landing');
    Route::module('artworks');
    Route::get('artworks/augment/{datahub_id}', [ArtworkController::class, 'augment'])->name('collection.artworks.augment');
    Route::module('artists');
    Route::get('artists/augment/{datahub_id}', [ArtistController::class, 'augment'])->name('collection.artists.augment');

    Route::group(['prefix' => 'interactive_features'], function () {
        Route::module('interactiveFeatures');
        Route::module('experiences');
        Route::module('experiences.slides');
    });

    Route::module('authors');

    Route::module('categoryTerms');
    Route::get('categoryTerms/augment/{datahub_id}', [CategoryTermController::class, 'augment'])->name('collection.categoryTerms.augment');

    Route::group(['prefix' => 'research_resources'], function () {
        Route::get('landing', [PageController::class, 'research'])->name('collection.research_resources.landing');
        Route::module('educatorResources');
    });

    Route::group(['prefix' => 'articles_publications'], function () {
        Route::get('landing', [PageController::class, 'articles_publications'])->name('collection.articles_publications.landing');
        Route::get('articles_landing', [PageController::class, 'articles'])->name('collection.articles_publications.articles_landing');
        Route::module('articles');
        Route::module('categories');
        Route::module('videos');
        Route::module('printedPublications');
        Route::module('digitalPublications');
        Route::module('digitalPublications.articles');

        // WEB-1963: Browser for nested modules must be implemented manually
        Route::get('digitalPublicationsFoo/{digitalPublication}/articles/browser', [DigitalPublicationArticleController::class, 'getSubbrowserItems'])->name('collection.articles_publications.digitalPublications.articles.subbrowser');
        Route::get('/digitalPublications/articles/browser', [DigitalPublicationArticleController::class, 'getBrowserItems'])->name('collection.articles_publications.digitalPublications.articles.browser');
    });

    Route::module('galleries');
    Route::get('galleries/augment/{datahub_id}', [GalleryController::class, 'augment'])->name('collection.galleries.augment');

    Route::module('departments');
    Route::get('departments/augment/{datahub_id}', [DepartmentController::class, 'augment'])->name('collection.departments.augment');

    Route::module('highlights');
});

Route::group(['prefix' => 'generic'], function () {
    Route::module('genericPages');
    Route::module('landingPages');
    Route::module('pageFeatures');
    Route::module('pressReleases');
    Route::module('exhibitionPressRooms');
});

Route::group(['prefix' => 'general'], function () {
    Route::module('siteTags');
    Route::module('searchTerms');
    Route::module('pageCategories');
    Route::module('catalogCategories');
    Route::module('resourceCategories');
    Route::module('shopItems');
    Route::module('eventPrograms');
    Route::module('tourStops');
    Route::module('vanityRedirects');
});

if (config('twill.enabled.media-library')) {
    Route::group(['prefix' => 'media-library', 'as' => 'media-library.'], function () {
        Route::resource('medias', MediaLibraryController::class, ['only' => ['index']]);
    });
}
