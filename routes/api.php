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
 *        @SWG\Property(property="id", type="integer", description="ID of Tag"),
 *        @SWG\Property(property="name", type="string", description="Name of Tag"),
 *        @SWG\Property(property="last_updated", type="datetime", description="Last Updated At"),
 *     ),
 *
 *     @SWG\Definition(
 *        definition="Location",
 *        type="object",
 *        required={"id", "name"},
 *        @SWG\Property(property="id", type="integer", description="ID of Location"),
 *        @SWG\Property(property="name", type="string", description="Name of Location"),
 *        @SWG\Property(property="street", type="string", description="Street of Location"),
 *        @SWG\Property(property="address", type="string", description="Address of Location"),
 *        @SWG\Property(property="city", type="string", description="City of Location"),
 *        @SWG\Property(property="state", type="string", description="State of Location"),
 *        @SWG\Property(property="zip", type="string", description="Zip of Location"),
 *        @SWG\Property(property="published", type="boolean", description="Published State of Location"),
 *        @SWG\Property(property="web_url", type="string", description="Web Url"),
 *     ),
 *
 *     @SWG\Definition(
 *        definition="Hour",
 *        type="object",
 *        required={"id"},
 *        @SWG\Property(property="id", type="integer", description="ID of Hour"),
 *        @SWG\Property(property="title", type="string", description="Title"),
 *        @SWG\Property(property="opening_time", type="datetime", description="Opening Time"),
 *        @SWG\Property(property="closing_time", type="datetime", description="Closing Time"),
 *        @SWG\Property(property="type", type="integer", description="Type"),
 *        @SWG\Property(property="day_of_week", type="integer", description="City of Location"),
 *        @SWG\Property(property="closed", type="boolean", description="Closed?"),
 *        @SWG\Property(property="last_updated", type="datetime", description="Last Updated At"),
 *     ),
 *
 *     @SWG\Definition(
 *        definition="Closure",
 *        type="object",
 *        required={"id"},
 *        @SWG\Property(property="id", type="integer", description="ID of Closure"),
 *        @SWG\Property(property="date_start", type="datetime", description="Closure Start"),
 *        @SWG\Property(property="date_end", type="datetime", description="Closure End"),
 *        @SWG\Property(property="closure_copy", type="string", description="Copy"),
 *        @SWG\Property(property="type", type="integer", description="Type"),
 *        @SWG\Property(property="published", type="boolean", description="Published State of Closure"),
 *     ),
 *
 *     @SWG\Definition(
 *        definition="Exhibition",
 *        type="object",
 *        required={"id"},
 *        @SWG\Property(property="id", type="integer", description="ID of Exhibition"),
 *        @SWG\Property(property="published", type="boolean", description="Published State of Exhibition"),
 *        @SWG\Property(property="header_copy", type="string", description="Header Copy"),
 *        @SWG\Property(property="content", type="json", description="Content"),
 *        @SWG\Property(property="datahub_id", type="string", description="Datahub ID"),
 *        @SWG\Property(property="exhibition_message", type="string", description="Message"),
 *        @SWG\Property(property="cms_exhibition_type", type="integer", description="Type (basic = 0, large = 1, special = 2)"),
 *        @SWG\Property(property="created_at", type="datetime", description="Created Timestamp"),
 *     ),
 *
 *     @SWG\Definition(
 *        definition="Event",
 *        type="object",
 *        required={"id"},
 *        @SWG\Property(property="id", type="integer", description="ID of Event"),
 *        @SWG\Property(property="title", type="string", description="Title"),
 *        @SWG\Property(property="published", type="boolean", description="Published State of Event"),
 *        @SWG\Property(property="type", type="integer", description="Event type (classes_and_workshops = 1, live_arts = 2, screenings = 3, special_event = 4, talks = 5, tour = 6, communities = 7)"),
 *        @SWG\Property(property="short_description", type="string", description="Short Description"),
 *        @SWG\Property(property="description", type="string", description="Description"),
 *        @SWG\Property(property="list_description", type="string", description="List Description"),
 *        @SWG\Property(property="hero_caption", type="string", description="Hero Caption"),
 *        @SWG\Property(property="is_private", type="boolean", description="Is Private?"),
 *        @SWG\Property(property="is_after_hours", type="boolean", description="Is After Hours?"),
 *        @SWG\Property(property="is_ticketed", type="boolean", description="Is Tickted?"),
 *        @SWG\Property(property="is_free", type="boolean", description="Is Free?"),
 *        @SWG\Property(property="is_member_exclusive", type="boolean", description="Is Member Exclusive?"),
 *        @SWG\Property(property="is_registration_required", type="boolean", description="Is Registration Required?"),
 *        @SWG\Property(property="hidden", type="boolean", description="Hidden?"),
 *        @SWG\Property(property="rsvp_link", type="string", description="RSVP Link"),
 *        @SWG\Property(property="start_time", type="string", description="Start time"),
 *        @SWG\Property(property="end_time", type="string", description="End time"),
 *        @SWG\Property(property="all_dates", type="json", description="A list of all the dates that this event occurs on"),
 *        @SWG\Property(property="forced_date", type="string", description="Forced date display"),
 *        @SWG\Property(property="location", type="string", description="Location"),
 *        @SWG\Property(property="audience", type="integer", description="Audience (families = 1, members = 2, adults = 3, teens = 4, researchers_scholars = 5, teachers = 6, evening_associates = 7)"),
 *        @SWG\Property(property="content", type="json", description="Content"),
 *        @SWG\Property(property="layout_type", type="integer", description="Layout Type (basic_layout = 0, large_layout = 1)"),
 *        @SWG\Property(property="buy_button_text", type="string", description="Buy Button Text"),
 *        @SWG\Property(property="buy_button_caption", type="string", description="Buy Button Caption"),
 *        @SWG\Property(property="slug", type="string", description="Slug"),
 *        @SWG\Property(property="web_url", type="string", description="Web Url"),
 *        @SWG\Property(property="created_at", type="datetime", description="Created Timestamp"),
 *        @SWG\Property(property="is_sold_out", type="boolean", description="Is sold out?"),
 *        @SWG\Property(property="buy_tickets_link", type="string", description="Buy tickets URL"),
 *     ),
 *
 *     @SWG\Definition(
 *        definition="Article",
 *        type="object",
 *        required={"id"},
 *        @SWG\Property(property="id", type="integer", description="ID of Article"),
 *        @SWG\Property(property="title", type="string", description="Title"),
 *        @SWG\Property(property="published", type="boolean", description="Published State of Article"),
 *        @SWG\Property(property="date", type="datetime", description="Date"),
 *        @SWG\Property(property="copy", type="json", description="Copy"),
 *        @SWG\Property(property="is_boosted", type="boolean", description="Is Boosted"),
 *        @SWG\Property(property="slug", type="string", description="Slug"),
 *        @SWG\Property(property="web_url", type="string", description="Web Url"),
 *        @SWG\Property(property="heading", type="string", description="Heading"),
 *        @SWG\Property(property="author", type="string", description="Author"),
 *        @SWG\Property(property="created_at", type="datetime", description="Created Timestamp"),
 *        @SWG\Property(property="subtype", type="string", description="Subtype / Label"),
 *     ),
 *
 *     @SWG\Definition(
 *        definition="Selection",
 *        type="object",
 *        required={"id"},
 *        @SWG\Property(property="id", type="integer", description="ID of Selection"),
 *        @SWG\Property(property="title", type="string", description="Title"),
 *        @SWG\Property(property="published", type="boolean", description="Published State of Article"),
 *        @SWG\Property(property="updated_at", type="datetime", description="updated_at"),
 *        @SWG\Property(property="content", type="json", description="Content"),
 *        @SWG\Property(property="short_copy", type="string", description="Short Copy"),
 *        @SWG\Property(property="slug", type="string", description="Slug"),
 *        @SWG\Property(property="web_url", type="string", description="Web Url"),
 *        @SWG\Property(property="created_at", type="datetime", description="Created Timestamp"),
 *     ),
 *
 *     @SWG\Definition(
 *        definition="Artist",
 *        type="object",
 *        required={"id"},
 *        @SWG\Property(property="id", type="integer", description="ID of Artist"),
 *        @SWG\Property(property="intro", type="string", description="Intro Copy"),
 *        @SWG\Property(property="datahub_id", type="string", description="datahub_id"),
 *        @SWG\Property(property="created_at", type="datetime", description="Created Timestamp"),
 *     ),
 *
 *     @SWG\Definition(
 *        definition="Page",
 *        type="object",
 *        required={"id"},
 *        @SWG\Property(property="id", type="integer", description="ID of the page"),
 *        @SWG\Property(property="title", type="string", description="Title"),
 *        @SWG\Property(property="published", type="boolean", description="Published State of Page"),
 *        @SWG\Property(property="type", type="integer", description="Type"),
 *        @SWG\Property(property="home_intro", type="string", description="home_intro"),
 *        @SWG\Property(property="exhibition_intro", type="string", description="exhibition_intro"),
 *        @SWG\Property(property="art_intro", type="string", description="art_intro"),
 *        @SWG\Property(property="visit_intro", type="string", description="visit_intro"),
 *        @SWG\Property(property="slug", type="string", description="Slug"),
 *        @SWG\Property(property="web_url", type="string", description="Web Url"),
 *        @SWG\Property(property="created_at", type="datetime", description="Created Timestamp"),
 *        @SWG\Property(property="exhibition_history_sub_heading", type="string", description="Exhibition History Sub Heading"),
 *        @SWG\Property(property="exhibition_history_intro_copy", type="string", description="Exhibition History Intro Copy"),
 *        @SWG\Property(property="exhibition_history_popup_copy", type="string", description="Exhibition History Popup Copy"),
 *        @SWG\Property(property="visit_hour_header", type="string", description="Visit Hour Header"),
 *        @SWG\Property(property="visit_hour_subheader", type="string", description="Visit hour Subheader"),
 *        @SWG\Property(property="visit_city_pass_title", type="string", description="Visit City Pass Title"),
 *        @SWG\Property(property="visit_city_pass_text", type="string", description="Visit City Pass Text"),
 *        @SWG\Property(property="visit_admission_description", type="string", description="Visit Admission Description"),
 *        @SWG\Property(property="content", type="json", description="Content"),
 *     ),
 *
 *     @SWG\Definition(
 *        definition="GenericPage",
 *        type="object",
 *        required={"id"},
 *        @SWG\Property(property="id", type="integer", description="ID of Generic Page"),
 *        @SWG\Property(property="title", type="string", description="Title"),
 *        @SWG\Property(property="published", type="boolean", description="Published State of Generic Page"),
 *        @SWG\Property(property="publish_start_date", type="datetime", description="Publish Start Date"),
 *        @SWG\Property(property="publish_end_date", type="datetime", description="Publish End Time"),
 *        @SWG\Property(property="listing_description", type="string", description="Listing Description"),
 *        @SWG\Property(property="short_description", type="string", description="Short Description"),
 *        @SWG\Property(property="slug", type="string", description="Slug"),
 *        @SWG\Property(property="web_url", type="string", description="Web Url"),
 *        @SWG\Property(property="created_at", type="datetime", description="Created Timestamp"),
 *        @SWG\Property(property="last_updated_at", type="datetime", description="Updated Timestamp"),
 *        @SWG\Property(property="content", type="json", description="Content"),*
 *     ),
 *
 *     @SWG\Definition(
 *        definition="PressRelease",
 *        type="object",
 *        required={"id"},
 *        @SWG\Property(property="id", type="integer", description="ID of Press Release"),
 *        @SWG\Property(property="title", type="string", description="Title"),
 *        @SWG\Property(property="published", type="boolean", description="Published State of Press Release"),
 *        @SWG\Property(property="publish_start_date", type="datetime", description="Publish Start Date"),
 *        @SWG\Property(property="publish_end_date", type="datetime", description="Publish End Time"),
 *        @SWG\Property(property="listing_description", type="string", description="Listing Description"),
 *        @SWG\Property(property="short_description", type="string", description="Short Description"),
 *        @SWG\Property(property="slug", type="string", description="Slug"),
 *        @SWG\Property(property="web_url", type="string", description="Web Url"),
 *        @SWG\Property(property="created_at", type="datetime", description="Created Timestamp"),
 *        @SWG\Property(property="last_updated_at", type="datetime", description="Updated Timestamp"),
 *        @SWG\Property(property="content", type="json", description="Content"),*
 *     ),
 *
 *     @SWG\Definition(
 *        definition="ResearchGuide",
 *        type="object",
 *        required={"id"},
 *        @SWG\Property(property="id", type="integer", description="ID"),
 *        @SWG\Property(property="title", type="string", description="Title"),
 *        @SWG\Property(property="published", type="boolean", description="Published State"),
 *        @SWG\Property(property="publish_start_date", type="datetime", description="Publish Start Date"),
 *        @SWG\Property(property="publish_end_date", type="datetime", description="Publish End Time"),
 *        @SWG\Property(property="listing_description", type="string", description="Listing Description"),
 *        @SWG\Property(property="short_description", type="string", description="Short Description"),
 *        @SWG\Property(property="slug", type="string", description="Slug"),
 *        @SWG\Property(property="web_url", type="string", description="Web Url"),
 *        @SWG\Property(property="created_at", type="datetime", description="Created Timestamp"),
 *        @SWG\Property(property="last_updated_at", type="datetime", description="Updated Timestamp"),
 *        @SWG\Property(property="content", type="json", description="Content"),*
 *     ),
 *
 *     @SWG\Definition(
 *        definition="EducatorResource",
 *        type="object",
 *        required={"id"},
 *        @SWG\Property(property="id", type="integer", description="ID"),
 *        @SWG\Property(property="title", type="string", description="Title"),
 *        @SWG\Property(property="published", type="boolean", description="Published State"),
 *        @SWG\Property(property="publish_start_date", type="datetime", description="Publish Start Date"),
 *        @SWG\Property(property="publish_end_date", type="datetime", description="Publish End Time"),
 *        @SWG\Property(property="listing_description", type="string", description="Listing Description"),
 *        @SWG\Property(property="short_description", type="string", description="Short Description"),
 *        @SWG\Property(property="slug", type="string", description="Slug"),
 *        @SWG\Property(property="web_url", type="string", description="Web Url"),
 *        @SWG\Property(property="created_at", type="datetime", description="Created Timestamp"),
 *        @SWG\Property(property="last_updated_at", type="datetime", description="Updated Timestamp"),
 *        @SWG\Property(property="content", type="json", description="Content"),*
 *     ),
 *
 *     @SWG\Definition(
 *        definition="DigitalPublication",
 *        type="object",
 *        required={"id"},
 *        @SWG\Property(property="id", type="integer", description="ID"),
 *        @SWG\Property(property="title", type="string", description="Title"),
 *        @SWG\Property(property="published", type="boolean", description="Published State"),
 *        @SWG\Property(property="publish_start_date", type="datetime", description="Publish Start Date"),
 *        @SWG\Property(property="publish_end_date", type="datetime", description="Publish End Time"),
 *        @SWG\Property(property="listing_description", type="string", description="Listing Description"),
 *        @SWG\Property(property="short_description", type="string", description="Short Description"),
 *        @SWG\Property(property="slug", type="string", description="Slug"),
 *        @SWG\Property(property="web_url", type="string", description="Web Url"),
 *        @SWG\Property(property="created_at", type="datetime", description="Created Timestamp"),
 *        @SWG\Property(property="last_updated_at", type="datetime", description="Updated Timestamp"),
 *        @SWG\Property(property="content", type="json", description="Content"),*
 *     ),
 *
 *     @SWG\Definition(
 *        definition="PrintedCatalog",
 *        type="object",
 *        required={"id"},
 *        @SWG\Property(property="id", type="integer", description="ID"),
 *        @SWG\Property(property="title", type="string", description="Title"),
 *        @SWG\Property(property="published", type="boolean", description="Published State"),
 *        @SWG\Property(property="publish_start_date", type="datetime", description="Publish Start Date"),
 *        @SWG\Property(property="publish_end_date", type="datetime", description="Publish End Time"),
 *        @SWG\Property(property="listing_description", type="string", description="Listing Description"),
 *        @SWG\Property(property="short_description", type="string", description="Short Description"),
 *        @SWG\Property(property="slug", type="string", description="Slug"),
 *        @SWG\Property(property="web_url", type="string", description="Web Url"),
 *        @SWG\Property(property="created_at", type="datetime", description="Created Timestamp"),
 *        @SWG\Property(property="last_updated_at", type="datetime", description="Updated Timestamp"),
 *        @SWG\Property(property="content", type="json", description="Content"),*
 *     ),
 * )
 */

