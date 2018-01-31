<?php

Route::name('home')->get('/', 'HomeController@index');

if (!app()->environment('production')) {
  Route::get('/statics/{slug?}', 'StaticsController@index');
}

Route::name('search')->get('/search', 'SearchController@index');
