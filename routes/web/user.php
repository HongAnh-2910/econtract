<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::prefix('dashboard/users')->group(function () {
        // Quan ly user
        Route::get('/search', 'UserController@searchAjax')->name('web.users.searchAjax');
        Route::post('/store', 'UserController@store')->name('web.users.store');
    });
});
