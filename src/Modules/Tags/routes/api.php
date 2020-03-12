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
    'namespace' => '\Unite\UnisysApi\Modules\Tags\Http\Controllers',
    'middleware' => ['api', 'auth:api', 'authorize'],
    'as' => 'api.'
], function ()
{
    Route::group(['as' => 'tag.', 'prefix' => 'tag'], function ()
    {
        Route::apiResource('tag', 'TagController')
            ->only([
                'index', 'show', 'create', 'update', 'delete'
            ]);
        Route::get('/',                             ['as' => 'list',                    'uses' => 'TagController@list']);
        Route::get('{model}',                       ['as' => 'show',                    'uses' => 'TagController@show']);
        Route::post('/',                            ['as' => 'create',                  'uses' => 'TagController@create']);
        Route::put('{model}',                       ['as' => 'update',                  'uses' => 'TagController@update']);
        Route::delete('{model}',                    ['as' => 'delete',                  'uses' => 'TagController@delete']);
    });
});