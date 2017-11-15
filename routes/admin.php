<?php

Route::name('home')->get('/', '\A17\CmsToolkit\Http\Controllers\Admin\UserController@index');

Route::group(['prefix' => 'general'], function () {
  Route::module('categories');
  Route::module('categorySegments');
});
