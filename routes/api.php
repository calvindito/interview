<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('tax')->group(function() {
    Route::get('data', 'TaxController@data');
    Route::post('create', 'TaxController@create');
    Route::post('update', 'TaxController@update');
    Route::post('destroy', 'TaxController@destroy');
});

Route::prefix('item')->group(function() {
    Route::get('data', 'ItemController@data');
    Route::post('create', 'ItemController@create');
    Route::post('update', 'ItemController@update');
    Route::post('destroy', 'ItemController@destroy');
});
