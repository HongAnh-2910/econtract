<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'permission.departments'])->group(function () {
    Route::prefix('dashboard/departments')->group(function () {
        //    Department
        Route::get('/add', 'DepartmentController@create')->name('web.departments.add');
        Route::post('/store', 'DepartmentController@store')->name('web.departments.store');
        Route::get('/list', 'DepartmentController@show')->name('web.departments.list');
        Route::get('/edit', 'DepartmentController@edit')->name('web.departments.edit');
        Route::put('/update/{id}', 'DepartmentController@update')->name('web.departments.update');
        Route::delete('/delete/{id}', 'DepartmentController@delete')->name('web.departments.delete');
        Route::post('/restore/{id}', 'DepartmentController@restore')->name('web.departments.restore');
        Route::delete('/face-delete/{id}', 'DepartmentController@faceDelete')->name('web.departments.faceDelete');
        Route::get('/show-tree', 'DepartmentController@showTree')->name('web.departments.showTree');
        Route::get('/tree-child', 'DepartmentController@treeChild')->name('web.departments.treeChild');
    });
});
