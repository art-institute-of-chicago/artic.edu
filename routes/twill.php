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

TwillRoutes::module('pages');

Route::group(['prefix' => 'homepage'], function () {
    Route::name('homepage.landing')->get('landing', [PageController::class, 'home']);
    TwillRoutes::module('homeFeatures');
    TwillRoutes::module('lightboxes');
    TwillRoutes::module('homeArtists');
});

Route::group(['prefix' => 'visit'], function () {
    Route::name('visit.landing')->get('landing', [PageController::class, 'visit']);
    TwillRoutes::module('hours');
    TwillRoutes::module('buildingClosures');
    TwillRoutes::module('questions');
    TwillRoutes::module('feeAges');
    TwillRoutes::module('feeCategories');
    TwillRoutes::module('shopItems');
    Route::name('visit.fees')->get('fees', [FeeController::class, 'index']);
    Route::name('visit.fees.update')->post('fees', [FeeController::class, 'update']);
    TwillRoutes::module('virtualTours');
    TwillRoutes::module('myMuseumTourItems');
});

Route::group(['prefix' => 'exhibitions_events'], function () {
    Route::name('exhibitions_events.landing')->get('landing', [PageController::class, 'exhibitions']);

    TwillRoutes::module('exhibitions');
    Route::get('exhibitions/augment/{datahub_id}', [ExhibitionController::class, 'augment'])->name('exhibitions_events.exhibitions.augment');

    TwillRoutes::module('events');
    TwillRoutes::module('sponsors');
    TwillRoutes::module('waitTimes');

    TwillRoutes::module('ticketedEvents');

    Route::get('history', [PageController::class, 'exhibitionHistory'])->name('exhibitions_events.history');

    TwillRoutes::module('emailSeries');

    TwillRoutes::module('magazineIssues');

    TwillRoutes::module('miradors');
});

Route::group(['prefix' => 'collection'], function () {
    Route::get('landing', [PageController::class, 'art'])->name('collection.landing');
    TwillRoutes::module('artworks');
    Route::get('artworks/augment/{datahub_id}', [ArtworkController::class, 'augment'])->name('collection.artworks.augment');
    TwillRoutes::module('artists');
    Route::get('artists/augment/{datahub_id}', [ArtistController::class, 'augment'])->name('collection.artists.augment');

    Route::group(['prefix' => 'interactive_features'], function () {
        TwillRoutes::module('interactiveFeatures');
        TwillRoutes::module('experiences');
        TwillRoutes::module('experiences.slides');
    });

    TwillRoutes::module('authors');

    TwillRoutes::module('categoryTerms');
    Route::get('categoryTerms/augment/{datahub_id}', [CategoryTermController::class, 'augment'])->name('collection.categoryTerms.augment');

    Route::group(['prefix' => 'research_resources'], function () {
        Route::get('landing', [PageController::class, 'research'])->name('collection.research_resources.landing');
        TwillRoutes::module('educatorResources');
    });

    Route::group(['prefix' => 'articles_publications'], function () {
        Route::get('landing', [PageController::class, 'articles_publications'])->name('collection.articles_publications.landing');
        Route::get('articles_landing', [PageController::class, 'articles'])->name('collection.articles_publications.articles_landing');
        TwillRoutes::module('articles');
        TwillRoutes::module('categories');
        TwillRoutes::module('videos');
        TwillRoutes::module('printedPublications');
        TwillRoutes::module('digitalPublications');
        TwillRoutes::module('digitalPublications.articles');

        // WEB-1963: Browser for nested modules must be implemented manually
        Route::get('/digitalPublicationsBrowser/articles/browser?digitalPublication={digitalPublication}', [DigitalPublicationArticleController::class, 'browser'])->name('collection.articles_publications.digitalPublications.articles.subbrowser');
        Route::get('/digitalPublicationsBrowser/articles/browser', [DigitalPublicationArticleController::class, 'browser'])->name('collection.articles_publications.digitalPublications.articles.browser');
    });

    TwillRoutes::module('galleries');
    Route::get('galleries/augment/{datahub_id}', [GalleryController::class, 'augment'])->name('collection.galleries.augment');

    TwillRoutes::module('departments');
    Route::get('departments/augment/{datahub_id}', [DepartmentController::class, 'augment'])->name('collection.departments.augment');

    TwillRoutes::module('highlights');
});

Route::group(['prefix' => 'generic'], function () {
    TwillRoutes::module('genericPages');
    TwillRoutes::module('landingPages');
    TwillRoutes::module('pageFeatures');
    TwillRoutes::module('pressReleases');
    TwillRoutes::module('exhibitionPressRooms');
});

Route::group(['prefix' => 'general'], function () {
    TwillRoutes::module('siteTags');
    TwillRoutes::module('searchTerms');
    TwillRoutes::module('pageCategories');
    TwillRoutes::module('catalogCategories');
    TwillRoutes::module('resourceCategories');
    TwillRoutes::module('shopItems');
    TwillRoutes::module('eventPrograms');
    TwillRoutes::module('tourStops');
    TwillRoutes::module('vanityRedirects');
});
