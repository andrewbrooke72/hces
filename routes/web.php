<?php

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
Route::group(['prefix' => '/'], function () {
    Route::name('login')->get('', 'AuthController@index')->middleware('system_setup', 'guest');
    Route::group(['prefix' => 'setup/', 'middleware' => 'guest'], function () {
        Route::name('getSystemSetup')->get('', 'SystemSetupController@index');
        Route::name('postSystemInstall')->post('', 'SystemSetupController@postInstall');
    });
    Route::group(['prefix' => 'auth/'], function () {
        Route::name('authenticate')->post('', 'AuthController@authenticate')->middleware('guest');
        Route::name('logout')->post('logout', 'AuthController@unauthenticate')->middleware('auth');
    });
    Route::resource('home', 'HomeController')->only([
        'index'
    ]);
    Route::resource('reset', 'PasswordResetController')->only([
        'index', 'store', 'show', 'reset'
    ])->middleware('guest');

    Route::resource('users', 'UserController')->except([
        'show'
    ]);

    Route::resource('benefits', 'BenefitsController')->except([
        'show'
    ]);
    Route::resource('departments', 'DepartmentsController')->except([
        'show'
    ]);

    Route::group(['prefix' => 'settings/'], function () {
        Route::group(['prefix' => 'system/'], function () {
            Route::name('systemsetting.index')->get('', 'SystemSettingController@index');
        });
    });
    Route::group(['prefix' => 'playground/'], function () {
        Route::name('playground.index')->get('', 'PlayGroundController@index');
    });
    Route::group(['prefix' => 'vue/'], function () {
        Route::group(['prefix' => 'notifications'], function () {
            Route::name('notifications.load')->get('/load', 'NotificationController@getNotifications');
            Route::name('notifications.download')->get('/download/{id}', 'NotificationController@downloadAttachedFile');
            Route::name('notifications.markview')->get('/mark/view/{id}', 'NotificationController@markViewed');
        });
    });
});


