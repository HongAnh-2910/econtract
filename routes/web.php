<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::view('/signature-complete', 'common.signature_complete')->name('web.commons.signatureComplete');

Route::get('/check-email', 'Auth\ForgotPasswordController@index')->name('check-email');
// social login
Route::get('/auth/{provider}', [App\Http\Controllers\Auth\SocialAuthController::class, 'redirectToProvider'])->name('social-login');
Route::get('/auth/{provide}/callback', [App\Http\Controllers\Auth\SocialAuthController::class, 'handleProviderCallback']);

Route::middleware('auth')->group(function () {
    Route::get('/', 'HomeController@index')->name('dashboard');
    Route::prefix('dashboard')->group(function () {
        //    Dashboard
        Route::get('/', 'HomeController@index')->name('dashboard');

        Route::get('/subscription', 'HomeController@subscription')->name('web.subscription');
        Route::post('/subscription', 'HomeController@subscriptionStore')->name('web.subscriptionStore');
        Route::post('/subscription-validate', 'HomeController@subscriptionValidate')->name('web.subscriptionValidate');

        Route::resource('/signature-list', 'SignatureTemplateController', ['as' => 'web'])->only(['index', 'store', 'destroy']);
        Route::post('/signature-list/restore/{id?}', 'SignatureTemplateController@restore')->name('web.signature-list.restore');
        Route::post('/signature-list/add-image', 'SignatureTemplateController@addImage')->name('web.signature-list.addImage');
    });
});
