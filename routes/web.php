<?php

use Illuminate\Support\Facades\Route;

Route::match(['get', 'post'], '/', 'AuthController@login');
Route::get('logout', 'AuthController@logout');

Route::prefix('dashboard')->group(function() {
    Route::get('/', 'DashboardController@index');
    Route::get('datatable', 'DashboardController@datatable');
    Route::post('create', 'DashboardController@create');
    Route::get('show', 'DashboardController@show');
    Route::post('update/{id}', 'DashboardController@update');
    Route::post('destroy', 'DashboardController@destroy');
});
