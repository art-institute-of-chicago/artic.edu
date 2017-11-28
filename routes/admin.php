<?php

Route::name('home')->get('/', 'PageController@home');
Route::module('pages');

Route::group(['prefix' => 'whatson'], function () {
    Route::module('events');
    Route::module('exhibitions');
});

Route::group(['prefix' => 'general'], function () {
  Route::module('categories');
  Route::module('siteTags');
  Route::module('segments');
});
