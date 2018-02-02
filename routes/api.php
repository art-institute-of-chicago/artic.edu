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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::get('/', function () {
    return redirect('/api/v1');
});


/**
 * @SWG\Swagger(
 *      produces={"application/json"},
 *      consumes={"application/json"},
 *      @SWG\Info(
 *          title="AIC CMS API", version="1.0",
 *          description="REST API",
 *          version="1.0",
 *          termsOfService="terms",
 *          @SWG\Contact(name="call@me.com"),
 *          @SWG\License(name="proprietary")
 *      ),
 *
 *     @SWG\Definition(
 *        definition="Tag",
 *        type="object",
 *        required={"id", "name"},
 *        @SWG\Property(property="id", type="string", description="ID of Tag"),
 *        @SWG\Property(property="title", type="string", description="Title"),
 *        @SWG\Property(property="name", type="string", description="Name of Tag"),
 *        @SWG\Property(property="last_updated", type="datetime", description="Last Updated At"),
 *     ),

 *     @SWG\Definition(
 *        definition="Location",
 *        type="object",
 *        required={"id", "name"},
 *        @SWG\Property(property="id", type="string", description="ID of Location"),
 *        @SWG\Property(property="title", type="string", description="Title"),
 *        @SWG\Property(property="name", type="string", description="Name of Location"),
 *        @SWG\Property(property="street", type="string", description="Street of Location"),
 *        @SWG\Property(property="address", type="string", description="Address of Location"),
 *        @SWG\Property(property="city", type="string", description="City of Location"),
 *        @SWG\Property(property="state", type="string", description="State of Location"),
 *        @SWG\Property(property="zip", type="string", description="Zip of Location"),
 *        @SWG\Property(property="published", type="boolean", description="Published State of Location"),
 *     ),

 *     @SWG\Definition(
 *        definition="Hour",
 *        type="object",
 *        required={"id"},
 *        @SWG\Property(property="id", type="string", description="ID of Location"),
 *        @SWG\Property(property="title", type="string", description="Title"),
 *        @SWG\Property(property="opening_time", type="datetime", description="Opening Time"),
 *        @SWG\Property(property="closing_time", type="datetime", description="Closing Time"),
 *        @SWG\Property(property="type", type="integer", description="Type"),
 *        @SWG\Property(property="day_of_week", type="integer", description="City of Location"),
 *        @SWG\Property(property="closed", type="boolean", description="Closed?"),
 *        @SWG\Property(property="last_updated", type="datetime", description="Last Updated At"),
 *     ),
 * )
 */