Route::group(['prefix' => 'v1'], function () {

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
     *      path="/api/v1/closures/deleted",
     *      tags={"closures"},
     *      operationId="getDeletedClosures",
     *      summary="List all deleted closures",
     *      @SWG\Response(response="200", description="List all deleted closures")
     *  )
     *
     */
    Route::get('closures/deleted', 'API\ClosuresController@deleted');

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
     *      path="/api/v1/events/deleted",
     *      tags={"events"},
     *      operationId="getDeletedEvents",
     *      summary="List all deleted events",
     *      @SWG\Response(response="200", description="List all deleted events")
     *  )
     *
     */
    Route::get('events/deleted', 'API\EventsController@deleted');

    /**
     * TODO: Add Swagger definitions? This feels redundant.
     */
    Route::get('event-occurrences', 'API\EventOccurrencesController@occurrences');

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
     * - event-programs ------------------------------------------------------
     *
     * @SWG\Get(
     *      path="/api/v1/event-programs",
     *      tags={"events"},
     *      operationId="getEvents",
     *      summary="List all events programs",
     *      @SWG\Response(response="200", description="List all events")
     *  )
     *
     */
    Route::get('event-programs', 'API\EventProgramsController@index');

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
     *      path="/api/v1/articles/deleted",
     *      tags={"articles"},
     *      operationId="getDeletedArticles",
     *      summary="List all deleted articles",
     *      @SWG\Response(response="200", description="List all deleted articles")
     *  )
     *
     */
    Route::get('articles/deleted', 'API\ArticlesController@deleted');

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

    Route::get('staticpages', 'API\StaticPagesController@index');

    Route::get('staticpages/{id}', 'API\StaticPagesController@show');

    Route::get('emailseries', 'API\EmailSeriesController@index');

    Route::get('emailseries/{id}', 'API\EmailSeriesController@show');

    /**
     *
     * - generic pages ------------------------------------------------------
     *
     * @SWG\Get(
     *      path="/api/v1/genericpages",
     *      tags={"pages"},
     *      operationId="getGenericPages",
     *      summary="List all generic pages",
     *      @SWG\Response(response="200", description="List all generic pages")
     *  )
     *
     */
    Route::get('genericpages', 'API\GenericPagesController@index');

    /**
     *
     * @SWG\Get(
     *      path="/api/v1/genericpages/deleted",
     *      tags={"pages"},
     *      operationId="getDeletedGenericPages",
     *      summary="List all deleted generic pages",
     *      @SWG\Response(response="200", description="List all deleted generic pages")
     *  )
     *
     */
    Route::get('genericpages/deleted', 'API\GenericPagesController@deleted');

    /**
     * @SWG\Get(
     *      path="/api/v1/genericpages/{id}",
     *      tags={"pages"},
     *      operationId="getGenericPage",
     *      summary="Fetch generic page details",
     *      @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          type="integer",
     *          description="id",
     *      ),
     *      @SWG\Response(response="200", description="Get a specific generic page")
     *  )
     *
     */
    Route::get('genericpages/{id}', 'API\GenericPagesController@show');

    /**
     *
     * - press releases ------------------------------------------------------
     *
     * @SWG\Get(
     *      path="/api/v1/pressreleases",
     *      tags={"pages"},
     *      operationId="getPressReleases",
     *      summary="List all press releases",
     *      @SWG\Response(response="200", description="List all generic pages")
     *  )
     *
     */
    Route::get('pressreleases', 'API\PressReleasesController@index');

    /**
     *
     * @SWG\Get(
     *      path="/api/v1/pressreleases/deleted",
     *      tags={"pages"},
     *      operationId="getDeletedPressReleases",
     *      summary="List all deleted press releases",
     *      @SWG\Response(response="200", description="List all deleted press releases")
     *  )
     *
     */
    Route::get('pressreleases/deleted', 'API\PressReleasesController@deleted');

    /**
     * @SWG\Get(
     *      path="/api/v1/pressreleases/{id}",
     *      tags={"pages"},
     *      operationId="getPressRelease",
     *      summary="Fetch press releases details",
     *      @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          type="integer",
     *          description="id",
     *      ),
     *      @SWG\Response(response="200", description="Get a specific press release")
     *  )
     *
     */
    Route::get('pressreleases/{id}', 'API\PressReleasesController@show');

    /**
     *
     * - research guides ------------------------------------------------------
     *
     * @SWG\Get(
     *      path="/api/v1/researchguides",
     *      tags={"pages"},
     *      operationId="getResearchGuides",
     *      summary="List all research guides",
     *      @SWG\Response(response="200", description="List all research guides")
     *  )
     *
     */
    Route::get('researchguides', 'API\ResearchGuidesController@index');

    /**
     *
     * @SWG\Get(
     *      path="/api/v1/researchguides/deleted",
     *      tags={"pages"},
     *      operationId="getDeletedResearchGuides",
     *      summary="List all deleted research guides",
     *      @SWG\Response(response="200", description="List all deleted research guides")
     *  )
     *
     */
    Route::get('researchguides/deleted', 'API\ResearchGuidesController@deleted');

    /**
     * @SWG\Get(
     *      path="/api/v1/researchguides/{id}",
     *      tags={"pages"},
     *      operationId="getResearchGuides",
     *      summary="Fetch research guides details",
     *      @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          type="integer",
     *          description="id",
     *      ),
     *      @SWG\Response(response="200", description="Get a specific research guide")
     *  )
     *
     */
    Route::get('researchguides/{id}', 'API\ResearchGuidesController@show');

    /**
     *
     * - educator resources ------------------------------------------------------
     *
     * @SWG\Get(
     *      path="/api/v1/educatorresources",
     *      tags={"pages"},
     *      operationId="getEducatorResources",
     *      summary="List all educator resources",
     *      @SWG\Response(response="200", description="List all educator resources")
     *  )
     *
     */
    Route::get('educatorresources', 'API\EducatorResourcesController@index');

    /**
     *
     * - educator resources ------------------------------------------------------
     *
     * @SWG\Get(
     *      path="/api/v1/educatorresources/deleted",
     *      tags={"pages"},
     *      operationId="getDeletedEducatorResources",
     *      summary="List all deleted educator resources",
     *      @SWG\Response(response="200", description="List all deleted educator resources")
     *  )
     *
     */
    Route::get('educatorresources/deleted', 'API\EducatorResourcesController@deleted');

    /**
     * @SWG\Get(
     *      path="/api/v1/educatorresources/{id}",
     *      tags={"pages"},
     *      operationId="getEducatorResource",
     *      summary="Fetch educator resource details",
     *      @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          type="integer",
     *          description="id",
     *      ),
     *      @SWG\Response(response="200", description="Get a specific educator resource")
     *  )
     *
     */
    Route::get('educatorresources/{id}', 'API\EducatorResourcesController@show');

    /**
     *
     * - digital publications ------------------------------------------------------
     *
     * @SWG\Get(
     *      path="/api/v1/digitalpublications",
     *      tags={"pages"},
     *      operationId="getDigitalPublications",
     *      summary="List all digital publications",
     *      @SWG\Response(response="200", description="List all digital publications")
     *  )
     *
     */
    Route::get('digitalpublications', 'API\DigitalPublicationsController@index');

    /**
     * @SWG\Get(
     *      path="/api/v1/digitalpublications/deleted",
     *      tags={"pages"},
     *      operationId="getDeletedDigitalPublications",
     *      summary="List all deleted digital publications",
     *      @SWG\Response(response="200", description="List all deleted digital publications")
     *  )
     *
     */
    Route::get('digitalpublications/deleted', 'API\DigitalPublicationsController@deleted');

    /**
     * @SWG\Get(
     *      path="/api/v1/digitalpublications/{id}",
     *      tags={"pages"},
     *      operationId="getDigitalPublication",
     *      summary="Fetch digital publication details",
     *      @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          type="integer",
     *          description="id",
     *      ),
     *      @SWG\Response(response="200", description="Get a specific digital publication")
     *  )
     *
     */
    Route::get('digitalpublications/{id}', 'API\DigitalPublicationsController@show');

    /**
     *
     * - printed publications ------------------------------------------------------
     *
     * @SWG\Get(
     *      path="/api/v1/printedpublications",
     *      tags={"pages"},
     *      operationId="getPrintedPublications",
     *      summary="List all printed publications",
     *      @SWG\Response(response="200", description="List all printed publications")
     *  )
     *
     */
    Route::get('printedpublications', 'API\PrintedPublicationsController@index');

    /**
     *
     * @SWG\Get(
     *      path="/api/v1/printedpublications/deleted",
     *      tags={"pages"},
     *      operationId="getDeletedPrintedPublications",
     *      summary="List all deleted printed publications",
     *      @SWG\Response(response="200", description="List all deleted printed publications")
     *  )
     *
     */
    Route::get('printedpublications/deleted', 'API\PrintedPublicationsController@deleted');

    /**
     * @SWG\Get(
     *      path="/api/v1/printedpublications/{id}",
     *      tags={"pages"},
     *      operationId="getPrintedPublication",
     *      summary="Fetch printed publication details",
     *      @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          type="integer",
     *          description="id",
     *      ),
     *      @SWG\Response(response="200", description="Get a specific printed publication")
     *  )
     *
     */
    Route::get('printedpublications/{id}', 'API\PrintedPublicationsController@show');

    /**
     *
     * - digital labels ------------------------------------------------------
     *
     * @SWG\Get(
     *      path="/api/v1/digital-labels",
     *      tags={"digitalLabels"},
     *      operationId="getDigitalLabel",
     *      summary="List all digital labels",
     *      @SWG\Response(response="200", description="List all digital labels")
     *  )
     *
     */

    Route::get('digital-labels', 'API\DigitalLabelsController@index');
    /**
     * @SWG\Get(
     *      path="/api/v1/digital-labels/{id}",
     *      tags={"digitalLabels"},
     *      operationId="getDigitalLabel",
     *      summary="Fetch digital label details",
     *      @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          type="integer",
     *          description="id",
     *      ),
     *      @SWG\Response(response="200", description="Get a specific digital label")
     *  )
     *
     */
    Route::get('digital-labels/{id}', 'API\DigitalLabelsController@show');

    Route::options('seamless-images/{id}', 'SeamlessImagesController@byFile');
    Route::get('seamless-images/{id}', 'SeamlessImagesController@byFile');
});
