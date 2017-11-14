<?php

Route::name('home')->get('/', 'HomeController@index');

Route::name('templates')->get('/', 'TemplatesController@index');
