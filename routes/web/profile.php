<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::prefix('dashboard/profile')->middleware('permission.members')->group(function () {
        //    Profile
        Route::get('/list/users', 'ProfileController@list')->name('web.profile.list');
        Route::delete('/delete/{id}', 'ProfileController@delete')->name('web.profile.delete');
        Route::post('/restore/{id}', 'ProfileController@restore')->name('web.profile.restore');
        Route::delete('/force-delete/{id}', 'ProfileController@forceDelete')->name('web.profile.forceDelete');
        Route::post('/checkbox-delete', 'ProfileController@checkboxAllUser')->name('web.profile.checkboxAllUser');
        //Quản lý phân quyền phòng ban
        Route::post('/permission-department/update/{id}', 'DepartmentController@updatePermissionDepartment')->name('web.profile.updatePermissionDepartment');
    });

    Route::prefix('dashboard/profile')->group(function () {
        Route::get('/', 'ProfileController@index')->name('web.profile.index');
        Route::put('/edit/{id}', 'ProfileController@update')->name('web.profile.update');
        Route::get('/password', 'ProfileController@profilePassword')->name('web.profile.password');
        Route::post('/change/password', 'ProfileController@changePassword')->name('web.profile.changePassword');
        Route::view('/payments', 'dashboard.payment')->name('web.profile.payment');
    });
});
