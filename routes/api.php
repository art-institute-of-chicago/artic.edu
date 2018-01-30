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

});
