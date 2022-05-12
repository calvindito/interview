<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'DashboardController@index');

Route::prefix('employee')->group(function() {
    Route::get('/', 'EmployeeController@index');
    Route::get('load_data_all', 'EmployeeController@loadDataAll');
    Route::get('load_data_first_join', 'EmployeeController@loadDataFirstJoin');
    Route::post('create', 'EmployeeController@create');
    Route::get('show', 'EmployeeController@show');
    Route::post('update/{id}', 'EmployeeController@update');
    Route::post('destroy', 'EmployeeController@destroy');
});

Route::prefix('leave')->group(function() {
    Route::get('/', 'LeaveController@index');
    Route::get('load_current_data', 'LeaveController@loadCurrentData');
    Route::get('load_leave_more_than_one', 'LeaveController@loadLeaveMoreThanOne');
    Route::get('load_leave_over', 'LeaveController@loadLeaveOver');
});