Route::group(['prefix' => 'v1'], function()
{

    Route::get('/', function () {
        return "API";
    });

    /**
     *
     * - tags ------------------------------------------------------
     *
     * @SWG\Get(
     *      path="/api/v1/tags",
     *      tags={"tags"},
     *      operationId="getTags",
     *      summary="List all tags",
     *      @SWG\Response(response="200", description="List all tags")
     *  )
     *
     */
    Route::get('tags', 'API\TagsController@index');

    /**
     * @SWG\Get(
     *      path="/api/v1/tags/{id}",
     *      tags={"tags"},
     *      operationId="getTag",
     *      summary="Fetch tag details",
     *      @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          type="integer",
     *          description="id",
     *      ),
     *      @SWG\Response(response="200", description="Get a specific tag")
     *  )
     *
     */
    Route::get('tags/{id}', 'API\TagsController@show');

    /**
     *
     * - locations ------------------------------------------------------
     *
     * @SWG\Get(
     *      path="/api/v1/locations",
     *      tags={"locations"},
     *      operationId="getLocations",
     *      summary="List all locations",
     *      @SWG\Response(response="200", description="List all locations")
     *  )
     *
     */
    Route::get('locations', 'API\LocationsController@index');

    /**
     * @SWG\Get(
     *      path="/api/v1/locations/{id}",
     *      tags={"locations"},
     *      operationId="getLocation",
     *      summary="Fetch location details",
     *      @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          type="integer",
     *          description="id",
     *      ),
     *      @SWG\Response(response="200", description="Get a specific location")
     *  )
     *
     */
    Route::get('locations/{id}', 'API\LocationsController@show');

    /**
     *
     * - hours ------------------------------------------------------
     *
     * @SWG\Get(
     *      path="/api/v1/hours",
     *      tags={"hours"},
     *      operationId="getHours",
     *      summary="List all hours",
     *      @SWG\Response(response="200", description="List all hours")
     *  )
     *
     */
    Route::get('hours', 'API\HoursController@index');
    /**
     * @SWG\Get(
     *      path="/api/v1/hours/{id}",
     *      tags={"hours"},
     *      operationId="getHour",
     *      summary="Fetch hours details",
     *      @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          type="integer",
     *          description="id",
     *      ),
     *      @SWG\Response(response="200", description="Get a specific hours entry")
     *  )
     *
     */
    Route::get('hours/{id}', 'API\HoursController@show');

    // Route::get('holidays', 'API\HolidaysController@index');

    /**
     *
     * - hours ------------------------------------------------------
     *
     * @SWG\Get(
     *      path="/api/v1/closures",
     *      tags={"closures"},
     *      operationId="getClosures",
     *      summary="List all closures",
     *      @SWG\Response(response="200", description="List all closures")
     *  )
     *
     */
    Route::get('closures', 'API\ClosuresController@index');
    /**
     * @SWG\Get(
     *      path="/api/v1/closures/{id}",
     *      tags={"closures"},
     *      operationId="getClosure",
     *      summary="Fetch closures details",
     *      @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          type="integer",
     *          description="id",
     *      ),
     *      @SWG\Response(response="200", description="Get a specific closure")
     *  )
     *
     */
    Route::get('closures/{id}', 'API\ClosuresController@show');

    // Route::get('modules', 'API\ModulesController@index');
    // Route::get('modules/{id}', 'API\ModulesController@show');

    /**
     *
     * - exhibitions ------------------------------------------------------
     *
     * @SWG\Get(
     *      path="/api/v1/exhibitions",
     *      tags={"exhibitions"},
     *      operationId="getExhibitions",
     *      summary="List all exhibitions",
     *      @SWG\Response(response="200", description="List all exhibitions")
     *  )
     *
     */
    Route::get('exhibitions', 'API\ExhibitionsController@index');
    /**
     * @SWG\Get(
     *      path="/api/v1/exhibitions/{id}",
     *      tags={"exhibitions"},
     *      operationId="getExhibition",
     *      summary="Fetch exhibitions details",
     *      @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          type="integer",
     *          description="id",
     *      ),
     *      @SWG\Response(response="200", description="Get a specific exhibition")
     *  )
     *
     */
    Route::get('exhibitions/{id}', 'API\ExhibitionsController@show');

    /**
     *
     * - events ------------------------------------------------------
     *
     * @SWG\Get(
     *      path="/api/v1/events",
     *      tags={"events"},
     *      operationId="getEvents",
     *      summary="List all events",
     *      @SWG\Response(response="200", description="List all events")
     *  )
     *
     */
    Route::get('events', 'API\EventsController@index');
    /**
     * @SWG\Get(
     *      path="/api/v1/events/{id}",
     *      tags={"events"},
     *      operationId="getEvent",
     *      summary="Fetch events details",
     *      @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          type="integer",
     *          description="id",
     *      ),
     *      @SWG\Response(response="200", description="Get a specific event")
     *  )
     *
     */
    Route::get('events/{id}', 'API\EventsController@show');

    /**
     *
     * - articles ------------------------------------------------------
     *
     * @SWG\Get(
     *      path="/api/v1/articles",
     *      tags={"articles"},
     *      operationId="getArticles",
     *      summary="List all articles",
     *      @SWG\Response(response="200", description="List all articles")
     *  )
     *
     */
    Route::get('articles', 'API\ArticlesController@index');
    /**
     * @SWG\Get(
     *      path="/api/v1/articles/{id}",
     *      tags={"articles"},
     *      operationId="getArticle",
     *      summary="Fetch articles details",
     *      @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          type="integer",
     *          description="id",
     *      ),
     *      @SWG\Response(response="200", description="Get a specific article")
     *  )
     *
     */
    Route::get('articles/{id}', 'API\ArticlesController@show');

    /**
     *
     * - selections ------------------------------------------------------
     *
     * @SWG\Get(
     *      path="/api/v1/selections",
     *      tags={"selections"},
     *      operationId="getSelections",
     *      summary="List all selections",
     *      @SWG\Response(response="200", description="List all selections")
     *  )
     *
     */
    Route::get('selections', 'API\SelectionsController@index');
    /**
     * @SWG\Get(
     *      path="/api/v1/selections/{id}",
     *      tags={"selections"},
     *      operationId="getSelection",
     *      summary="Fetch selections details",
     *      @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          type="integer",
     *          description="id",
     *      ),
     *      @SWG\Response(response="200", description="Get a specific selection")
     *  )
     *
     */
    Route::get('selections/{id}', 'API\SelectionsController@show');

    /**
     *
     * - artists ------------------------------------------------------
     *
     * @SWG\Get(
     *      path="/api/v1/artists",
     *      tags={"artists"},
     *      operationId="getArtists",
     *      summary="List all artists",
     *      @SWG\Response(response="200", description="List all artists")
     *  )
     *
     */
    Route::get('artists', 'API\ArtistsController@index');
    /**
     * @SWG\Get(
     *      path="/api/v1/artists/{id}",
     *      tags={"artists"},
     *      operationId="getArtist",
     *      summary="Fetch artists details",
     *      @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          type="integer",
     *          description="id",
     *      ),
     *      @SWG\Response(response="200", description="Get a specific artist")
     *  )
     *
     */
    Route::get('artists/{id}', 'API\ArtistsController@show');

});
