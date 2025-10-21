<?php

use A17\Twill\Facades\TwillRoutes;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Twill\ArtworkController;
use App\Http\Controllers\Twill\ArtistController;
use App\Http\Controllers\Twill\CategoryTermController;
use App\Http\Controllers\Twill\DepartmentController;
use App\Http\Controllers\Twill\DigitalPublicationArticleController;
use App\Http\Controllers\Twill\ExhibitionController;
use App\Http\Controllers\Twill\GalleryController;
use App\Http\Controllers\Twill\IntegrationController;
use App\Http\Controllers\Twill\PageController;
use App\Http\Controllers\Twill\ShopItemController;

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
    TwillRoutes::module('fees');
    TwillRoutes::module('shopItems');
    TwillRoutes::module('myMuseumTourItems');
});

Route::group(['prefix' => 'exhibitionsEvents'], function () {
    Route::name('exhibitionsEvents.landing')->get('landing', [PageController::class, 'exhibitions']);

    TwillRoutes::module('exhibitions');
    Route::get('exhibitions/augment/{datahub_id}', [ExhibitionController::class, 'augment'])->name('exhibitionsEvents.exhibitions.augment');

    TwillRoutes::module('events');
    TwillRoutes::module('sponsors');
    TwillRoutes::module('waitTimes');

    TwillRoutes::module('ticketedEvents');

    Route::get('history', [PageController::class, 'exhibitionHistory'])->name('exhibitionsEvents.history');

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

    Route::group(['prefix' => 'interactiveFeatures'], function () {
        TwillRoutes::module('interactiveFeatures');
        TwillRoutes::module('experiences');
        TwillRoutes::module('experiences.slides');
    });

    TwillRoutes::module('authors');

    TwillRoutes::module('categoryTerms');
    Route::get('categoryTerms/augment/{datahub_id}', [CategoryTermController::class, 'augment'])->name('collection.categoryTerms.augment');

    Route::group(['prefix' => 'researchResources'], function () {
        Route::get('landing', [PageController::class, 'research'])->name('collection.researchResources.landing');
        TwillRoutes::module('educatorResources');
    });

    Route::group(['prefix' => 'articlesPublications'], function () {
        Route::get('landing', [PageController::class, 'articlesPublications'])->name('collection.articlesPublications.landing');
        Route::get('articles_landing', [PageController::class, 'articles'])->name('collection.articlesPublications.articles_landing');
        TwillRoutes::module('articles');
        TwillRoutes::module('categories');
        TwillRoutes::module('videos');
        TwillRoutes::module('videos.captions');
        TwillRoutes::module('playlists');
        TwillRoutes::module('playlists.videos');
        TwillRoutes::module('printedPublications');
        TwillRoutes::module('digitalPublications');
        TwillRoutes::module('digitalPublications.articles');

        // WEB-1963: Browser for nested modules must be implemented manually
        Route::get('/digitalPublicationsBrowser/articles/browser?digitalPublication={digitalPublication}', [DigitalPublicationArticleController::class, 'browser'])->name('collection.articlesPublications.digitalPublications.articles.subbrowser');
        Route::get('/digitalPublicationsBrowser/articles/browser', [DigitalPublicationArticleController::class, 'browser'])->name('collection.articlesPublications.digitalPublications.articles.browserbrowser');
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
    Route::get('shopItems/augment/{datahub_id}', [ShopItemController::class, 'augment'])->name('general.shopItems.augment');
    TwillRoutes::module('eventPrograms');
    TwillRoutes::module('tourStops');
    TwillRoutes::module('vanityRedirects');
    TwillRoutes::module('illuminatedLinks');
    Route::get('/integrations', [IntegrationController::class, 'show'])->name('general.integrations.show');
    Route::get('/integrations/{provider}/disconnect', [IntegrationController::class, 'disconnect'])->name('general.integrations.disconnect');
});
