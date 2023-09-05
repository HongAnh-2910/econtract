<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'permission.humanResources'])->group(function () {
    Route::prefix('dashboard/human-resources')->group(function () {
        //    Human Resource
        Route::get('/list', 'HumanResourceController@index')->name('web.human-resources.list');
        Route::post('/store', 'HumanResourceController@store')->name('web.human-resources.store');
        Route::get('/show/{id?}', 'HumanResourceController@show')->name('web.human-resources.show');
        Route::post('/update/{id?}', 'HumanResourceController@update')->name('web.human-resources.update');
        Route::get('/destroy', 'HumanResourceController@destroy')->name('web.human-resources.destroy');
        Route::get('/restore', 'HumanResourceController@restore')->name('web.human-resources.restore');
        Route::get('/force-delete', 'HumanResourceController@forceDelete')->name('web.human-resources.forceDelete');
        Route::get('/export', 'HumanResourceController@exportExcel')->name('web.human-resources.exportExcel');
        Route::get('/statistical', 'HumanResourceController@statisticalHome')->name('web.human-resources.statistical');
        Route::get('/filter-ajax-chart', 'HumanResourceController@filterYearChart')->name('web.human-resources.filterYearChart');
    });
});

