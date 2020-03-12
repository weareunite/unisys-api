<?php

Route::group([
    'as'     => 'settings.',
    'prefix' => 'settings',
], function () {
    Route::get('/', [
        'as'   => 'list',
        'uses' => 'SettingController@list',
    ]);

    Route::post('create', [
        'as'   => 'create',
        'uses' => 'SettingController@create',
    ]);

    Route::put('update', [
        'as'   => 'update',
        'uses' => 'SettingController@update',
    ]);

    Route::put('delete', [
        'as'   => 'delete',
        'uses' => 'SettingController@delete',
    ]);
});