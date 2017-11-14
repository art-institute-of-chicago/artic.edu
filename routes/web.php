<?php

Route::name('home')->get('/', 'HomeController@index');

Route::get('/templates/{slug?}', 'TemplatesController@index');
