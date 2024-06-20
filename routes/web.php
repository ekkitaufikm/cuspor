<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Auth'], function () {
    Route::get('/', 'LoginController@showLoginForm')->name('/');
    Route::post('/login', 'LoginController@login')->name('login');
    Route::post('/logout', 'LoginController@logout')->name('logout');
})->middleware('guest');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', 'DashboardController@dashboard')->name('dashboard');

    //Company
    Route::prefix('company')->group(function(){
        Route::get('/', 'CompanyController@index')->name('company');
        Route::get('/create', 'CompanyController@create')->name('company.create');
        Route::post('/', 'CompanyController@store')->name('company.store');
        Route::get('/edit/{id}', 'CompanyController@edit')->name('company.edit');
        Route::put('/{id}', 'CompanyController@update')->name('company.update');
        Route::post('/delete/{id}', 'CompanyController@destroy')->name('company.destroy');
    });

    //Users
    Route::prefix('users')->group(function(){
        Route::get('/', 'UsersController@index')->name('users');
        Route::get('/create', 'UsersController@create')->name('users.create');
        Route::post('/', 'UsersController@store')->name('users.store');
        Route::get('/edit/{id}', 'UsersController@edit')->name('users.edit');
        Route::put('/{id}', 'UsersController@update')->name('users.update');
        Route::post('/delete/{id}', 'UsersController@destroy')->name('users.destroy');
    });
    
    //UserGroup
    Route::prefix('user-group')->group(function(){
        Route::get('/', 'UserGroupController@index')->name('user-group');
        Route::get('/create', 'UserGroupController@create')->name('user-group.create');
        Route::post('/', 'UserGroupController@store')->name('user-group.store');
        Route::get('/edit/{id}', 'UserGroupController@edit')->name('user-group.edit');
        Route::put('/{id}', 'UserGroupController@update')->name('user-group.update');
        Route::post('/delete/{id}', 'UserGroupController@destroy')->name('user-group.destroy');
    });
});
