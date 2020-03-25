<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => '\Unite\UnisysApi\Modules\Users\Http\Controllers',
    'as'        => 'api.user.',
    'prefix'    => 'user',
], function () {
    Route::get('profile', [
        'as'   => 'profile',
        'uses' => 'UserController@profile',
    ]);

    Route::get('/', [
        'as'   => 'list',
        'uses' => 'UserController@list',
    ]);

    Route::get('{id}', [
        'as'   => 'show',
        'uses' => 'UserController@show',
    ]);

    Route::get('{id}/notifications', [
        'as'   => 'notifications',
        'uses' => 'UserController@notifications',
    ]);

    Route::get('{id}/unreadNotifications', [
        'as'   => 'unreadNotifications',
        'uses' => 'UserController@unreadNotifications',
    ]);

    Route::get('notifications', [
        'as'   => 'selfNotifications',
        'uses' => 'UserController@selfNotifications',
    ]);

    Route::get('unreadNotifications', [
        'as'   => 'selfUnreadNotifications',
        'uses' => 'UserController@selfUnreadNotifications',
    ]);

    Route::put('markAllNotificationsAsRead', [
        'as'   => 'markAllNotificationsAsRead',
        'uses' => 'UserController@markAllNotificationsAsRead',
    ]);

    Route::post('/', [
        'as'   => 'create',
        'uses' => 'UserController@create',
    ]);

    Route::put('{id}', [
        'as'   => 'update',
        'uses' => 'UserController@update',
    ]);

    Route::group([ 'as' => 'notification.', 'prefix' => 'notification' ], function () {
        Route::put('{uid}/markAsRead', [
            'as'   => 'markAsRead',
            'uses' => 'NotificationController@markAsRead',
        ]);

        Route::put('{uid}/markAsUnread', [
            'as'   => 'markAsUnread',
            'uses' => 'NotificationController@markAsUnread',
        ]);
    });
});