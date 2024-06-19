<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'Auth\LoginController@__invoke')->name('/');
Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');