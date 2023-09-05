<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::prefix('dashboard/contracts')->middleware('permission.contracts')->group(function () {
        // Quản lý hop dong
        Route::post('/publish', 'ContractController@publishContract')->name('web.contracts.publishContract');
        Route::get('/create/{type}', 'ContractController@create')->name('web.contracts.create')->where('type', 'personal|company');
        Route::get('/get-data', 'ContractController@getData')->name('web.contracts.getData');
        Route::get('/sign/{id?}', 'ContractController@sign')->name('web.contracts.sign');
        Route::get('/file/{id}', 'ContractController@contractFile')->name('web.contracts.contractFile');
        Route::get('/search/ajax', 'ContractController@searchAjax')->name('web.contracts.searchAjax');
        Route::post('/search/banking', 'ContractController@searchBanking')->name('web.contracts.searchBanking');
        Route::post('/search/customer', 'ContractController@searchCustomer')->name('web.contracts.searchCustomer');
        Route::post('/store', 'ContractController@store')->name('web.contracts.store');
        Route::post('/ajax/show', 'ContractController@show')->name('web.contracts.show');
        Route::post('/list-receivers', 'ContractController@listReceivers')->name('web.contracts.listReceivers');
        Route::post('/list/upload-files', 'ContractController@listUploadFiles')->name('web.contracts.listUploadFiles');
        Route::get('/detail', 'ContractController@contractDetail')->name('web.contracts.contractDetail');
        Route::get('/edit/{slug}', 'ContractController@contractEdit')->name('web.contracts.contractEdit');
        Route::put('/update/{id}', 'ContractController@contractUpdate')->name('web.contracts.contractUpdate');
        Route::get('/get-banking', 'ContractController@getBanking')->name('web.contracts.getBanking');
        Route::post('/get-customer', 'ContractController@getCustomer')->name('web.contracts.getCustomer');
        Route::get('/fast-signature/{id}', 'ContractController@fastSignature')->name('web.contracts.fastSignature');
        Route::post('/store-file-signature', 'ContractController@storeFileSignature')->name('web.contracts.storeFileSignature');
        Route::post('/resend-email', 'ContractController@resendEmail')->name('web.contracts.resendEmail');
        Route::post('/delete', 'ContractController@deleteContract')->name('web.contracts.deleteContract');
        Route::post('/sign-send-mail', 'ContractController@sendMail')->name('web.contracts.sendMail');
        Route::post('/client-send-email', 'ContractController@clientSendMail')->name('web.contracts.clientSendMail');
    });

    Route::prefix('dashboard/contracts')->group(function () {
        Route::get('/', 'ContractController@index')->name('web.contracts.index');
        Route::get('/company', 'ContractController@indexCompany')->name('web.contracts.indexCompany');
    });
});

Route::prefix('/contracts')->group(function () {
    Route::post('/remote-signature', 'ContractController@remoteSignature')->name('web.contracts.remoteSignature');
    Route::post('/get-remote-access-token', 'ContractController@getRemoteAccessToken')->name('web.contracts.getRemoteAccessToken');
    Route::post('/review-file-pdf', 'ContractController@reviewFilePdf')->name('web.contracts.reviewFilePdf');
    Route::post('/test-fpdi', 'ContractController@testFPDI')->name('web.contracts.testFPDI');

    Route::get('/client-sign/{token?}', 'ContractController@clientSignature')->name('web.contracts.clientSignature');
    Route::get('/client-sign-follow/{token?}', 'ContractController@clientSignatureFollow')->name('web.contracts.clientSignatureFollow');
    Route::post('/client-active-follow/{token?}', 'ContractController@clientActiveFollow')->name('web.contracts.clientActiveFollow');
    Route::post('/client/upload', 'ContractController@clientUpload')->name('web.contracts.clientUpload');
});

