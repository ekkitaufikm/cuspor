<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Auth'], function () {
    Route::get('/', 'LoginController@showLoginForm')->name('/');
    Route::post('/login', 'LoginController@login')->name('login');
    Route::post('/logout', 'LoginController@logout')->name('logout');
    Route::get('/reload-captcha', ('LoginController@reloadCaptcha'));
})->middleware('guest');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', 'DashboardController@dashboard')->name('dashboard');

    //Company
    Route::prefix('company')->group(function(){
        Route::get('/', 'CompanyController@index')->name('company');
        Route::get('/create', 'CompanyController@create')->name('company.create');
        Route::post('/create/save', 'CompanyController@store')->name('company.store');
        Route::get('/detail/{id?}', 'CompanyController@show')->name('company.detail');
        Route::get('/edit/{id?}', 'CompanyController@edit')->name('company.edit');
        Route::put('/edit/save/{id?}', 'CompanyController@update')->name('company.update');
        Route::post('/delete/{id?}', 'CompanyController@destroy')->name('company.destroy');
    });

    //Users
    Route::prefix('users')->group(function(){
        Route::get('/', 'UserController@index')->name('users');
        Route::get('/create', 'UserController@create')->name('users.create');
        Route::post('/create/save', 'UserController@store')->name('users.store');
        Route::get('/detail/{id?}', 'UserController@show')->name('users.detail');
        Route::get('/edit/{id?}', 'UserController@edit')->name('users.edit');
        Route::put('/edit/save/{id?}', 'UserController@update')->name('users.update');
        Route::post('/delete/{id?}', 'UserController@destroy')->name('users.destroy');
    });
    
    //UserGroup
    Route::prefix('user-group')->group(function(){
        Route::get('/', 'UserGroupController@index')->name('user-group');
        Route::get('/create', 'UserGroupController@create')->name('user-group.create');
        Route::post('/create/save', 'UserGroupController@store')->name('user-group.store');
        Route::get('/edit/{id?}', 'UserGroupController@edit')->name('user-group.edit');
        Route::put('/edit/save/{id?}', 'UserGroupController@update')->name('user-group.update');
        Route::post('/delete/{id?}', 'UserGroupController@destroy')->name('user-group.destroy');
    });

    //Customer Satisfaction
    Route::prefix('customer-satisfaction')->group(function(){
        Route::get('/', 'CustomerSatisfactionController@index')->name('customer-satisfaction');
        Route::get('/add-survey/{id?}', 'CustomerSatisfactionController@create')->name('customer-satisfaction.create');
        Route::post('/add-survey/save/{id?}', 'CustomerSatisfactionController@store')->name('customer-satisfaction.store');
        Route::get('/show/{id?}', 'CustomerSatisfactionController@show')->name('customer-satisfaction.show');
        Route::get('/print/{id?}', 'CustomerSatisfactionController@print')->name('customer-satisfaction.print');
        Route::post('/delete/{id?}', 'CustomerSatisfactionController@destroy')->name('customer-satisfaction.destroy');
    });

    //Customer Complaint
    Route::prefix('customer-complaint')->group(function(){
        Route::get('/', 'CustomerComplaintController@index')->name('customer-complaint');
        Route::get('/add-survey/{id?}', 'CustomerComplaintController@create')->name('customer-complaint.create');
        Route::post('/add-survey/save/{id?}', 'CustomerComplaintController@store')->name('customer-complaint.store');
        Route::get('/show/{id?}', 'CustomerComplaintController@show')->name('customer-complaint.show');
        Route::get('/print/{id?}', 'CustomerComplaintController@print')->name('customer-complaint.print');
        Route::post('/delete/{id?}', 'CustomerComplaintController@destroy')->name('customer-complaint.destroy');
    });
});
