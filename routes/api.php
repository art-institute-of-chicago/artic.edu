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


Route::group(['prefix' => 'v1'], function()
{

    Route::get('/', function () {
        return "API";
    });

    Route::get('tags', 'API\TagsController@index');
    Route::get('tags/{id}', 'API\TagsController@show');

    Route::get('locations', 'API\LocationsController@index');
    Route::get('locations/{id}', 'API\LocationsController@show');

    Route::get('hours', 'API\HoursController@index');
    Route::get('hours/{id}', 'API\HoursController@show');

    // Route::get('holidays', 'API\HolidaysController@index');

    Route::get('closures', 'API\ClosuresController@index');
    Route::get('closures/id', 'API\ClosuresController@show');

    // Route::get('modules', 'API\ModulesController@index');
    // Route::get('modules/{id}', 'API\ModulesController@show');

    Route::get('exhibitions', 'API\ExhibitionsController@index');
    Route::get('exhibitions/{id}', 'API\ExhibitionsController@show');

    Route::get('events', 'API\EventsController@index');
    Route::get('events/{id}', 'API\EventsController@show');

    Route::get('articles', 'API\ArticlesController@index');
    Route::get('articles/{id}', 'API\ArticlesController@show');

    Route::get('selections', 'API\SelectionsController@index');
    Route::get('selections/{id}', 'API\SelectionsController@show');

    Route::get('artists', 'API\ArtistsController@index');
    Route::get('artists/{id}', 'API\ArtistsController@show');

});
