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
    'namespace' => '\Unite\UnisysApi\Modules\Media\Http\Controllers',
    'middleware' => ['api', 'auth:api', 'authorize'],
    'as' => 'api.'
], function ()
{
    Route::group(['as' => 'media.', 'prefix' => 'media'], function ()
    {
        Route::get('{model}/stream',                ['as' => 'stream',                      'uses' => 'MediaController@stream']);
        Route::get('{model}/download',              ['as' => 'download',                    'uses' => 'MediaController@download']);
    });
});