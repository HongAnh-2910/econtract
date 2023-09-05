<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::prefix('dashboard/customers')->middleware('permission.customers')->group(function () {
        //    Customer
        Route::post('/store', 'CustomerController@store')->name('web.customers.store');
        Route::get('/list', 'CustomerController@index')->name('web.customers.list');
        Route::get('/show/{id?}', 'CustomerController@show')->name('web.customers.show');
        Route::post('/update/{id?}', 'CustomerController@update')->name('web.customers.update');
        Route::get('/delete/{id?}', 'CustomerController@delete')->name('web.customers.delete');
        Route::get('/restore/{id?}', 'CustomerController@restore')->name('web.customers.restore');
        Route::get('/permanently-deleted/{id?}', 'CustomerController@permanentlyDeleted')->name('web.customers.permanentlyDeleted');
        Route::get('/live-search/{keyword?}', 'CustomerController@liveSearch')->name('web.customers.liveSearch');
        Route::delete('/delete-multiple-customer', 'CustomerController@deleteMultipleCustomer')->name('web.customers.deleteMultipleCustomer');
        Route::get('/restore-multiple-customer', 'CustomerController@restoreMultipleCustomer')->name('web.customers.restoreMultipleCustomer');
        Route::get('/permanently-deleted-multiple-customer', 'CustomerController@permanentlyDeletedMultipleCustomer')->name('web.customers.permanentlyDeletedMultipleCustomer');
        Route::get('/export', 'CustomerController@exportExcel')->name('web.customers.exportExcel');
        Route::post('/import', 'CustomerController@importExcel')->name('web.customers.importExcel');
    });

    Route::post('dashboard/customers/search/banking', 'CustomerController@getBankingName')->name('customer.banking');
});

