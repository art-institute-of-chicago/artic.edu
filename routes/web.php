<?php

Route::name('home')->get('/', 'HomeController@index');

if (!app()->environment('production')) {
  /*
  $router->get('/statics/{slug?}', [
    'as' => 'statics.index',
    'uses' => 'StaticsController@index'
  ]);
  */
  Route::get('/statics/{slug?}', 'StaticsController@index');
}
