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

Route::group([
    'namespace' => '\Unite\UnisysApi\Http\Controllers',
    'middleware' => ['api', 'auth:api', 'authorize'],
    'as' => 'api.'
], function ()
{
    Route::get('/',                                 ['as' => 'index',                       'uses' => 'HomeController@index']);

    Route::group(['as' => 'user.', 'prefix' => 'user'], function ()
    {
        Route::get('profile',                       ['as' => 'profile',                     'uses' => 'UserController@profile']);
        Route::get('/',                             ['as' => 'list',                        'uses' => 'UserController@list']);
        Route::get('{id}',                          ['as' => 'show',                        'uses' => 'UserController@show']);
        Route::get('{id}/notifications',            ['as' => 'notifications',               'uses' => 'UserController@notifications']);
        Route::get('{id}/unreadNotifications',      ['as' => 'unreadNotifications',         'uses' => 'UserController@unreadNotifications']);
        Route::get('notifications',                 ['as' => 'selfNotifications',           'uses' => 'UserController@selfNotifications']);
        Route::get('unreadNotifications',           ['as' => 'selfUnreadNotifications',     'uses' => 'UserController@selfUnreadNotifications']);
        Route::put('markAllNotificationsAsRead',    ['as' => 'markAllNotificationsAsRead',  'uses' => 'UserController@markAllNotificationsAsRead']);

        Route::post('/',                            ['as' => 'create',                      'uses' => 'UserController@create']);
        Route::put('{id}',                          ['as' => 'update',                      'uses' => 'UserController@update']);

    });

    Route::group(['as' => 'userNotification.', 'prefix' => 'userNotification'], function ()
    {
        Route::put('{uid}/markAsRead',              ['as' => 'markAsRead',              'uses' => 'UserNotificationController@markAsRead']);
        Route::put('{uid}/markAsUnread',            ['as' => 'markAsUnread',            'uses' => 'UserNotificationController@markAsUnread']);
    });

    Route::group(['as' => 'role.', 'prefix' => 'role'], function ()
    {
        Route::get('/',                             ['as' => 'list',                    'uses' => 'RoleController@list']);
    });

    Route::group(['as' => 'media.', 'prefix' => 'media'], function ()
    {
        Route::get('/',                             ['as' => 'list',                    'uses' => 'MediaController@list']);
        Route::get('{id}/stream',                   ['as' => 'stream',                  'uses' => 'MediaController@stream']);
        Route::get('{id}/download',                 ['as' => 'download',                'uses' => 'MediaController@download']);
    });
});