<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::get('/', function () {
    return redirect('/api/v1');
});

Route::group(['prefix' => 'v1'], function () {

    Route::get('geotarget', 'API\GeotargetController@geotarget');

    Route::get('/', function () {
        return "API";
    });

    /**
     * Tags ------------------------------------------------------
     */
    Route::get('tags', 'API\TagsController@index');
    Route::get('tags/{id}', 'API\TagsController@show');

    /**
     * Locations ------------------------------------------------------
     */
    Route::get('locations', 'API\LocationsController@index');
    Route::get('locations/{id}', 'API\LocationsController@show');

    /**
     * Hours ------------------------------------------------------
     */
    Route::get('hours', 'API\HoursController@index');
    Route::get('hours/{id}', 'API\HoursController@show');

    /**
     * Hours ------------------------------------------------------
     */
    Route::get('closures', 'API\ClosuresController@index');
    Route::get('closures/deleted', 'API\ClosuresController@deleted');
    Route::get('closures/{id}', 'API\ClosuresController@show');

    /**
     * Exhibitions ------------------------------------------------------
     */
    Route::get('exhibitions', 'API\ExhibitionsController@index');
    Route::get('exhibitions/{id}', 'API\ExhibitionsController@show');

    /**
     * Events ------------------------------------------------------
     */
    Route::get('events', 'API\EventsController@index');
    Route::get('events/deleted', 'API\EventsController@deleted');
    Route::get('event-occurrences', 'API\EventOccurrencesController@occurrences');
    Route::get('events/{id}', 'API\EventsController@show');

    /**
     * Sponsors ------------------------------------------------------
     */
    Route::get('sponsors', 'API\SponsorsController@index');

    /**
     * Event-programs ------------------------------------------------------
     */
    Route::get('event-programs', 'API\EventProgramsController@index');

    /**
     * Articles ------------------------------------------------------
     */
    Route::get('articles', 'API\ArticlesController@index');
    Route::get('articles/deleted', 'API\ArticlesController@deleted');
    Route::get('articles/{id}', 'API\ArticlesController@show');

    /**
     * Highlights ------------------------------------------------------
     */
    Route::get('highlights', 'API\HighlightsController@index');
    Route::get('highlights/{id}', 'API\HighlightsController@show');

    /**
     * Artists ------------------------------------------------------
     */
    Route::get('artists', 'API\ArtistsController@index');
    Route::get('artists/{id}', 'API\ArtistsController@show');

    Route::get('staticpages', 'API\StaticPagesController@index');

    Route::get('staticpages/{id}', 'API\StaticPagesController@show');

    Route::get('emailseries', 'API\EmailSeriesController@index');

    Route::get('emailseries/{id}', 'API\EmailSeriesController@show');

    /**
     * Generic pages ------------------------------------------------------
     */
    Route::get('genericpages', 'API\GenericPagesController@index');
    Route::get('genericpages/deleted', 'API\GenericPagesController@deleted');
    Route::get('genericpages/{id}', 'API\GenericPagesController@show');

    /**
     * Press releases ------------------------------------------------------
     */
    Route::get('pressreleases', 'API\PressReleasesController@index');
    Route::get('pressreleases/deleted', 'API\PressReleasesController@deleted');
    Route::get('pressreleases/{id}', 'API\PressReleasesController@show');

    /**
     * Research guides ------------------------------------------------------
     */
    Route::get('researchguides', 'API\ResearchGuidesController@index');
    Route::get('researchguides/deleted', 'API\ResearchGuidesController@deleted');
    Route::get('researchguides/{id}', 'API\ResearchGuidesController@show');

    /**
     * Educator resources ------------------------------------------------------
     */
    Route::get('educatorresources', 'API\EducatorResourcesController@index');
    Route::get('educatorresources/deleted', 'API\EducatorResourcesController@deleted');
    Route::get('educatorresources/{id}', 'API\EducatorResourcesController@show');

    /**
     * Digital publications ------------------------------------------------------
     */
    Route::get('digitalpublications', 'API\DigitalPublicationsController@index');
    Route::get('digitalpublications/deleted', 'API\DigitalPublicationsController@deleted');
    Route::get('digitalpublications/{id}', 'API\DigitalPublicationsController@show');

    /**
     * Digital publication sections ------------------------------------------------------
     */
    Route::get('digitalpublicationsections', 'API\DigitalPublicationSectionsController@index');
    Route::get('digitalpublicationsections/deleted', 'API\DigitalPublicationSectionsController@deleted');
    Route::get('digitalpublicationsections/{id}', 'API\DigitalPublicationSectionsController@show');

    /**
     * Printed publications ------------------------------------------------------
     */
    Route::get('printedpublications', 'API\PrintedPublicationsController@index');
    Route::get('printedpublications/deleted', 'API\PrintedPublicationsController@deleted');
    Route::get('printedpublications/{id}', 'API\PrintedPublicationsController@show');

    /**
     * Videos --------------------------------------------------------------------
     */
    Route::get('videos', 'API\VideosController@index');
    Route::get('videos/deleted', 'API\VideosController@deleted');
    Route::get('videos/{id}', 'API\VideosController@show');

    /**
     * Interactive features --------------------------------------------------------------------
     */
    Route::get('interactive-features', 'API\InteractiveFeaturesController@index');
    Route::get('interactive-features/{id}', 'API\InteractiveFeaturesController@show');
    Route::get('experiences', 'API\ExperiencesController@index');
    Route::get('experiences/{id}', 'API\ExperiencesController@show');

    Route::options('seamless-images/{id}', 'SeamlessImagesController@byFile');
    Route::get('seamless-images/{id}', 'SeamlessImagesController@byFile');
});
