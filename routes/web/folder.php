<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::prefix('dashboard/folders')->middleware('permission.documents')->group(function () {
        // Document
        Route::delete('/force-destroy/{id}', 'FolderController@forceDestroy')->name('web.folders.forceDestroy');
        Route::get('/restore/{id}', 'FolderController@restore')->name('web.folders.restore');
        Route::post('/multiple-force-delete', 'FolderController@multipleForceDelete')->name('web.folders.multipleForceDelete');
        Route::post('/multiple-restore', 'FolderController@multipleRestore')->name('web.folders.multipleRestore');
        Route::get('/show/ajax', 'FolderController@showFolderAjax')->name('web.folders.showFolderAjax');
        Route::get('/show/file-child/{id}', 'FolderController@showFolderChild')->name('web.folders.showFolderChild');
        Route::post('/moved/update', 'FolderController@folderMoved')->name('web.folders.folderMoved');
        Route::get('/rename/edit', 'FolderController@folderRename')->name('web.folders.folderRename');
        Route::put('/rename/update/{id}', 'FolderController@folderRenameUpdate')->name('web.folders.folderRenameUpdate');
        Route::get('/export-file', 'FolderController@exportFiles')->name('web.folders.exportFiles');
        Route::post('/update-permission/{id}', 'FolderController@updateFolderPermission')->name('web.folders.updateFolderPermission');
    });

    Route::resource('/dashboard/folders', 'FolderController', ['as' => 'web'])->parameters([
        'folders' => 'folders:slug'
    ]);

    Route::get('dashboard/files/search-ajax', 'FolderController@searchAjax')->name('web.folders.searchAjax');
});
