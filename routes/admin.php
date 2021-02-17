<?php

Route::module('pages');

Route::group(['prefix' => 'homepage'], function () {
    Route::name('homepage.landing')->get('landing', 'PageController@home');
    Route::module('homeFeatures');
    Route::module('lightboxes');
    Route::module('homeArtists');
});

Route::group(['prefix' => 'visit'], function () {
    Route::name('visit.landing')->get('landing', 'PageController@visit');
    Route::module('hours');
    Route::module('closures');
    Route::module('questions');
    Route::module('feeAges');
    Route::module('feeCategories');
    Route::module('shopItems');
    Route::name('visit.fees')->get('fees', 'FeeController@index');
    Route::name('visit.fees.update')->post('fees', 'FeeController@update');
    Route::module('virtualTours');
});

Route::group(['prefix' => 'exhibitions_events'], function () {
    Route::name('exhibitions_events.landing')->get('landing', 'PageController@exhibitions');

    Route::module('exhibitions');
    Route::name('exhibitions_events.exhibitions.augment')->get('exhibitions/augment/{datahub_id}', 'ExhibitionController@augment');

    Route::module('events');
    Route::module('sponsors');
    Route::module('waitTimes');

    Route::module('ticketedEvents');

    Route::name('exhibitions_events.history')->get('history', 'PageController@exhibitionHistory');

    //Route::name('exhibitions_events.digitalLabels.augment')->get('interactive-features/augment/{datahub_id}', 'DigitalLabelController@augment');

    Route::module('emailSeries');

    Route::module('magazineIssues');

    Route::module('mirador');
});

Route::group(['prefix' => 'collection'], function () {
    Route::name('collection.landing')->get('landing', 'PageController@art');
    Route::module('artworks');
    Route::name('collection.artworks.augment')->get('artworks/augment/{datahub_id}', 'ArtworkController@augment');
    Route::module('artists');
    Route::name('collection.artists.augment')->get('artists/augment/{datahub_id}', 'ArtistController@augment');

    Route::group(['prefix' => 'interactive_features'], function () {
        Route::module('interactiveFeatures');
        Route::module('experiences');
        Route::module('experiences.slides');
    });

    Route::module('issues');
    Route::module('issues.articles');
    Route::module('authors');

    Route::module('categoryTerms');
    Route::name('collection.categoryTerms.augment')->get('categoryTerms/augment/{datahub_id}', 'CategoryTermController@augment');

    Route::group(['prefix' => 'research_resources'], function () {
        Route::name('collection.research_resources.landing')->get('landing', 'PageController@research');
        Route::module('researchGuides');
        Route::module('educatorResources');
    });

    Route::group(['prefix' => 'articles_publications'], function () {
        Route::name('collection.articles_publications.landing')->get('landing', 'PageController@articles_publications');
        Route::name('collection.articles_publications.articles_landing')->get('articles_landing', 'PageController@articles');
        Route::module('articles');
        Route::module('categories');
        Route::module('videos');
        Route::module('printedPublications');
        Route::module('digitalPublications');
        Route::module('digitalPublications.sections');

        // WEB-1963: Browser for nested modules must be implemented manually
        Route::name('collection.articles_publications.digitalPublications.sections.subbrowser')->get('digitalPublicationsFoo/{digitalPublication}/sections/browser', 'DigitalPublicationSectionController@browser');
    });

    Route::module('galleries');
    Route::name('collection.galleries.augment')->get('galleries/augment/{datahub_id}', 'GalleryController@augment');

    Route::module('departments');
    Route::name('collection.departments.augment')->get('departments/augment/{datahub_id}', 'DepartmentController@augment');

    Route::module('selections');

});

Route::group(['prefix' => 'generic'], function () {
    Route::module('genericPages');
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
