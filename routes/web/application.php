<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::prefix('dashboard/applications')->middleware('permission.letters')->group(function () {
        //    Application
        Route::get('/', 'ApplicationController@index')->name('web.applications.index');
        Route::get('/create', 'ApplicationController@create')->name('web.applications.create');
        Route::get('/create-proposal', 'ApplicationController@createProposal')->name('web.applications.createProposal');
        Route::post('/store', 'ApplicationController@store')->name('web.applications.store');
        Route::post('/store-proposal', 'ApplicationController@storeProposal')->name('web.applications.storeProposal');
        Route::post('/list-upload-files', 'ApplicationController@listUploadFiles')->name('web.applications.listUploadFiles');
        Route::get('/edit/{id}', 'ApplicationController@edit')->name('web.applications.edit');
        Route::get('/edit-proposal/{id}', 'ApplicationController@editProposal')->name('web.applications.editProposal');
        Route::post('/update/{id}', 'ApplicationController@update')->name('web.applications.update');
        Route::post('/update-proposal/{id}', 'ApplicationController@updateProposal')->name('web.applications.updateProposal');
        Route::get('/destroy', 'ApplicationController@destroy')->name('web.applications.destroy');
        Route::get('/restore', 'ApplicationController@restore')->name('web.applications.restore');
        Route::get('/force-delete', 'ApplicationController@forceDeleteApplication')->name('web.applications.forceDeleteApplication');
        Route::get('/show/{id}', 'ApplicationController@show')->name('web.applications.show');
        Route::get('/export-application-for-thought', 'ApplicationController@exportApplicationForThoughtExcel')->name('web.applications.exportApplicationForThoughtExcel');
        Route::get('/export-application-for-proposal', 'ApplicationController@exportApplicationForProposalExcel')->name('web.applications.exportApplicationForProposalExcel');
        Route::post('/import', 'ApplicationController@importExcel')->name('web.applications.importExcel');
        Route::post('/change-status-review/{id?}', 'ApplicationController@changeStatusReview')->name('web.applications.changeStatusReview');
        Route::post('/change-status-not-review/{id?}', 'ApplicationController@changeStatusNotReview')->name('web.applications.changeStatusNotReview');
        Route::get('/live-search/{keyword?}', 'ApplicationController@liveSearch')->name('web.applications.liveSearch');
        Route::get('/change-user-word', 'ApplicationController@changeUserWord')->name('web.applications.changeUserWord');
        Route::post('/change-user-word-check', 'ApplicationController@changeUserWordCheck')->name('web.applications.changeUserWordCheck');
        Route::get('/send-mail', 'ApplicationController@sendMail')->name('web.applications.sendMail');

        //test QrCode
        Route::get('/test-qrcode' ,'ApplicationController@testQrCode')->name('web.applications.testQrCode');
        Route::get('/test-qrcode-active/{id?}' ,'ApplicationController@testQrCodeActive')->name('web.applications.testQrCodeActive');
        Route::post('/create-qrcode' ,'ApplicationController@createQrCode')->name('web.applications.createQrCode');
    });

    Route::get('dashboard/applications/send-mail-return/{id?}' ,'ApplicationController@sendMailReturn')->name('web.applications.sendMailReturn');
});

