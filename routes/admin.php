<?php

// Route::name('home')->get('/', 'ExhibitionController@index');
Route::name('home')->get('/', '\A17\CmsToolkit\Http\Controllers\Admin\UserController@index');

Route::group(['prefix' => 'whatson'], function () {
    Route::module('events');
    Route::module('exhibitions');
});

Route::group(['prefix' => 'general'], function () {
  Route::module('categories');
  Route::module('siteTags');
  Route::module('segments');
});
