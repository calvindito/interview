<?php

use Illuminate\Support\Facades\Route;

Route::match(['get', 'post'], '/', 'AuthController@login');
Route::match(['get', 'post'], 'register', 'AuthController@register');
Route::get('logout', 'AuthController@logout');
Route::prefix('dashboard')->group(function() {
    Route::match(['get', 'post'], '/', 'DashboardController@index');
    Route::post('checkable', 'DashboardController@checkable');
    Route::post('destroy', 'DashboardController@destroy');
});
