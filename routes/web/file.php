<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::prefix('dashboard/files')->middleware('permission.documents')->group(function () {
        // Quan ly file
        Route::delete('/force-destroy/{id}', 'FileController@forceDestroy')->name('web.files.forceDestroy');
        Route::post('/multiple-delete', 'FileController@multipleDelete')->name('web.files.multipleDelete');
        Route::get('/restore/{id}', 'FileController@restore')->name('web.files.restore');
        Route::post('/update-permission/{id}', 'FileController@updatePermission')->name('web.files.updatePermission');

        //download file from storage
        Route::get('/download/{filename}', 'FileController@downloadFile')->name('web.files.downloadFile');
        Route::get('/pdf-preview/{filename?}', 'FileController@previewPdf')->name('web.files.pdfPreview')->middleware('permission.contracts');
        Route::get('/download-zip-file/{contractId}', 'FileController@downloadZipFile')->name('web.files.downloadZipFile')->middleware('permission.contracts');
    });

    Route::resource('/dashboard/files', 'FileController', ['as' => 'web'])->middleware('permission.documents');

    Route::prefix('dashboard/files')->group(function () {
        Route::get('/pdf-client-preview/{filename?}', 'FileController@previewPdf')->name('web.files.previewPdf');

        // get image from storage
        Route::get('/images/{filename}', 'FileController@getImageFromStorage')->name('web.files.getImageFromStorage');

        //download file from storage
        Route::get('/download-application-file/{applicationId}', 'FileController@downloadApplicationFile')->name('web.files.downloadApplicationFile');
    });
});

Route::get('files/signature-pdf-preview/{id}', 'FileController@signaturePreviewPdf')->name('web.files.signaturePreviewPdf');
